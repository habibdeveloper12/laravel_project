<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;

use App\Models\TransactionsLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            return back();
    }

    public function orderStatus(Request $request)
    {
        $order= Order::find($request->input('order_id'));
        $product =Product::where(['title' => $order->product])->first();

        if($order){

            if($request->input('condition') == 'delivered'){
                if($order->condition == 'delivered'){
                    return back()->with('error', 'Order has been delivered before');
                }else{
                    $status = $order->update(['condition' => 'delivered']);

                    $status = Message::create([
                        'user_id' => Auth::user()->user_id,
                        'receiver_id' => $order->user_id,
                        'admin_id'=>'note',
                        'body' => "Seller has delivered your order with order ID #" . $order->order_number,
                    ]);


                    $buyer = User::where('user_id', $order->user_id)->first();
                    try{
                        $buyer->notify(new \App\Notifications\GenericNotification('GG-Trade Order Notification', 'Order #'.$order->order_number . ' has been delivered'));

                        MailController::orderDelivered($buyer->username, $buyer->email, $order->order_number, route('user-order.index').'/'. $order->id );

                    }catch(\Exception $e){
                        return back()->with('error', 'Something went wrong.');
                    };

                }


            }else if($request->input('condition') == 'cancelled'){
                if($order->condition == 'cancelled'){
                    return back()->with('error', 'Order has been cancelled before');
                }else{
                    $status = $order->update(['condition' => 'cancelled']);

                    $status = Message::create([
                        'user_id' => Auth::user()->user_id,
                        'receiver_id' => $order->user_id,
                        'admin_id'=>'cancelled',
                        'body' => "Order ID #" . $order->order_number. " has been cancelled and refunded by seller",
                    ]);

                    $buyer = User::where('user_id' , $order->user_id)->first();


                    $new_balance = $buyer->balance + $order->total;

                    $check1 = $buyer->update(['balance'=> $new_balance ]);


                    $data2['user_id'] =$buyer->user_id;
                    $data2['status'] ='pending';
                    $data2['type'] ='credit';
                    $data2['description'] =Str::upper('Credit alert.  Order #' .$order['order_number']. ' was refunded' );
                    $data2['amount'] =$order->total;

                    $check2 = TransactionsLog::create($data2);

                    try{
                        $buyer->notify(new \App\Notifications\GenericNotification('GG-Trade Order Notification ', 'Order #'.$order->order_number . ' has been cancelled and refunded '));

                        MailController::orderCancelled($buyer->username, $buyer->email, $order->order_number, route('user-order.index') .'/'. $order->id );

                    }catch(\Exception $e){
                        return back()->with('error', 'Something went wrong.');
                    };


                }


            }else{
                $status = $order->update(['condition'=> $request->input('condition')]);
            }


            if($status){
                return back()->with('success', 'Order successfully updated');
            }else{
                return back()->with('error', 'Something went wrong');
            }


        }else{
            return back()->with('error', 'Something went wrong');
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
        $user = Auth::user();

        if($user) {
            if(is_numeric($id)){
                $order = Order::where(['id' => $id, 'seller' => $user->user_id, 'payment_status' =>'paid'])->first();

                if($order){
                    $product = Product::where('title', $order->product)->first();

                    $buyer = User::where('user_id', $order->user_id)->first();
                    $seller = User::where('user_id', $order->user_id)->first();

                    $subscribe = \NotificationChannels\WebPush\PushSubscription::where('subscribable_id', $user->id)->first();

                    $messages = Message::where('receiver_id', $seller->user_id)
                        ->where('user_id', crc32($user->email))
                        ->orWhere('user_id', $seller->user_id)
                        ->where('receiver_id', crc32($user->email))
                        ->orWhere('user_id', 'admin')
                        ->get();

                    return view('seller.order.show', compact(['user', 'order', 'product', 'order','seller','messages', 'subscribe']));
                }



            }
        }else{
            return back()->with('error', 'Please Login to continue!');
        }
        abort(404);
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
