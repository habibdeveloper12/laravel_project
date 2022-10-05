<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Admin;
use App\Models\AdminNotification;
use App\Models\blacklist;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use App\Models\reportBlacklist;
use App\Models\Seller;
use App\Models\TransactionsLog;
use App\Models\User;
use App\Models\VerificationRequest;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function admin(){
        $user = auth('admin')->user();
        if($user){
            $orders = Order::orderBy('id', 'DESC')->limit('10')->get();
            return view('backend.index', compact('orders'));
        }else{
            return redirect()->route('user.auth');
        }

    }

    public function fileMessage(Request $request){
        $user = auth('admin')->user();

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:png,jpg,jpeg,csv,txt,pdf|max:4000',
            'user_id' => 'required|numeric',
            'receiver_id' => 'required|numeric'
        ]);
        $data ['error'] = '';

        if ($validator->fails()) {
            $data['success'] = 0;
            $data['error'] = $validator->errors()->first('file');// Error response

        }else{
            if($request->file('file')) {

                $file = $request->file('file');
                $filename = time().'_'.$file->getClientOriginalName();

                // File extension
                $extension = $file->getClientOriginalExtension();

                $filetype = $file->getClientOriginalExtension();
                // Upload file
                $file->move(public_path('images/chat'),$filename);

                $filepath = url('images/chat/'.$filename);


                $message = new Message();
                $message->user_id = $request->user_id;
                $message->receiver_id = $request->receiver_id;
                $message->admin_id = $user->id;
                $message->file= $filepath;
                $message->filename= $file->getClientOriginalName();
                $message->file_type= $filetype;


                $message->save();

                $seller = User::where('user_id', $request->user_id)->first();
                $buyer = User::where('user_id', $request->receiver_id)->first();

                $messages = Message::where('receiver_id', $seller->user_id)
                    ->where('user_id', $buyer->user_id)
                    ->orWhere('user_id', $seller->user_id)
                    ->where('receiver_id', $buyer->user_id)
                    ->orWhere('user_id', 'admin')
                    ->get();


                $header = view('backend.layouts._message-backend',compact(['messages','user', 'seller', 'buyer']))->render();
                $data['header'] = $header;

                // Response
                $data['success'] = 1;
                $data['message'] = 'Uploaded Successfully!';
                $data['extension'] = $extension;
            }else{
                // Response
                $data['success'] = 2;
                $data['message'] = 'File not uploaded.';
            }
        }

        return response()->json($data);
    }


    public function postMessage(Request $request){
        $user = auth('admin')->user();

        $seller = \App\Models\User::where('user_id', $request->receiver_id)->first();
        $data ['error'] = '';


        $this-> validate($request, [
            'receiver_id' => 'numeric|required',
            'user_id' => 'numeric|required',
            'body' => 'string|required',
        ]);


        $status = Message::create([
            'user_id' => $request->user_id,
            'admin_id' => $user->id,
            'receiver_id' => $request->receiver_id,
            'body' => $request->body,
        ]);

        if($status){
            $seller = User::where('user_id', $request->user_id)->first();
            $buyer = User::where('user_id', $request->receiver_id)->first();

            $messages = Message::where('receiver_id', $seller->user_id)
                ->where('user_id', $buyer->user_id)
                ->orWhere('user_id', $seller->user_id)
                ->where('receiver_id', $buyer->user_id)
                ->orWhere('user_id', 'admin')
                ->get();


            $header = view('backend.layouts._message-backend',compact(['messages', 'user', 'seller', 'buyer']))->render();
            $data['header'] = $header;

            $data['success'] = 1;
            $data['message'] = 'Uploaded Successfully!';

        }else{
            $data['success'] = 2;
            $data['message'] = 'Failed.';
        }

        return response()->json($data);
    }

    public function withdraw(){
        $user = auth('admin')->user();

        if($user){
            $withdraw = WithdrawalRequest::where('status', 'active')->orderBy('id','DESC')->get();
            foreach($withdraw as $mess){
                if($mess->is_read == '0'){
                    WithdrawalRequest::where('id', $mess->id)->update(['is_read' => '1']);
                }
            }
            return view('backend.seller.withdraw', compact('withdraw'));
        }else{
            return redirect()->route('user.auth');
        }

    }

    public function withdrawResponse(Request $request)
    {

        $this->validate($request, [
            'id' => 'numeric|required',
            'user_id' => 'numeric|required',
            'status' => 'string|required',
        ]);

        $trans = WithdrawalRequest::where(['id' => $request->id, 'status' => 'active', 'user_id' => $request->user_id])->first();

        if ($trans) {
            if ($request->status == 'yes') {

                $clientID = env('PAYPAL_CLIENT_ID');
                $clientSecret = env('PAYPAL_CLIENT_SECRET');

                $apiContext = new \PayPal\Rest\ApiContext(
                    new \PayPal\Auth\OAuthTokenCredential(
                        $clientID,     // ClientID
                        $clientSecret     // ClientSecret
                    )
                );

                $payouts = new \PayPal\Api\Payout();

                $senderBatchHeader = new \PayPal\Api\PayoutSenderBatchHeader();

                $senderBatchHeader->setSenderBatchId(uniqid())
                    ->setEmailSubject("GG-Trade --> Withdrawal disbursed");

                $senderItem = new \PayPal\Api\PayoutItem();
                $senderItem->setRecipientType('Email')
                    ->setNote('Thanks for your patronage!')
                    ->setReceiver('sb-rua4u16932476@personal.example.com')
                    ->setSenderItemId(rand(00000000, 99999999))
                    ->setAmount(new \PayPal\Api\Currency('{
                                "value":"' .$trans->amount_to_receive. '",
                                "currency":"USD"
                            }'));

                $payouts->setSenderBatchHeader($senderBatchHeader)
                    ->addItem($senderItem);

                try {
                    $output = $payouts->createSynchronous($apiContext);
                } catch (\Exception $ex) {
                    return back()->with('error', 'Something went wrong, try again later!');
                }

                $status = DB::table('withdrawal_requests')->where(['id' => $request->id, 'status' => 'active', 'user_id' => $request->user_id])
                    ->update(['status'=>'inactive', 'condition' => 'disbursed']);

                $status = DB::table('transactions_logs')->where(['tran_id' => $trans->tran_id, 'user_id' => $request->user_id])
                    ->update(['status' => 'approved']);

                if($status){
                    return back()->with('success', 'Payment sent successfully');
                }else{
                    return back()->with('error', 'Something went wrong');
                }

            } elseif ($request->status == 'no') {
                $status = DB::table('withdrawal_requests')->where(['id' => $request->id, 'status' => 'active', 'user_id' => $request->user_id])
                    ->update(['status'=>'inactive','condition' => 'declined']);

                $status = DB::table('transactions_logs')->where(['tran_id' => $trans->tran_id, 'user_id' => $request->user_id])
                    ->update(['status' => 'declined']);

                if($status){

                    $owner = User::where('user_id', $trans->user_id)->first();
                    $balance = $owner->balance + $trans->amount;

                    $data2['user_id'] =$owner->user_id;
                    $data2['status'] ='approved';
                    $data2['type'] ='credit';
                    $data2['description'] =Str::upper('Withdrawal request was declined: '. $trans->tran_id );
                    $data2['amount'] =$trans->amount;
                    $check1 = $owner->update(['balance'=> $balance ]);

                    $check2 = TransactionsLog::create($data2);

                    return back()->with('success', 'Payment declined');
                }else{
                    return back()->with('error', 'Something went wrong');
                }
            } else {
                return back()->with('error', 'Something went wrong');
            }
        }else{
            return back()->with('error', 'Something went wrong');
        }

    }


    public function dispute(){
        $user = auth('admin')->user();

        if($user){
            $disputes = AdminNotification::orderBy('id', 'DESC')->get();
            if($disputes){
                foreach($disputes as $mess){
                    if($mess->is_read == '0'){
                        AdminNotification::where('id', $mess->id)->update(['is_read' => '1']);
                    }
                }
                return view('backend.dispute.index', compact('disputes'));
            }

            abort(404);
        }else{
            return redirect()->route('user.auth');
        }

    }

    public function disputeStatus(Request $request){
        $user = auth('admin')->user();

        if($user){
            if($request->mode=='true'){
                DB::table('admin_notifications')->where('id', $request->id)->update(['status'=>'active']);
            }else{
                DB::table('admin_notifications')->where('id', $request->id)->update(['status'=>'inactive']);
            }
            return response()->json(['msg'=>'Successfully updated status', 'status' =>true]);

        }else{
            return redirect()->route('user.auth');
        }

    }

    public function rule(){
        $user = auth('admin')->user();

        if($user){
            $reports = reportBlacklist::orderBy('id', 'DESC')->get();

            foreach($reports as $mess){
                if($mess->is_read == '0'){
                    reportBlacklist::where('id', $mess->id)->update(['is_read' => '1']);
                }
            }
            return view('backend.rule.detect', compact('reports'));

        }else{
            return redirect()->route('user.auth');
        }

    }

    public function showChat($id){
        $user = auth('admin')->user();

        if($user){
            $report = reportBlacklist::where('id', $id)->orderBy('id', 'DESC')->first();

            $seller = User::where('user_id', $report->seller_id)->first();
            $buyer = User::where('user_id', $report->user_id)->first();

            $messages = Message::where('receiver_id', $seller->user_id)
                ->where('user_id', $buyer->user_id)
                ->orWhere('user_id', $seller->user_id)
                ->where('receiver_id', $buyer->user_id)
                ->orWhere('user_id', 'admin')
                ->get();

            return view('backend.rule.show', compact('report', 'messages', 'seller', 'buyer'));

        }else{
            return redirect()->route('user.auth');
        }

    }

    public function postedMessage(Request $request){
        $user = auth('admin')->user();

        $seller = \App\Models\User::where('user_id', $request->receiver_id)->first();
        $data ['error'] = '';


        $this-> validate($request, [
            'receiver_id' => 'numeric|required',
            'user_id' => 'numeric|required',
            'body' => 'string|required',
        ]);


        $status = Message::create([
            'user_id' => $request->user_id,
            'admin_id' => $user->id,
            'receiver_id' => $request->receiver_id,
            'body' => $request->body,
        ]);

        if($status){
            $seller = User::where('user_id', $request->receiver_id)->first();
            $buyer = User::where('user_id', $request->user_id)->first();

            $messages = Message::where('receiver_id', $seller->user_id)
                ->where('user_id', $buyer->user_id)
                ->orWhere('user_id', $seller->user_id)
                ->where('receiver_id', $buyer->user_id)
                ->orWhere('user_id', 'admin')
                ->get();


            $header = view('backend.layouts._message-backend',compact(['messages', 'user', 'seller', 'buyer']))->render();
            $data['header'] = $header;

            $data['success'] = 1;
            $data['message'] = 'Uploaded Successfully!';

        }else{
            $data['success'] = 2;
            $data['message'] = 'Failed.';
        }

        return response()->json($data);
    }

    public function filedMessage(Request $request){
        $user = auth('admin')->user();

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:png,jpg,jpeg,csv,txt,pdf|max:4000',
            'user_id' => 'required|numeric',
            'receiver_id' => 'required|numeric'
        ]);
        $data ['error'] = '';

        if ($validator->fails()) {
            $data['success'] = 0;
            $data['error'] = $validator->errors()->first('file');// Error response

        }else{
            if($request->file('file')) {

                $file = $request->file('file');
                $filename = time().'_'.$file->getClientOriginalName();

                // File extension
                $extension = $file->getClientOriginalExtension();

                $filetype = $file->getClientOriginalExtension();
                // Upload file
                $file->move(public_path('images/chat'),$filename);

                $filepath = url('images/chat/'.$filename);


                $message = new Message();
                $message->user_id = $request->user_id;
                $message->receiver_id = $request->receiver_id;
                $message->admin_id = $user->id;
                $message->file= $filepath;
                $message->filename= $file->getClientOriginalName();
                $message->file_type= $filetype;


                $message->save();

                $seller = User::where('user_id', $request->receiver_id)->first();
                $buyer = User::where('user_id', $request->user_id)->first();

                $messages = Message::where('receiver_id', $seller->user_id)
                    ->where('user_id', $buyer->user_id)
                    ->orWhere('user_id', $seller->user_id)
                    ->where('receiver_id', $buyer->user_id)
                    ->orWhere('user_id', 'admin')
                    ->get();


                $header = view('backend.layouts._message-backend',compact(['messages','user', 'seller', 'buyer']))->render();
                $data['header'] = $header;

                // Response
                $data['success'] = 1;
                $data['message'] = 'Uploaded Successfully!';
                $data['extension'] = $extension;
            }else{
                // Response
                $data['success'] = 2;
                $data['message'] = 'File not uploaded.';
            }
        }

        return response()->json($data);
    }

    public function addWord(){
        $user = auth('admin')->user();

        if($user){
            $blacklists = blacklist::orderBy('id', 'DESC')->get();
            return view('backend.rule.index', compact('blacklists'));

        }else{
            return redirect()->route('user.auth');
        }

    }

    public function editWord(Request $request,$id){
        $user = auth('admin')->user();
        if($user){

            $validator = Validator::make($request->all(), [
                'word' => 'required|string',
            ]);

            if($validator->fails()) {
                return back()->with('error', 'Something went wrong. Try again Later');

            }

            $stat = DB::table('blacklists')->where('id', $id)->update(['word' => $request->word]);

            if ($stat) {
                return back()->with('success', 'Word updated Successfully');

            } else {
                return back()->with('error', 'Something went wrong. Try again Later');
            }
        }else{
            return redirect()->route('user.auth');
        }

    }

    public function postWord(Request $request){
        $user = auth('admin')->user();

        if($user){
            $validator = Validator::make($request->all(), [
                'word' => 'required|string',
            ]);

            if($validator->fails()){
                return back()->with('error', 'Something went wrong. Try again Later');
            }

            $status = blacklist::create([
                'word' => $request->word,
            ]);

            if($status){
                return back()->with('success', 'Word created Successfully');

            }else{
                return back()->with('error', 'Something went wrong. Try again Later');

            }

        }else{
            return redirect()->route('user.auth');
        }

    }
    public function deleteWord(Request $request, $id){
        $user = auth('admin')->user();

        if($user){
            $blacklist = blacklist::where('id', $id)->first();

            if($blacklist){
                $status = $blacklist->delete();
                if($status){
                    return back()->with('success', 'Word Successfully deleted');
                }else{
                    return back()->with('error', 'Something went wrong');
                }
            }else{
                return back()->with('error', 'Word not found');
            }

        }else{
            return redirect()->route('user.auth');
        }

    }

    public function announcement()
    {
        $user = auth('admin')->user();

        if ($user) {
            $announcements = Message::where('user_id', 'announce')->orderBy('id', 'DESC')->get();
            return view('backend.announcement.index', compact('announcements'));

        } else {
            return redirect()->route('user.auth');
        }
    }



        public function postAnnouncement(Request $request){
            $user = auth('admin')->user();

            if($user){

                $validator = Validator::make($request->all(), [
                    'description' => 'required|string',
                    'photo' => 'nullable|mimes:png,jpg,jpeg,csv,txt,pdf,gif,svg|max:4000',
                ]);

                if($validator->fails()) {
                    return back()->with('error', 'Something went wrong');
                }

                if($request->file('photo')) {
                    $file = $request->file('photo');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $filetype = $file->getClientOriginalExtension();
                    $file->move(public_path('images/announce'), $filename);

                    $filepath = url('images/announce/' . $filename);

                    $message = new Message();
                    $message->user_id = 'announce';
                    $message->receiver_id = 'announce';
                    $message->file = $filepath;
                    $message->filename = $file->getClientOriginalName();
                    $message->file_type = $filetype;
                    $message->body = $request->description;
                    $message->save();
                }else{
                    $status = Message::create([
                        'user_id' => 'announce',
                        'receiver_id' => 'announce',
                        'body' => $request->description,
                    ]);

                }


                return back()->with('success', 'Announcement successfully sent!');


            }else{
                return redirect()->route('user.auth');
            }

        }

    public function allPayment(){
        $user = auth('admin')->user();
        if($user){
            $transactions = TransactionsLog::orderBy('id', 'DESC')->get();
            return view('backend.fund.all', compact('transactions'));
        }else{
            return redirect()->route('user.auth');
        }

    }

    public function payment(){
        $user = auth('admin')->user();
        if($user){
            $transactions = TransactionsLog::where([['status' , '=', 'pending'], ['type', '!=', 'withdraw']])->orderBy('id', 'DESC')->get();
            return view('backend.fund.index', compact('transactions'));
        }else{
            return redirect()->route('user.auth');
        }

    }

    public function approveTransaction(Request $request){
        $user = auth('admin')->user();
        if($user) {
            $this->validate($request, [
                'id' => 'numeric|required',
            ]);
            $status = DB::table('transactions_logs')->where('id', $request->id)->update(['status' => 'approved']);

            if ($status) {


            } else {
                return 'error';
            }

        }else{
            return redirect()->route('user.auth');
        }

    }

    public function disapproveTransaction(Request $request){
        $user = auth('admin')->user();
        if($user){
            $this-> validate($request, [
                'id' => 'numeric|required',
            ]);
            $status = DB::table('transactions_logs')->where('id', $request->id)->update(['status'=>'declined']);

            if($status){

            }else{
                return 'error';
            }
        }else{
            return redirect()->route('user.auth');
        }

    }



}
