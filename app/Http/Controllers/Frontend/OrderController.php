<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Models\AdminNotification;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use App\Models\TransactionsLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $user = Auth::user();


        if($user){
            $orders = Order::orderBy('id', 'DESC')->where(['user_id' => $user->user_id, 'payment_status' => 'paid'])->get();

            foreach($orders as $index=> $ord){
                  Order::where('user_id', $user->user_id)->update(['is_seen_buyer' => '1']);
            }
            return view('frontend.user.order', compact('user', 'orders'));
        }else{
            return redirect()->route('user.auth');
        }
    }

    public function notifyAdmin(Request $request, $id)
    {
        $user = Auth::user();
        if($user){
            $this->validate($request,[
                'order_id' => 'required|String',
                'description' => 'required|String',
                'file' => 'nullable|mimes:png,jpg,jpeg,pdf,gif,mp4,mp3|max:10000'
            ]);

            $data = $request->all();

            if($request->file){
                $file = $request->file('file');
                $filename = time().'_'.$file->getClientOriginalName();

                // File extension
                $extension = $file->getClientOriginalExtension();

                $filetype = $file->getClientOriginalExtension();
                // Upload file
                $file->move(public_path('images/notify'),$filename);

                $filepath = url('images/notify/'.$filename);

                $data['file'] = $filepath;
            }
            $order = Order::where('order_number', $request->order_id)->first();

            if ($order){
                $seller = User::where('user_id', $order->seller)->first()->user_id;

                $data['user_id'] = $user->user_id;
                $data['status'] = 'active';
                $data['seller_id'] = $seller;
                $status = AdminNotification::create($data);

                $status = Message::create([
                    'user_id' => $user->user_id,
                    'receiver_id' => $seller,
                    'admin_id'=>'note',
                    'body' => "Dispute opened on order ID #" . $order->order_number,
                ]);

                if($status){
                    return redirect()->back()->with('success', 'Notification sent! Admin will contact you shortly.');

                }else{
                    return redirect()->back()->with('error', 'Something went wrong. Try again!');

                }

            }else{
                return redirect()->back()->with('error', 'Invalid Order Number. Try again!');

            }



        }else{
            return redirect()->route('user.auth')->with('error', 'Please login to your account');
        }
    }




    public function orderUpdate(Request $request, $id)
    {
        $order = Order::where('order_number', $request->input('order_id'))->first();

        $seller = User::where('user_id', $order->seller)->first();

        if($order->condition == 'completed'){
                return back()->with('success', 'Order has completed before');
        }

        $status = $order->update(['condition' => 'completed']);

        $status = Message::create([
            'user_id' => Auth::user()->user_id,
            'receiver_id' => $order->seller,
            'admin_id'=>'note',
            'body' => "Buyer has received order with ID #" . $order->order_number,
        ]);

        $seller->update(['balance'=> $seller->balance + $order->total_after_rate]);

        $data2['user_id'] =$order->seller;
        $data2['status'] ='pending';
        $data2['type'] ='credit';
        $data2['description'] =Str::upper('Account credited. Order #' .$order->order_number .' is complete ' );
        $data2['amount'] =$order->total_after_rate;
        $check2 = TransactionsLog::create($data2);

        $seller = User::where('user_id', $order->seller)->first();

        if($status){
            try{
                MailController::orderCompleteBuyer(Auth::user()->username, Auth::user()->email, $order->order_number, route('home').'/user/user-order/'. $order->id);
                MailController::orderCompleteSeller($seller->username, $seller->email, $order->order_number, route('home').'/seller/orders/'. $order->id);
                return back()->with('success', 'Order successfully updated');
            }catch(\Exception $e){
                return back()->with('error', 'Something went wrong.');
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
        if($user && is_numeric($id)){

        $order = Order::where(['id' => $id, 'user_id' => $user->user_id])->first();

        if($order){
            $product = Product::where(['user_id'=> $order->seller, 'title'=>$order->product])->first();

            $conversations = Message::orderBy('id', 'DESC')->where('user_id', $user->user_id)
                ->orWhere('receiver_id',  $user->user_id)->get();


            $users = $conversations->map(function ($conversation){

                if ($conversation->receiver_id == Auth::user()->user_id) {
                    return User::where('user_id', $conversation->user_id)->first([ 'last_seen', 'user_id', 'photo', 'username']);;
                }
                if ($conversation->user_id == Auth::user()->user_id) {
                    return User::where('user_id', $conversation->receiver_id)->first([ 'last_seen', 'user_id', 'photo', 'username']);;
                }

            })->unique('user_id','receiver_id');


            $ids = User::where('username', $product->added_by)->get('user_id')->first()->user_id;


            $seller = User::where('user_id', $ids)->first();

            $subscribe = \NotificationChannels\WebPush\PushSubscription::where('subscribable_id', $user->id)->first();


            $messages = Message::where('receiver_id', $ids)
                ->where('user_id', $user->user_id)
                ->orWhere('user_id', $ids)
                ->where('receiver_id', $user->user_id)
                ->orWhere('user_id', 'admin')
                ->get();

            $unread_messages = Message::where(['receiver_id' => $user->user_id, 'is_read' => '0'])
                ->get();

            $unread_chat = $unread_messages->groupBy('user_id');

            foreach($messages as $index=> $mess){
                if($mess->receiver_id == $user->user_id ){
                    Message::where('id',$mess->id )->update(['is_read' => '1']);
                }
            }

            return view('frontend.user.show-order', compact(['user', 'order', 'product','users','messages', 'seller', 'unread_chat', 'subscribe']));

        }else{
            abort(404);
        }


        }else{
            return redirect()->route('user.auth');
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
        //
    }
}
