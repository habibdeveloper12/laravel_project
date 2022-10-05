<?php

namespace App\Listeners;

use App\Models\Message;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Events\WebhookReceived;

class Stripe
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle()
    {
        $raw_post_data = file_get_contents('php://input');
        $event = json_decode($raw_post_data, true);

        if ($event['type'] == 'checkout.session.completed') {
            $order =  Order::where('id', $event['data']['object']['client_reference_id'])->first();
            if($order){
                $data['payment_id'] =  $event['id'];
                $data['order_id'] = $order->id;
                $data['order_number'] = $order->order_number;
                $data['method'] = 'Stripe';
                $data['user_id'] =  $order->user_id;
                $data['amount'] = (float)$event['data']['object']['amount_total'] / 100;
                $data['status'] = 'completed';
                $data['response'] = json_encode($raw_post_data);

                $present = Transaction::where('order_id' , $order->id)->first();

                if(!$present){
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

        http_response_code(200);
    }
}
