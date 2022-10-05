<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth('admin')->user();

        if($user){
            $orders = Order::orderBy('id', 'DESC')->get();
            foreach($orders as $mess){
                if($mess->is_seen_admin == '0'){
                    Order::where('id', $mess->id)->update(['is_seen_admin' => '1']);
                }
            }
            return view('backend.order.index', compact('orders'));
        }else{
            return redirect()->route('user.auth');
        }

    }

    public function orderStatus(Request $request)
    {
        $user = auth('admin')->user();

        if($user) {
            $order = Order::find($request->input('order_id'));

            if ($order) {
                    $status = Order::where('id', $request->input('order_id'))->update(['condition' => $request->input('condition')]);

                if ($status) {
                    return back()->with('success', 'Order successfully updated');
                } else {
                    return back()->with('error', 'Something went wrong');
                }

            } else {
                return back()->with('error', 'Something went wrong');
            }
        }else{
            return redirect()->route('user.auth');
        }
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
        $user = auth('admin')->user();

        if($user) {
            $order = Order::find($id);

            $seller = User::where('user_id', $order->seller)->first();
            $buyer = User::where('user_id', $order->user_id)->first();

            $messages = Message::where('receiver_id', $seller->user_id)
                ->where('user_id', $buyer->user_id)
                ->orWhere('user_id', $seller->user_id)
                ->where('receiver_id', $buyer->user_id)
                ->orWhere('user_id', 'admin')
                ->get();



            if ($order) {
                return view('backend.order.show', compact('order', 'messages', 'buyer', 'seller'));
            }
            abort(404);

        }else{
            return redirect()->route('user.auth')->with('error', 'Please login to account first!');
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
    }
}
