<?php

namespace App\Http\Controllers;

use App\Models\blacklist;
use App\Models\Message;
use App\Models\Product;
use App\Models\reportBlacklist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function store(Request $request){

        $user = Auth::user();
        $seller = \App\Models\User::where('user_id', $request->receiver_id)->first();
        $data ['error'] = '';


        $this-> validate($request, [
            'receiver_id' => 'numeric|required',
            'body' => 'string|required',
        ]);

        $blacklist = blacklist::get('word');

        foreach ($blacklist as $index => $list){
            $arr[$index] = $list->word;
        }

        if(Str::contains(Str::lower($request->body), $arr)){
            reportBlacklist::create([
                'user_id' => $user->user_id,
                'seller_id' => $request->receiver_id,
                'message' => $request->body,
            ]);
        }

        $status = Message::create([
           'user_id' => $user->user_id,
            'receiver_id' => $request->receiver_id,
            'body' => $request->body,
        ]);

        if($status){

            $messages = Message::where('receiver_id', $seller->user_id)
                ->where('user_id', $user->user_id)
                ->orWhere('user_id', $seller->user_id)
                ->where('receiver_id', $user->user_id)
                ->orWhere('user_id', 'admin')
                ->where('created_at', '>', $user->created_at)
                ->get();


            $header = view('frontend.layouts._message-pd',compact(['messages', 'user']))->render();
            $data['header'] = $header;

            $data['success'] = 1;
            $data['message'] = 'Uploaded Successfully!';

            $owner = User::where('user_id', $request->receiver_id)->first();

            $owner->notify(new \App\Notifications\GenericNotification('GG-Trade You have a new message from '. $user->username, $request->body));


        }else{
            $data['success'] = 2;
            $data['message'] = 'Failed.';
        }

        return response()->json($data);

    }

    public function index(){
        $user = Auth::user();


        if($user){

            $conversations = Message::orderBy('id', 'DESC')->where('user_id', $user->user_id)
            ->orWhere('receiver_id', $user->user_id)
                ->orWhere('user_id', 'announce')
                ->where('created_at', '>', $user->created_at)

                ->get();


            $users = $conversations->map(function ($conversation){
                if ($conversation->user_id == 'announce') {
                    return 'announce';
                }

                if ($conversation->receiver_id == Auth::user()->user_id) {
                    return User::where('user_id', $conversation->user_id)->first([ 'last_seen', 'user_id', 'photo', 'username']);
                }
                if ($conversation->user_id == Auth::user()->user_id) {
                    return User::where('user_id', $conversation->receiver_id)->first([ 'last_seen', 'user_id', 'photo', 'username']);
                }

            })->unique('user_id','receiver_id');


            $unread_messages = Message::where(['receiver_id' => $user->user_id, 'is_read' => '0'])
                ->get();

            $unread_chat = $unread_messages->groupBy('user_id');

            return view('frontend.user.message', compact('user', 'users','unread_chat'));
        }else{
            return redirect()->route('user.auth');
        }
    }

    public function show($id){
        $user = Auth::user();

        if($user){
            $conversations = Message::orderBy('id', 'DESC')->where('user_id', $user->user_id)
                ->orWhere('receiver_id', $user->user_id)
                ->orWhere('user_id', 'announce')
                ->where('created_at', '>', $user->created_at)
                ->get();


            $subscribe = \NotificationChannels\WebPush\PushSubscription::where('subscribable_id', $user->id)->first();

            $users = $conversations->map(function ($conversation){
                if ($conversation->user_id == 'announce') {
                    return 'announce';
                }

                if ($conversation->receiver_id == Auth::user()->user_id) {
                    return User::where('user_id', $conversation->user_id)->first([ 'last_seen', 'user_id', 'photo', 'username']);;
                }
                if ($conversation->user_id == Auth::user()->user_id) {
                    return User::where('user_id', $conversation->receiver_id)->first([ 'last_seen', 'user_id', 'photo', 'username']);;
                }

            })->unique('user_id','receiver_id');


            if($id == 'announce'){
                $messages = Message::where('user_id', 'announce')
                    ->where('created_at', '>', $user->created_at)
                    ->get();

                if(count($messages) >0 ){
                    $sender = 'announce';
                }else{
                    return  redirect()->route('message.index');
                }

            }else{
                $messages = Message::where('receiver_id', $id)
                    ->where('user_id', $user->user_id)
                    ->orWhere('user_id', $id)
                    ->where('receiver_id', $user->user_id)
                    ->get();

                $sender = User::where('user_id', $id)->first();

            }

            $unread_messages = Message::where(['receiver_id' => $user->user_id, 'is_read' => '0'])
                ->get();

            $unread_chat = $unread_messages->groupBy('user_id');

            foreach($messages as $index=> $mess){
                if($mess->receiver_id == $user->user_id ){
                      Message::where('id',$mess->id )->update(['is_read' => '1']);
                }
            }


    } else {return redirect()->route('user.auth');}

       $user = Auth::user();

        if($user){
            return view('frontend.user.message', compact(['user', 'users','messages', 'unread_chat', 'sender', 'subscribe']));
        }else{
            return redirect()->route('user.auth');
        }

    }


    public function fetchMessage(){


        $data ['error'] = '';
        $user=Auth::user();


        $messages = Message::where('user_id', $user->user_id)
            ->orWhere('receiver_id', $user->user_id)
            ->orWhere('user_id', 'admin')
            ->get();


        $header = view('frontend.layouts._message-pd',compact(['messages','user']))->render();
        $data['header'] = $header;


        return response()->json($data);
    }



    public function fileMessage(Request $request){

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:png,jpg,jpeg,csv,txt,pdf|max:4000'
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
                $message->user_id = Auth::user()->user_id;
                $message->receiver_id = $request->receiver_id;
                $message->file= $filepath;
                $message->filename= $file->getClientOriginalName();
                $message->file_type= $filetype;


                $message->save();

                $seller = \App\Models\User::where('user_id', $request->receiver_id)->first();

                $user =Auth::user();

                $messages = Message::where('receiver_id', $seller->user_id)
                    ->where('user_id', $user->user_id)
                    ->orWhere('user_id', $seller->user_id)
                    ->where('receiver_id', $user->user_id)
                    ->orWhere('user_id', 'admin')
                    ->get();


                $header = view('frontend.layouts._message-pd',compact(['messages','user']))->render();
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


}


