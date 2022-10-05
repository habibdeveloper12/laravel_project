<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\UserReview;
use App\Models\Settings;
use App\Models\TransactionsLog;
use App\Models\User;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use function view;

class SellerController extends Controller
{

    public function sellerShop($slug)
    {
        $user = Auth::user();
        $user_seller = User::where(['username'=>$slug])->first();

        if($user_seller) {
            $review = UserReview::where('reviewed', $user_seller->user_id)->get();

            if($user_seller->seller) {
                $products = Product::where(['added_by' => $slug, 'status' => 'active'])
                    ->where(function ($query) {
                        $query->where([['stock', '>', 0]])
                            ->orwhere(['stock' => 'Unlimited']);
                    })
                    ->get();

                $orders = Order::where(['seller' => $user_seller->user_id, 'condition' => 'completed'])->get();

                return view('seller.shop.index', compact(['user', 'user_seller', 'products','orders', 'review']));


            }else{
                $orders = Order::where(['user_id' => $user_seller->user_id, 'condition' => 'completed'])->get();

                return view('seller.shop.index', compact(['user', 'user_seller', 'orders', 'review']));
            }
        } else {
            return redirect()->back()->with('error', 'User not found!');
        }

    }


    public function withdraw(Request $request)
    {
        $user = Auth::user();

        if($user){
            $this-> validate($request, [
                'amount' => 'numeric|required',
                'method' => 'string|required',
                'paypal_email' => 'string|nullable',
                'to_receive' => 'numeric|nullable',
                'card' => 'string|nullable',
            ]);

            $settings = Settings::first();

            $data = $request->all();

            $data['user_id'] =$user->user_id;
            $data['username'] =$user->username;
            $data['email'] =$user->email;
            $to_receive = (float)$request->amount  - ((float)$request->amount * (float)$settings->withdraw_fee/100);
            $data['amount_to_receive'] =$to_receive;


            if($data['method'] == 'paypal'){
                $data['method_info'] =$request->paypal_email;
            }else{
                $data['method_info'] =$request->card;
            }

            $tran_id = 'TNSC-'. Str::random(10);
            $data['tran_id'] =$tran_id;


            $new_balance = $user->balance - $request->amount;

            if($new_balance<0){
                return back()->with('error', 'You do not have sufficient fund!');
            }

            $data2['user_id'] =$user->user_id;
            $data2['status'] ='pending';
            $data2['type'] ='withdraw';
            $data2['method'] = $data['method'];
            $data2['method_info'] = $data['method_info'];
            $data2['description'] =Str::upper('Withdrawal request with ID: '. $tran_id );
            $data2['amount'] =$request->amount;
            $data2['amount_to_receive'] =$to_receive;
            $data2['tran_id'] =$tran_id;


            $check1 = $user->update(['balance'=> $new_balance ]);
            $check2 = TransactionsLog::create($data2);
            $check = WithdrawalRequest::create($data);


            if($check && $check2 && $check1){
                return back()->with('success', 'Request sent successfully');
            }else{
                return back()->with('error', 'Something went wrong, Please try again later!');
            }

        }else{
            return redirect()->route('user.auth')->with('error', 'Please login to continue');

        }

    }
}
