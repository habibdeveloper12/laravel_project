<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Frontend\CheckoutController;
use Illuminate\Http\Request;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

class PaypalController extends Controller
{
    public function getCheckout($amount)
    {
        if($amount){
            $clientID = env('PAYPAL_CLIENT_ID');
            $clientSecret = env('PAYPAL_CLIENT_SECRET');

            if(get_setting('paypal_sandbox') == 1)
            {
                $environment = new SandboxEnvironment($clientID, $clientSecret);
            }else{
                $environment = new ProductionEnvironment($clientID, $clientSecret);
            }

            $client = new PayPalHttpClient($environment);

            $request = new OrdersCreateRequest();

            $request->prefer('return=representation');

            $request->body = [
                "intent" => "CAPTURE",
                "purchase_units" => [[
                    "reference_id" => rand(00000, 99999),
                    "amount" => [
                        "value" => $amount,
                        "currency_code" => session('system_default_currency_info')->code,
                    ]
                ]],
                "application_context" => [
                    "cancel_url" => url('paypal/payment/cancel'),
                    "return_url" => url('paypal/payment/done')
                ]
            ];

            try {
                // Call API with your client and get a response for your call
                $response = $client->execute($request);

                return $response->result->links[1]->href;
                // If call returns body in response, you can get the deserialized version from the result attribute of the response
            }catch (\HttpException $ex) {
                dd($ex);
                echo $ex->statusCode;
                print_r($ex->getMessage());
            }

        }


    }


    public function getCancel(Request $request)
    {
        return \redirect()->route('home')->with('error', 'Payment has been cancelled');
    }


    public function getDone(Request $request)
    {
        $clientID = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_CLIENT_SECRET');

        if(get_setting('paypal_sandbox') == 1)
        {
            $environment = new SandboxEnvironment($clientID, $clientSecret);

        }else{
            $environment = new ProductionEnvironment($clientID, $clientSecret);
        }

        $client = new PayPalHttpClient($environment);

        $orderCaptureRequest = new OrdersCaptureRequest($request->token);

        $orderCaptureRequest->prefer('return=representation');


        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($orderCaptureRequest);

            $checkoutController = new CheckoutController;

            return $checkoutController->checkout_done($request->session()->get('order_id'), json_encode($response));


        }catch (\HttpException $ex) {
            dd($ex);
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }


    }

}
