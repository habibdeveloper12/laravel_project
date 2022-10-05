<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\UserReview;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function userReview(Request $request){
        $this-> validate($request, [
            'rate' => 'required|numeric',
            'review' => 'nullable|string',
            'seller_id' => 'required|numeric',
            'order_id' => 'required|exists:orders,id',
            'buyer_id' => 'required|exists:users,user_id',
        ]);
        $data = $request->all();

        $data['reviewer'] = Auth::user()->user_id;
        if($data['reviewer'] == $data['seller_id']){
            $data['reviewed'] = $data['buyer_id'];
        }else{
            $data['reviewed'] = $data['seller_id'];
        }


        $status= UserReview::create($data);

        if($status){
            $review = \App\Models\UserReview::where('reviewed', $data['reviewed'])->get()->avg('rate');
            User::where('user_id', $data['reviewed'])->update([
                'avg_rating' => $review
            ]);

            return back()->with('success', 'Thanks for your feedback');
        }else{
            return back()->with('error', 'Please try again');
        }

    }

    public function userReviewUpdate(Request $request){
        $this-> validate($request, [
            'rate' => 'required|numeric',
            'review' => 'nullable|string',
            'order_id' => 'required|exists:orders,id',
        ]);

        $status = UserReview::where(['order_id' => $request->order_id, 'reviewer' => Auth::user()->user_id])->update([
            'rate' => $request->rate,
            'review' => $request->review
        ]);
        $reviewed = UserReview::where(['order_id' => $request->order_id, 'reviewer' => Auth::user()->user_id])->first()->reviewed;
        if($status){
            $review = \App\Models\UserReview::where('reviewed', $reviewed)->get()->avg('rate');

            User::where('user_id', $reviewed)->update([
                'avg_rating' => $review
            ]);
            return back()->with('success', 'Review updated successful');
        }else{
            return back()->with('error', 'Please try again');
        }

    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
