<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::orderBy('id','DESC')->get();
        return view('backend.coupon.index', compact('coupons'));
    }

    public function couponStatus(Request $request)
    {
        dd($request->all());
        if($request->mode=='true'){
            DB::table('coupons')->where('id', $request->id)->update(['status'=>'active']);
        }else{
            DB::table('coupons')->where('id', $request->id)->update(['status'=>'inactive']);
        }
        return response()->json(['msg'=>'Successfully updated status', 'status' =>true]);
    }

    public function create()
    {
        return view('backend.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this-> validate($request, [
            'code' => 'required|min:2',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric',
            'status' => 'required|in:active,inactive',
        ]);
        $data =$request->all();

        $status = Coupon::create($data);
        if($status){
            return redirect()->route('coupon.index')->with('success', 'Coupon successfully created!');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupon::find($id);

        if($coupon){
            return view('backend.coupon.edit', compact('coupon'));
        }else{
            return back()->with('error', 'Coupon not found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::find($id);
        if($coupon){
            $this-> validate($request, [
                'code' => 'required|min:2',
                'type' => 'required|in:fixed,percent',
                'value' => 'required|numeric',
                'status' => 'required|in:active,inactive',
            ]);
            $data =$request->all();
            $status = $coupon->fill($data)->save();

            if($status){
                return redirect()->route('coupon.index')->with('success', 'Successfully updated coupon!');
            }else{
                return back()->with('error', 'Something went wrong!');
            }
        }else{
            return back()->with('error', 'Coupon not found');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = Coupon::find($id);
        if($coupon){
            $status =$coupon->delete();
            if($status){
                return redirect()->route('coupon.index')->with('success', 'Coupon Successfully deleted');
            }else{
                return back()->with('error', 'Something went wrong');
            }
        }else{
            return back()->with('error', 'Data not found');
        }
    }



}
