<?php

namespace App\Http\Controllers;


use App\Models\Banner;
use App\Models\Message;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = User::where(['seller'=> '1', 'status' => 'active'])->orderBy('id','DESC')->get();
        return view('backend.seller.index', compact('sellers'));
    }

    public function sellerStatus(Request $request)
    {
        if($request->mode=='true'){
            DB::table('users')->where('id', $request->id)->update(['status'=>'active']);
        }else{
            DB::table('users')->where('id', $request->id)->update(['status'=>'inactive']);
        }
        return response()->json(['msg'=>'Successfully updated status', 'status' =>true]);
    }

    public function sellerVerified(Request $request)
    {
        if($request->mode=='true'){
            DB::table('users')->where('id', $request->id)->update(['is_verified'=>1]);
        }else{
            DB::table('users')->where('id', $request->id)->update(['is_verified'=>0]);
        }
        return response()->json(['msg'=>'Successfully updated', 'status' =>true]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            return back()->with('error', 'Seller not found');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return back()->with('error', 'Seller not found');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return back()->with('error', 'Seller not found');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return back()->with('error', 'Seller not found');

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
        return back()->with('error', 'Seller not found');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return back()->with('error', 'Seller not found');

    }
}
