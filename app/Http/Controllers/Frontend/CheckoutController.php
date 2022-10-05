<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PaypalController;
use App\Models\Category;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use App\Models\TransactionsLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use function back;
use function redirect;
use function view;
use const App\Http\Controllers\code;

class CheckoutController extends Controller
{
    public function pay(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $this->validate($request, [
                'product' => 'exists:products,title',
                'slug' => 'required|string',
                'quantity' => 'required|numeric',
            ]);

            $product = Product::where('slug', $request->slug)->first();

            if($product->stock < $request->quantity || $product->stock == 0 ){
                return back()->with('error', 'Seller does not have enough stock.');
            }

            \Illuminate\Support\Facades\Session::put('checkout', [
                'product' => $request->product,
                'slug' => $request->slug,
                'quantity' => $request->quantity,
                'total' => $product->offer_price * $request->quantity,
                'buyer' => $user,
                'seller'=> $product->user_id,
                'price' => $product->offer_price,
                'product_id'=> $product->id,
                'productt' => $product
            ]);

            return view('frontend.pages.checkout.payment', compact('user', 'product'))->with('success','proceed to payment');

        } else {
            return redirect()->route('user.auth')->with('error', 'Login to account to buy');
        }
    }



    public function paymentProcess(Request $request)
    {
        $user = Auth::user();
        $data ['error'] = '';

        if ($user) {
            $this->validate($request, [
                'body' => 'required|string',
            ]);

            $category= Category::where('id', \Illuminate\Support\Facades\Session::get('checkout')['productt']->cat_id)->first();

            $order = new Order();
            $order['user_id'] = Auth::user()->user_id;
            $order['order_number'] = Str::upper('ORD-' . Str::random(6));

            $order['total_after_rate'] = (\Illuminate\Support\Facades\Session::get('checkout')['total'] - \Illuminate\Support\Facades\Session::get('checkout')['total']*($category->rate_per_purchase/100));
            $order['total'] = \Illuminate\Support\Facades\Session::get('checkout')['total'];

            $order['quantity'] =\Illuminate\Support\Facades\Session::get('checkout')['quantity'];
            $order['product'] = \Illuminate\Support\Facades\Session::get('checkout')['product'];
            $order['product_price'] = \Illuminate\Support\Facades\Session::get('checkout')['price'];
            $order['product_id'] = \Illuminate\Support\Facades\Session::get('checkout')['product_id'];

            $order['payment_status'] = 'unpaid';
            $order['condition'] = 'pending';

            $order['seller'] = \Illuminate\Support\Facades\Session::get('checkout')['seller'];
            $order['username'] = \Illuminate\Support\Facades\Session::get('checkout')['buyer']->username;
            $order['email'] = \Illuminate\Support\Facades\Session::get('checkout')['buyer']->email;

            \Illuminate\Support\Facades\Session::push('checkout',[
                'order_number' => $order['order_number']
            ]);


            if($request->body == 'balance'){

                if($user->balance > \Illuminate\Support\Facades\Session::get('checkout')['total']){
                    $order['payment_method'] = 'from balance';
                    $order['payment_status'] = 'paid';

                    $status = $order->save();
                    if(\Illuminate\Support\Facades\Session::get('checkout')['productt']->stock != 'Unlimited'){
                        $new_quantity = \Illuminate\Support\Facades\Session::get('checkout')['productt']->stock -  \Illuminate\Support\Facades\Session::get('checkout')['quantity']; ;
                        if($new_quantity >= 0){
                            Product::where('id', \Illuminate\Support\Facades\Session::get('checkout')['productt']->id)->update(['stock' => $new_quantity]);
                        }
                    }

                    $data2['user_id'] =$user->user_id;
                    $data2['status'] ='approved';
                    $data2['type'] ='debit';
                    $data2['description'] =Str::upper('Debit alert. You purchased item #' .$order['order_number'] );
                    $data2['amount'] =$order['total'];


                    $new_balance = $user->balance - $order['total'];

                    $check1 = $user->update(['balance'=> $new_balance ]);
                    $check2 = TransactionsLog::create($data2);

                    $status = Message::create([
                        'user_id' => $user->user_id,
                        'receiver_id' => $order->seller,
                        'admin_id'=>'notes',
                        'body' => "New order from this user. Order ID #" . $order->order_number,
                    ]);

                    $data['redirect'] = route('thank.you');

                }else{
                    $data['error'] = "You don't have sufficient funds!";
                    return response()->json($data);
                }

            }elseif($request->body == 'paypal'){
                $order['payment_method'] = 'paypal';
                $paypal = new PaypalController;
                return $paypal->getCheckout( \Illuminate\Support\Facades\Session::get('checkout')['total']);



            }elseif($request->body == 'stripe'){
                $order['payment_method'] = 'stripe';
                $status = $order->save();
                if(\Illuminate\Support\Facades\Session::get('checkout')['productt']->stock != 'Unlimited'){
                    $new_quantity = \Illuminate\Support\Facades\Session::get('checkout')['productt']->stock -  \Illuminate\Support\Facades\Session::get('checkout')['quantity']; ;
                    if($new_quantity >= 0){
                        Product::where('id', \Illuminate\Support\Facades\Session::get('checkout')['productt']->id)->update(['stock' => $new_quantity]);
                    }
                }
                $product = Product::where('id', \Illuminate\Support\Facades\Session::get('checkout')['product_id'])->first();
                $req = $request->user()->checkoutCharge($product->offer_price * 100, $product->title, $order->quantity,
                    ['success_url' => route('thank.you'), 'cancel_url' => route('payment.fail'), 'client_reference_id' => $order->id]);
                $data['redirect'] = $req->url;

            }elseif($request->body == 'payop'){
                $order['payment_method'] = 'payop';
                $status = $order->save();

                $url = "https://payop.com/v1/invoices/create";

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $secretKey = env('PAYOP_SECRET', false);

                $order_prod = ['id' => $order->id, 'amount' => $order->total, 'currency' => 'EUR'];
                ksort($order_prod, SORT_STRING);
                $dataSet = array_values($order_prod);
                $dataSet[] = $secretKey;



                $headers = array(
                    "Content-Type: application/json",
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

                $data = '{
				"publicKey": "' .env('PAYOP_KEY', false).'",
				"order": {
				  "id": "'.$order->id.'",
				  "amount": "'.$order->total.'",
				  "currency": "EUR",
				  "items": [
					{
					  "id": "'.$order->id.'",
					  "name": "'.Product::where('id', $order->product_id)->first()->title.'",
					  "price": "'.$order->total.'"
					}
				  ],
				  "description": "'.Product::where('id', $order->product_id)->first()->summary.'"
				},
				"signature": "'.hash('sha256', implode(':', $dataSet)).'",
				"payer": {
				  "email": "' .User::where('user_id', $order->user_id)->first()->email.'",
				  "phone": "",
				  "name": ""
				},
				"paymentMethod": null,
				"language": "en",
				"resultUrl": "https://gg-trade.com/completed",
				"failPath": "https://gg-trade.com/fail"
			  }';

                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

                //for debug only!
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                $resp = curl_exec($curl);
                curl_close($curl);
                $result = json_decode($resp,true);

                $data = [];
                if($result['data']){
                    $newURL = "https://checkout.payop.com/en/payment/invoice-preprocessing/".$result['data'];
                    $data['redirect'] = $newURL;
                }else{
                    $data['error'] = "Something went wrong. Please try again";
                    return response()->json($data);
                }
            }else{
                $data['error'] = "This service is not available yet!";
                return response()->json($data);
            }



            if ($status) {
                $data['success'] = 1;
                $data['message'] = 'Successful!';
            } else {
                $data['success'] = 2;
                $data['message'] = 'Failed!';
            }
            return response()->json($data);


        } else {
            return redirect()->route('user.auth')->with('error', 'Please Login to your account');
        }

    }

    public function thanks(){
        $user =Auth::user();
        if($user){
            if(Session::has('checkout')){
                $order = Order::where('order_number', Session::get('checkout')[0]['order_number'])->first();
                try{
                    MailController::sendOrderMail(Session::get('checkout')['buyer']->username,
                        Session::get('checkout')['buyer']->email, route('home').'/user/user-order/'. $order->id,
                    Session::get('checkout')[0]['order_number']);
                }catch (\Exception $e){
                    return redirect()->route('home');
                }
                $order_num = Session::get('checkout')[0]['order_number'];
                    Session::forget('checkout');
                    return view('frontend.pages.checkout.thankyou', compact(['user', 'order_num']));
                }else {
                    return redirect()->route('home');
            }
            }else{
                return redirect()->route('user.auth');
            }
        }





    public function paymentProcess2(Request $request)
    {
        $user = Auth::user();
        $data ['error'] = '';

        if ($user) {
            $this->validate($request, [
                'body' => 'required|string',
                'product' => 'required|string',
                'quantity' => 'required|numeric'
            ]);


            $product = Product::where('id', $request->product)->first();

            if($product->stock < $request->quantity || $product->stock == 0 ){
                return back()->with('error', 'Seller does not have enough stock.');
            }

            \Illuminate\Support\Facades\Session::put('checkout', [
                'product' => $product->title,
                'slug' => $product->slug,
                'quantity' => $request->quantity,
                'total' => $product->offer_price * $request->quantity,
                'buyer' => $user,
                'seller'=> $product->user_id,
                'price' => $product->offer_price,
                'product_id'=> $product->id,
                'productt' => $product
            ]);

            $category= Category::where('id', \Illuminate\Support\Facades\Session::get('checkout')['productt']->cat_id)->first();

            $order = new Order();
            $order['user_id'] = Auth::user()->user_id;
            $order['order_number'] = Str::upper('ORD-' . Str::random(6));

            $order['total_after_rate'] = (\Illuminate\Support\Facades\Session::get('checkout')['total'] - \Illuminate\Support\Facades\Session::get('checkout')['total']*($category->rate_per_purchase/100));
            $order['total'] = \Illuminate\Support\Facades\Session::get('checkout')['total'];

            $order['quantity'] =\Illuminate\Support\Facades\Session::get('checkout')['quantity'];
            $order['product'] = \Illuminate\Support\Facades\Session::get('checkout')['product'];
            $order['product_price'] = \Illuminate\Support\Facades\Session::get('checkout')['price'];
            $order['product_id'] = \Illuminate\Support\Facades\Session::get('checkout')['product_id'];

            $order['payment_status'] = 'unpaid';
            $order['condition'] = 'pending';

            $order['seller'] = \Illuminate\Support\Facades\Session::get('checkout')['seller'];
            $order['username'] = \Illuminate\Support\Facades\Session::get('checkout')['buyer']->username;
            $order['email'] = \Illuminate\Support\Facades\Session::get('checkout')['buyer']->email;

            \Illuminate\Support\Facades\Session::push('checkout',[
                'order_number' => $order['order_number']
            ]);


            if($request->body == 'balance'){

                if($user->balance > \Illuminate\Support\Facades\Session::get('checkout')['total']){

                    $order['payment_method'] = 'from balance';
                    $order['payment_status'] = 'paid';

                    $status = $order->save();

                    if(\Illuminate\Support\Facades\Session::get('checkout')['productt']->stock != 'Unlimited'){
                        $new_quantity = \Illuminate\Support\Facades\Session::get('checkout')['productt']->stock -  \Illuminate\Support\Facades\Session::get('checkout')['quantity']; ;
                        if($new_quantity >= 0){
                            Product::where('id', \Illuminate\Support\Facades\Session::get('checkout')['productt']->id)->update(['stock' => $new_quantity]);
                        }
                    }

                    $data2['user_id'] =$user->user_id;
                    $data2['status'] ='approved';
                    $data2['type'] ='debit';
                    $data2['description'] =Str::upper('Debit alert. You purchased item #' .$order['order_number'] );
                    $data2['amount'] =$order['total'];


                    $new_balance = $user->balance - $order['total'];

                    $check1 = $user->update(['balance'=> $new_balance ]);
                    $check2 = TransactionsLog::create($data2);

                    $status = Message::create([
                        'user_id' => $user->user_id,
                        'receiver_id' => $order->seller,
                        'admin_id'=>'notes',
                        'body' => "New order from this user. Order ID #" . $order->order_number,
                    ]);

                    $data['redirect'] = route('thank.you');

                }else{
                    $data['error'] = "You don't have sufficient funds!";
                    return response()->json($data);
                }

            }elseif($request->body == 'paypal'){
                $order['payment_method'] = 'paypal';
                $paypal = new PaypalController;
                return $paypal->getCheckout( \Illuminate\Support\Facades\Session::get('checkout')['total']);

            }elseif($request->body == 'payop'){
                $order['payment_method'] = 'payop';
                $status = $order->save();

                $url = "https://payop.com/v1/invoices/create";

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $secretKey = env('PAYOP_SECRET', false);

                $order_prod = ['id' => $order->id, 'amount' => $order->total, 'currency' => 'EUR'];
                ksort($order_prod, SORT_STRING);
                $dataSet = array_values($order_prod);
                $dataSet[] = $secretKey;



                $headers = array(
                    "Content-Type: application/json",
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

                $data = '{
				"publicKey": "' .env('PAYOP_KEY', false).'",
				"order": {
				  "id": "'.$order->id.'",
				  "amount": "'.$order->total.'",
				  "currency": "EUR",
				  "items": [
					{
					  "id": "'.$order->id.'",
					  "name": "'.Product::where('id', $order->product_id)->first()->title.'",
					  "price": "'.$order->total.'"
					}
				  ],
				  "description": "'.Product::where('id', $order->product_id)->first()->summary.'"
				},
				"signature": "'.hash('sha256', implode(':', $dataSet)).'",
				"payer": {
				  "email": "' .User::where('user_id', $order->user_id)->first()->email.'",
				  "phone": "",
				  "name": ""
				},
				"paymentMethod": null,
				"language": "en",
				"resultUrl": "https://gg-trade.com/completed",
				"failPath": "https://gg-trade.com/fail"
			  }';

                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

                //for debug only!
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                $resp = curl_exec($curl);
                curl_close($curl);
                $result = json_decode($resp,true);

                $data = [];
                if($result['data']){
                    $newURL = "https://checkout.payop.com/en/payment/invoice-preprocessing/".$result['data'];
                    $data['redirect'] = $newURL;
                }else{
                    $data['error'] = "Something went wrong. Please try again";
                    return response()->json($data);
                }
            }elseif($request->body == 'stripe'){
                $order['payment_method'] = 'stripe';
                $status = $order->save();
                if(\Illuminate\Support\Facades\Session::get('checkout')['productt']->stock != 'Unlimited'){
                    $new_quantity = \Illuminate\Support\Facades\Session::get('checkout')['productt']->stock -  \Illuminate\Support\Facades\Session::get('checkout')['quantity']; ;
                    if($new_quantity >= 0){
                        Product::where('id', \Illuminate\Support\Facades\Session::get('checkout')['productt']->id)->update(['stock' => $new_quantity]);
                    }
                }
                $product = Product::where('id', \Illuminate\Support\Facades\Session::get('checkout')['product_id'])->first();
                $req = $request->user()->checkoutCharge($product->offer_price * 100, $product->title, $order->quantity,
                    ['success_url' => route('thank.you'), 'cancel_url' => route('payment.fail'), 'client_reference_id' => $order->id]);
                $data['redirect'] = $req->url;

            }else{
                $data['error'] = 'This service is not available yet!';
                return response()->json($data);
            }

            if ($status) {
                $data['success'] = 1;
                $data['message'] = 'Successful!';
            } else {
                $data['success'] = 2;
                $data['message'] = 'Failed!';
            }
            return response()->json($data);


        } else {
            return redirect()->route('user.auth')->with('error', 'Please Login to your account');
        }

    }


    public function fail(){
        $user = Auth::user();
        if($user){
            if(Session::has('checkout')){
                return back()->with('error', 'Payment not successful, Try again');
            }
        }else{
            return redirect()->route('user.auth');
        }
    }

}


