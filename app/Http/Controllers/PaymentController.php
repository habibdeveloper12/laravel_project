<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\Request;

class PaymentController extends Controller
{
    public function payop_webhook(Request $request)
    {
        $order_id = $request->invoice['txid'];
        $transaction_state = $request->transaction['state'];

        if ($transaction_state == 2) {

            $order = Order::where('id', $request->transaction['order']['id'])->first();

            $data['payment_id'] = $order_id;
            $data['order_id'] = $order->id;
            $data['order_number'] = $order->order_number;
            $data['user_id'] = $order->user_id;
            $data['method'] = 'Payop';
            $data['amount'] = $order->total;
            $data['status'] = 'Completed';
            $data['response'] = $request;

            $present = Transaction::where('order_id' , $order->id)->first();
            if (!$present) {
                Transaction::create($data);
                $order->update(['payment_status' => 'paid']);
            }

            $status = Message::create([
                'user_id' => $order->user_id,
                'receiver_id' => $order->seller,
                'admin_id'=>'notes',
                'body' => "New order from this user. Order ID #" . $order->order_number,
            ]);
        }


    }
}
