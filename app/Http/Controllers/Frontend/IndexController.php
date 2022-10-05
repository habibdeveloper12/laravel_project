<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use App\Models\SupportArticle;
use App\Models\SupportArticleComment;
use App\Models\SupportCategory;
use App\Models\SupportSubSection;
use App\Models\TransactionsLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class IndexController extends Controller
{
    public function handleGoogleCallback(){
        $user = Socialite::driver('google')->user();

        $this->_registerOrLoginUser($user);

        return redirect()->route('home');
    }

    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();

    }

    protected function _registerOrLoginUser($data){
        $user = User::where('email', $data->email)->first();

        if(!$user){
            $user = new User();
            $user->username = $data->name;
            $user->user_id = crc32($data->email);
            $user->email = $data->email;
            $user->provider_id= $data->id;
            $user->is_email_verified = 1;
            $user->save();
        }

        Auth::login($user);
    }

    public function home(){
        $categories = Category::where(['status'=>'active', 'is_parent'=>1])->limit('9')->orderBy('id','DESC')->get();

        $sellers = \App\Models\User::where('seller', '1')->get();

        $user = Auth::user();

        return view('frontend.index', compact(['categories','user']));
    }

    public function productCategory(Request $request, $slug)
    {
        $categories = Category::with('products')->where('slug',$slug)->first();

        $sort='';


        if($request -> sort !=null){
            $sort = $request->sort;
        }

        if($categories == null){
            return view('errors.404');
        }else {

            if ($categories->title == 'powerleveling') {
                $products = Product::where(['status' => 'active', 'cat_id' => $categories->id, 'stock' => 'Unlimited'])->paginate(6);
            } else {
                $products = Product::where(['status' => 'active', 'cat_id' => $categories->id, ['stock', '>', 0]])->paginate(6);
            }
        }


            if($sort == 'europe'){
                $products = Product::where(['status' => 'active', 'cat_id' => $categories->id, 'server' => 'europe'])->paginate(6);
            }elseif($sort == 'north america'){
                $products = Product::where(['status' => 'active', 'cat_id' => $categories->id, 'server' => 'north america'])->paginate(6);
            }elseif($sort == 'asia'){
                $products = Product::where(['status' => 'active', 'cat_id' => $categories->id, 'server' => 'asia'])->paginate(6);
            }elseif($sort == 'africa'){
                $products = Product::where(['status' => 'active', 'cat_id' => $categories->id, 'server' => 'africa'])->paginate(6);
            }elseif($sort == 'south america'){
                $products = Product::where(['status' => 'active', 'cat_id' => $categories->id, 'server' => 'south america'])->paginate(6);
            }elseif($sort == 'australia'){
                $products = Product::where(['status' => 'active', 'cat_id' => $categories->id, 'server' => 'australia'])->paginate(6);
            }


        $route = 'product-category';

        if($request->ajax()){
            $view = view('frontend.layouts._single-product', compact('products'))->render();
            return response()->json(['html' => $view]);
        }

       $user = Auth::user();

        return view('frontend.pages.product.product-category', compact(['categories', 'route','products','user']));

    }


    public function shopFilterServer(Request $request, $cat_id,$slug)
    {
        $this->validate($request, [
            'sort' => 'required|string',
        ]);

        if(!is_numeric($slug) || !is_numeric($cat_id) ){
            return;
        }


        if($cat_id && $slug) {

            $brand = Brand::where('id', $slug)->first();
            if (!$brand) {
                return redirect()->route('shop');
            }

            $categories_id = Product::where(['brand_id' => $slug, 'status' => 'active'])
                                    ->where(function($query) {
                                        $query->where([['stock', '>', 0]])
                                            ->orwhere(['stock' => 'Unlimited']);
                                    })
                                    ->groupby('cat_id')->get('cat_id');
            if (count($categories_id) < 0) {
                return redirect()->route('shop');
            }

            $categories = $categories_id->map(function ($cat) {
                return Category::where('id', $cat->cat_id)->first();
            });
            $cats = Category::where(['status' => 'active', 'id' => $cat_id])->first();

            if($request->sort == 'europe'){
                    $products = Product::where(['brand_id' => $slug, 'status' => 'active', 'cat_id' => $cat_id, 'server' => 'europe'])
                                        ->where(function($query) {
                                            $query->where([['stock', '>', 0]])
                                                ->orwhere(['stock' => 'Unlimited']);
                                        })->get();

            }elseif($request->sort  == 'north america'){
                    $products = Product::where(['brand_id' => $slug, 'status' => 'active', 'cat_id' => $cat_id, 'server' => 'north america'])
                                        ->where(function($query) {
                                            $query->where([['stock', '>', 0]])
                                                ->orwhere(['stock' => 'Unlimited']);
                                        })->get();

            }elseif($request->sort  == 'asia'){
                    $products = Product::where(['brand_id' => $slug, 'status' => 'active', 'cat_id' => $cat_id, 'server' => 'asia'])
                                        ->where(function($query) {
                                            $query->where([['stock', '>', 0]])
                                                ->orwhere(['stock' => 'Unlimited']);
                                        })->get();

            }elseif($request->sort  == 'africa'){
                    $products = Product::where(['brand_id' => $slug, 'status' => 'active', 'cat_id' => $cat_id, 'server' => 'africa'])
                                        ->where(function($query) {
                                            $query->where([['stock', '>', 0]])
                                                ->orwhere(['stock' => 'Unlimited']);
                                        })->get();

            }elseif($request->sort  == 'south america'){
                    $products = Product::where(['brand_id' => $slug, 'status' => 'active', 'cat_id' => $cat_id, 'server' => 'south america'])
                                        ->where(function($query) {
                                            $query->where([['stock', '>', 0]])
                                                ->orwhere(['stock' => 'Unlimited']);
                                        })->get();

            }elseif($request->sort  == 'australia'){
                    $products = Product::where(['brand_id' => $slug, 'status' => 'active', 'cat_id' => $cat_id, 'server' => 'australia'])
                                        ->where(function($query) {
                                            $query->where([['stock', '>', 0]])
                                                ->orwhere(['stock' => 'Unlimited']);
                                        })->get();
            }else{
                    $products = Product::where(['brand_id' => $slug, 'status' => 'active', 'cat_id' => $cat_id])
                                        ->where(function($query) {
                                            $query->where([['stock', '>', 0]])
                                                ->orwhere(['stock' => 'Unlimited']);
                                        })->get();
            }


            $user = Auth::user();
            if (count($products) < 1) {
                $data['empty'] = '1';
            }

            if ($request->ajax()) {
                $header = view('frontend.layouts.shop-game_single-product', compact(['user', 'brand', 'cats', 'products', 'categories']))->render();
                $data['header'] = $header;
            }

            return response()->json($data);
        }else{
            return;
        }


    }


    public function shopFilter(Request $request, $cat_id,$slug)
    {
        if(!is_numeric($slug) || !is_numeric($cat_id) ){
            return;
        }

        if($cat_id && $slug) {

            $brand = Brand::where('id', $slug)->first();
            if (!$brand) {
                return redirect()->route('shop');
            }

            $categories_id = Product::where(['brand_id' => $slug, 'status' => 'active'])
                                    ->where(function($query) {
                                        $query->where([['stock', '>', 0]])
                                            ->orwhere(['stock' => 'Unlimited']);
                                    })
                                    ->groupby('cat_id')->get('cat_id');

            if (count($categories_id) < 0) {
                return redirect()->route('shop');
            }

            $categories = $categories_id->map(function ($cat) {
                return Category::where('id', $cat->cat_id)->first();
            });
            $cats = Category::where(['status' => 'active', 'id' => $cat_id])->first();


            if ($request->sort == 'none') {

                if ($cats->title == 'powerleveling') {
                    $products = Product::where(['brand_id' => $slug, 'status' => 'active', 'cat_id' => $cat_id, 'stock' => 'Unlimited'])->get();
                } else {
                    $products = Product::where(['brand_id' => $slug, 'status' => 'active', 'cat_id' => $cat_id, ['stock', '>', 0]])->get();
                }


            } else if ($request->sort == 'online') {
                $users = User::whereNotNull('last_seen')
                    ->orderBy('last_seen', 'DESC')->get();


                $allOnlineUsers = $users->map(function ($user) {
                    if (Cache::has('is_online' . $user->user_id)) {
                        return $user;
                    }
                })->unique('user_id');

                $allproducts = [];

                if (count($allOnlineUsers) > 0) {
                    foreach ($allOnlineUsers as $index => $user) {
                        if ($user) {
                            $allproducts[$index] = Product::where(['brand_id' => $slug, 'status' => 'active', 'cat_id' => $cat_id, 'user_id' => $user->user_id])
                                                            ->where(function($query) {
                                                                $query->where([['stock', '>', 0]])
                                                                    ->orwhere(['stock' => 'Unlimited']);
                                                            })
                                                            ->orderBy('id', 'ASC')->get();
                        }
                    }
                }

                $products = [];

                foreach ($allproducts as $value) {
                    foreach ($value as $t) {
                        $products[] = $t;
                    }
                }

            } else {
                return;
            }

            $user = Auth::user();
            if (count($products) < 1) {
                $data['empty'] = '1';
            }

            if ($request->ajax()) {
                $header = view('frontend.layouts.shop-game_single-product', compact(['user', 'brand', 'cats', 'products', 'categories']))->render();
                $data['header'] = $header;
            }

            return response()->json($data);
        }else{
            return;
        }
    }

    public function productDetail($slug)
    {
        $user = Auth::user();
        $rel_prod = Product::with('rel_prods')->where('slug', $slug)->first();
        $product = Product::where([['slug' ,'=', $slug]])
                            ->where(function($query) {
                                $query->where([['stock', '>', 0]])
                                    ->orwhere(['stock' => 'Unlimited']);
                            })->first();
        if(!$product){
            return back()->with('error', 'No such product found');
        }

        $seller = \App\Models\User::where('user_id', $product->user_id)->first();



        if($user) {
            $subscribe = \NotificationChannels\WebPush\PushSubscription::where('subscribable_id', $user->id)->first();


            $messages = Message::where('receiver_id', $seller->user_id)
                ->where('user_id', crc32($user->email))
                ->orWhere('user_id', $seller->user_id)
                ->where('receiver_id', crc32($user->email))
                ->orWhere('user_id', 'admin')
                ->get();

            return view('frontend.pages.product.product-detail', compact(['product', 'user', 'seller', 'messages', 'subscribe']) );

        }
        return view('frontend.pages.product.product-detail', compact(['product', 'user', 'seller']) );



    }

    public function userAuth()
    {
       $user = Auth::user();

        if($user){
            return redirect()->route('home');
        }else{

            \Illuminate\Support\Facades\Session::put('user.intended', URL::previous());

            return view('frontend.auth.auth', compact('user'));
        }

    }


    public function loginSubmit(Request $request)
    {
           $this->validate($request, [
           'email' => 'email|required',
           'password' => 'required|min:7',
        ]);

        $userr = User::where('email', $request->email)->first();

        if($userr && $userr->is_email_verified != 1){
            return back()->with('error', 'You email is not verified. Please check your mail for verification link');
        }

        if(!session()->has('url.intended'))
        {
            session(['url.intended' => url()->previous()]);
        }


        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password, 'status'=>'active'],$request->remember)){

            \Illuminate\Support\Facades\Session::put('user', $request->email);

                return redirect()->route('home')->with('success', 'Successfully login');
        }else{
            return back()->with('error', 'Invalid email or password!');
        }
    }
    public function resetPassword()
    {
        $user = Auth::user();
        return view('frontend.auth.password.reset', compact('user'));
    }

    public function resetPasswordLink(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
        ]);
        $e = User::where('email', $request->email)->first();

        if(!$e->is_email_verified){
            return back()->with('error', 'Your email is not yet verified. You need to verify your email first');
        }
        $token = Str::random(64);
        $email = $request->email;


        DB::table('password_resets')->insert([
            'email' =>  $request->email,
            'token' =>  $token,
            'created_at' => Carbon::now()
        ]);

        $p = User::where('email',$request->email)->first();
        $route = route('reset.form', compact('token','email'));

        try{
            MailController::sendForgotPassword($p->username, $request->email, $token,$route );
        }catch (\Exception $e){
            return back()->with('error', 'Something went wrong. Please try again');
        }
;
        return back()->with('success', 'We have sent a password reset link to your mail');

    }

    public function showResetForm(Request $request, $token = null){
            return view('frontend.auth.password.email')->with(['token'=>$token, 'email' => $request->email]);
    }

    public function passwordReset(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:7|confirmed',
            'password_confirmation' => 'required'
        ]);

        $check_token = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token,
        ])->first();

        if(!$check_token){
            return back()->withInput()->with('fail', 'Invalid token');
        }else{
            User::where('email', $request->email)->update([
                'password' => Hash::make($request->password)
            ]);

            DB::table('password_resets')->where([
                'email' =>$request->email
            ])->delete();

            return redirect()->route('user.auth')->with('success', 'Your password has been changed! You can login with new password');
        }
    }

    public function registerUser()
    {
        $user = Auth::user();

        if($user){
            return redirect()->route('home');
        }
        return view('frontend.auth.register', compact('user'));
    }

    public function registerSubmit(Request $request){
        $this->validate($request,[
            'username' => 'required|String|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'min:7|required|confirmed',
            'terms_and_condition' => 'accepted',
        ]);

        $data=$request->all();
        $data['verification_code'] = sha1(time());

        $route = route('home');

        try{
            MailController::sendSignupEMail($data['username'], $data['email'], $data['verification_code'], $route);
        }catch(\Exception $e){
            return back()->with('error', 'Something went wrong. Make sure your email  is valid.');
        };

        $check = $this->create($data);

        if($check){
            return redirect()->route('user.auth')->with('success', 'Account created successfully, Please check email for verification link');

        }else{return redirect()->back()->with('error', 'Something went wrong, Please try again!');}


        }


    private function create(array $data){
        return User::create([
            'user_id' => crc32($data['email']),
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'verification_code' => $data['verification_code'],
        ]);
    }

    public function verifyUser(Request $request){
        $verification_code = \Illuminate\Support\Facades\Request::get('code');

        $user = User::where(['verification_code' => $verification_code])->first();

        if($user){
            $user->is_email_verified = 1;
            $user->email_verified_at = time();
            $user->save();
            return redirect()->route('user.auth')->with('success', 'Your account is verified, Please login!');
        }

        return redirect()->route('user.auth')->with('error', 'Invalid verification code!');

    }

    public function userLogout(){
            \Illuminate\Support\Facades\Session::forget('user');
            Auth::logout();


            return redirect()->home()-> with('success', 'Successfully Logout');
    }

    public function userDashboard(){
        $user = Auth::user();
        $subscribe = \NotificationChannels\WebPush\PushSubscription::where('subscribable_id', $user->id)->first();

        if($user){
            return view('frontend.user.dashboard', compact('user', 'subscribe'));
        }else {
            return redirect()->route('user.auth');
        }
    }

    public function dispute(){
        $user = Auth::user();

        if($user){
            return view('frontend.user.dispute', compact('user'));
        }else{
            return redirect()->route('user.auth');
        }

    }

    public function userSettings(){
       $user = Auth::user();

        if($user){
                return view('frontend.user.settings', compact('user'));
            }else{
                return redirect()->route('user.auth');
            }

        }

    public function userProfile(){
      $user = Auth::user();

        if($user){
            return view('frontend.user.profile', compact('user'));
        }else{
            return redirect()->route('user.auth');
        }

    }
    public function changePass(){
        $user = Auth::user();

        if($user){
            return view('frontend.user.changePassword', compact('user'));
        }else{
            return redirect()->route('user.auth');
        }

    }
    public function userPhone(){
       $user = Auth::user();

//        $mask =  $user->email;
//        $mask= Str::mask($mask, '*', 4, 12);
        if($user){
            return view('frontend.user.phone', compact(['user']));
        }else{
            return redirect()->route('user.auth');
        }

    }

    public function user2FA(){
      $user = Auth::user();

        if($user){
            return view('frontend.user.2FA', compact('user'));
        }else{
            return redirect()->route('user.auth');
        }

    }

    public function userDelete(){
       $user = Auth::user();

        if($user){
            return view('frontend.user.delete', compact('user'));
        }else{
            return redirect()->route('user.auth');
        }

    }

    public function userAddress(){
       $user = Auth::user();

        if($user){
            return view('frontend.user.address', compact('user'));
        }else{
            return redirect()->route('user.auth')->with('error', 'Please login to your account');
        }

    }

    public function shop()
    {
        $products = Product::where(['status' => 'active'])
                            ->where(function($query) {
                                $query->where([['stock', '>', 0]])
                                    ->orwhere(['stock' => 'Unlimited']);
                            })
                            ->get();

        $cats = Category::where(['status' => 'active', 'is_parent' => 1])->with('products')->orderBy('title', 'ASC')->get();

        $brands = Brand::where('status', 'active')->orderBy('title')->get();

        $user = Auth::user();

        $brands_alpha = $brands->sortBy('title')->groupBy(function ($item, $key) {
            return substr($item['title'], 0, 1);
        });


        return view('frontend.pages.product.shop', compact(['user', 'products', 'cats', 'brands', 'brands_alpha']));
    }


    public function shopGames($cat, $slug)
    {
        if(is_numeric($cat) == 0 || is_numeric($slug) == 0){
            return redirect()->route('shop');
        }

        if($cat && $slug){
            $brand = Brand::where('id', $slug)->first();
            if(!$brand){
                return redirect()->route('shop');
            }
            $categories_id = Product::where(['brand_id'=> $slug, 'status' => 'active'])->groupby('cat_id')->get('cat_id');
            if(count($categories_id)< 0){
                return redirect()->route('shop');
            }

            $categories = $categories_id->map(function ($cat) {
                return Category::where('id', $cat->cat_id)->first();
            });

            $products = Product::where(['brand_id'=> $slug, 'status' => 'active', 'cat_id' => $cat])
                                ->where(function($query) {
                                    $query->where([['stock', '>', 0]])
                                        ->orwhere(['stock' => 'Unlimited']);
                                })->get();

            $cats = Category::where(['status' => 'active', 'id' => $cat])->first();
        }else{
            return redirect()->route('shop');
        }

        $user = Auth::user();


        return view('frontend.pages.product.shop-game', compact(['user', 'brand', 'cats', 'products', 'categories']));
    }

    public function shopGame($slug)
    {
        if(is_numeric($slug) == 0){
            return redirect()->route('shop');
        }

        if($slug){

            $categories_id = Product::where(['brand_id'=> $slug, 'status' => 'active'])
                                    ->where(function($query) {
                                        $query->where([['stock', '>', 0]])
                                            ->orwhere(['stock' => 'Unlimited']);
                                    })
                                    ->groupby('cat_id')->get('cat_id');

            if(count($categories_id) < 1) {
                 return redirect()->route('shop');
            }

            $categories = $categories_id->map(function ($cat) {
                return Category::where('id', $cat->cat_id)->first();
            });


            $cats = Category::where(['status' => 'active', 'id' => $categories[0]->id])->first();

            return redirect()->route('shop.games', [$cats->id, $slug]);



        }else{
            return redirect()->route('shop');
        }


    }


    public function billingAddress(Request $request, $id){
        $user = User::where('id', $id)->update(['country' => $request->country, 'city' => $request->city, 'state' => $request->state, 'zipcode' => $request->zipcode, 'address' => $request->address]);
        if($user){
            return back()->with('success', ' Billing Address Successfully updated');
        }else{
            return back()->with('error', ' Something went wrong');
        }

    }


    public function avatarUpdate(Request $request){
       $user = Auth::user();

       if($user){

           $validator = Validator::make($request->all(), [
               'file' => 'required|dimensions:min_width=450,min_height=1024|mimes:png,jpg,jpeg|max:2000'
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
                   $file->move(public_path('images/users'),$filename);

                   $filepath = url('images/users/'.$filename);



                   $user =Auth::user();

                   $user->update(['photo'=>$filepath]);

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

       }else{
           return redirect()->route('user.auth')->with('error', 'Please login to your account');
       }

    }



    public function passwordUpdate(Request $request, $id){

        $this->validate($request,[
            'currentpassword' => 'required|String',
            'newpassword' => 'required|String',
            'newpassword_confirmation' => 'required|String'
        ]);

        $valid = User::where('id', $id)->first();
        if(!$valid){
            return back()->with('error', 'Something went wrong');
        }

        $hashpassword = Auth::user()->password;

        if($hashpassword){
            if(\Hash::check($request-> currentpassword, $hashpassword)){
                if(!\Hash::check($request->newpassword, $hashpassword)){
                    $hashnewpassword = Hash::make($request->newpassword);
                    User::where('id', $id)->update(['password' => $hashnewpassword]);
                    return redirect()->route('user.dashboard')->with('success', ' Password Successfully updated');
                }else{
                    return back()->with('error', 'New password cannot be the same as old password');
                }
            }else{
                return back()->with('error', 'Old password does not match');
            }
        }else{
            $hashnewpassword = Hash::make($request->newpassword);
            User::where('id', $id)->update(['password' => $hashnewpassword]);
            return redirect()->route('user.dashboard')->with('success', ' Password Successfully updated');
        }




    }


    public function autoSearch(Request $request){
        $query= $request->get('term', '');
        $products = Brand::where('title', 'LIKE', '%'.$query.'%')->get();

        $data= array();
        foreach ($products as $product){
            $data[] = array('value' => $product->title, 'id'=>$product->id);
        }

        if(count($data)){
            return $data;
        }else{
            return ['value'=> 'No Result Found', 'id'=> ''];
        }

    }

    public function search(Request $request){
        $query= $request->input('query');
        $brand = Brand::where('title', 'LIKE', '%'.$query.'%')->first();

        if(!$brand){
            return redirect()->back();
        }
        $slug = $brand->id;

        $user = Auth::user();

        if(is_numeric($slug) == 0){
            return redirect()->route('shop');
        }

        if($slug){

            $categories_id = Product::where(['brand_id'=> $slug, 'status' => 'active'])
                                    ->where(function($query) {
                                        $query->where([['stock', '>', 0]])
                                            ->orwhere(['stock' => 'Unlimited']);
                                    })
                                    ->groupby('cat_id')->get('cat_id');

            if(count($categories_id) < 1) {
                return redirect()->route('shop');
            }

            $categories = $categories_id->map(function ($cat) {
                return Category::where('id', $cat->cat_id)->first();
            });


            $cats = Category::where(['status' => 'active', 'id' => $categories[0]->id])->first();

            return redirect()->route('shop.games', [$cats->id, $slug]);



        }else{
            return redirect()->route('shop');
        }

    }

    public function getSubmitRequest(){

        $user = Auth::user();

        return view('support.support.submit-request', compact('user'));

    }

    public function sendContact(Request $request){
        $this->validate($request,[
            'full_name' => 'required|String',
            'email' => 'required|email',
            'subject' => 'required|String',
            'order_number' => 'required|String',
            'comment' => 'required|String',
        ]);

        $data = $request->all();
        $data['ticket_num'] = Str::upper('TKT-' . Str::random(6));

        try{
            MailController::sendSupport($data['full_name'], $data['email'], $data['ticket_num']);
            MailController::contactSupport($data['full_name'], 'support@gg-trade.com',$data['subject'], $data['order_number'], $data['comment'], $data['ticket_num']);
        }catch(\Exception $e){
            return back()->with('error', 'Something went wrong. Please try again.');
        };



        return back()->with('success', 'Request submitted. We will get back to you shortly');

    }


    public function userSales(){

        $user = Auth::user();

        if($user){
            $orders = Order::where(['seller'=> $user->user_id, 'payment_status' =>'paid'])->orderBy('id', 'DESC')->get();

            foreach($orders as $item){
               Order::where('seller', $user->user_id)->update(['is_seen_seller' => '1']);
            }

            return view('seller.order.index', compact('user','orders'));
        }else{
            return redirect()->route('user.auth')->with('error', 'Please login to your account');
        }

    }

    public function userFunds(){

        $user = Auth::user();
        if($user){
            $balance = $user->balance;

            $exchange_rate_eur = Currency::where('code', 'EUR')->first()->exchange_rate;
            $exchange_rate_pol = Currency::where('code', 'PLN')->first()->exchange_rate;

            $logs = TransactionsLog::where('user_id', $user->user_id)->orderBy('id','DESC')->get();

            return view('frontend.user.funds', compact('user', 'balance', 'exchange_rate_eur', 'exchange_rate_pol','logs'));
        }else{
            return redirect()->route('user.auth')->with('error', 'Please login to your account');
        }
    }

    public function privacyPolicy(){
        $user = Auth::user();
        return view('frontend.pages.policy.privacy');
    }
    public function cookiePolicy(){
        $user = Auth::user();
        return view('frontend.pages.policy.cookie');

    }

    public function termsPolicy(){
        $user = Auth::user();
        return view('frontend.pages.policy.terms');

    }


    public function support(){
        $user = Auth::user();
        $articles = SupportArticle::where('status', 'active')->orderBy('id', 'DESC')->paginate(5);

        return view('support.index', compact(['articles']));
    }

    public function generalQuestion(){
        $user = Auth::user();
        $gen = SupportCategory::where('title', 'General Question')->first();
        $subsection = SupportSubSection::where('parent_id', $gen->id)->get();
        $articles = SupportArticle::where('category', $gen->id)->get();

        return view('support.category.general_question', compact(['subsection', 'articles', 'gen']));
    }

    public function sellerInfo(){
        $user = Auth::user();
        $gen = SupportCategory::where('title', 'Seller Information')->first();
        $subsection = SupportSubSection::where('parent_id', $gen->id)->get();
        $articles = SupportArticle::where('category', $gen->id)->get();

        return view('support.category.seller_info', compact(['subsection', 'articles', 'gen']));
    }

    public function supportArticle($slug){
        $user = Auth::user();
        $article = SupportArticle::where('slug', $slug)->first();
        if($article){


        $category = SupportCategory::where('id', $article->category)->first();
        $subsection = SupportSubSection::where('id', $article->sub_section)->first();
        $section_article = SupportArticle::where(['sub_section' => $subsection->id, 'category' => $category->id, 'status'=>'active'])->orderBy('id', 'DESC')->get();

        $comments = SupportArticleComment::where(['article_id' => $article->id, 'status' => 'active'])->orderBy('id', 'DESC')->get();

            if($category && $subsection && $section_article){
                return view('support.category.article', compact(['article', 'category', 'subsection', 'section_article', 'comments']));
            }else{
                return  redirect()->route('support')->with('error', 'Something went wrong');
            }
        }else{
            return  redirect()->route('support')->with('error', 'Something went wrong');
        }
    }


    public function supportSubSection($id){
        $user = Auth::user();
        $subsection = SupportSubSection::where('id', $id)->first();
        $section_article = SupportArticle::where(['sub_section' => $subsection->id, 'category' => $subsection->parent_id, 'status'=>'active'])->orderBy('id', 'DESC')->get();

        return view('support.category.subsection', compact(['subsection', 'section_article']));
    }


    public function allSupport(){
        $user = Auth::user();
        $articles = SupportArticle::where('status', 'active')->orderBy('id', 'DESC')->paginate(5);

        return view('support.all-index', compact(['articles']));
    }

    public function postSupportComment(Request $request){
        $user = Auth::user();

        if($user){

            $this->validate($request, [
                'comment' => 'string|required',
                'article_id' => 'numeric|required',
            ]);


            $article = SupportArticle::where('id', $request->article_id)->first();

            if($article){
                $status = SupportArticleComment::create([
                    'user_id' => $user->user_id,
                    'comment' => $request->comment,
                    'article_id' => $article->id,
                ]);

                return back()->with('success', 'Comment posted Successfully');
            }else{
                return back()->with('error', 'Something went wrong');

            }


        }else{
            return route('user.auth')->with('error', 'Please login to your account');
        }

    }


    public function articleHelpful(Request $request)
    {
        $user = Auth::user();

        if ($user) {

            $this->validate($request, [
                'body' => 'string|required',
                'article_id' => 'numeric|required',
            ]);
            $data =[];

            $article = SupportArticle::where('id', $request->article_id)->first();

            if($request->body == 'yes'){
                $status = SupportArticle::where('id', $request->article_id)->update([
                    'like' => $article->like + 1
                ]);

                if($status){
                    $article = SupportArticle::where('id', $request->article_id)->first();
                    $header = view('support.layouts._yes_no', compact('article') )->render();
                    $data['header'] = $header;
                }

            }else if($request->body == 'no'){
                $status = SupportArticle::where('id', $request->article_id)->update([
                    'dislike' => $article->dislike + 1
                ]);

                if($status){
                    $article = SupportArticle::where('id', $request->article_id)->first();
                    $header = view('support.layouts._yes_no', compact('article') )->render();
                    $data['header'] = $header;
                }

            }else{
                return back()->with('error', 'Something went wrong');
            }





            return response()->json($data);


        } else {

            return route('user.auth')->with('error', 'Please login to your account');
        }

    }


    public function disableNotify(Request $request)
    {
        if($request->body == 'disable'){
            $data = [];

            $subscribe = '';

            if(is_numeric($request->id)){
                $subscribe = \NotificationChannels\WebPush\PushSubscription::where('id', $request->id)->first();
            }

            if($subscribe){
                $status = DB::table('push_subscriptions')
                    ->where('id',$request->id)
                    ->delete();

                if($status){
                    $data['success'] = 1;
                    $data['message'] = 'Notification Disabled!';
                }
                return response()->json($data);
            }
        }
            return back()->with('sorry', 'Something went wrong');


    }
    public function changeEmail(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email',
        ]);

        if(Auth::user()->email == $request->email){
            return back()->with('error', 'New Email cannot be same as old email.');
        }

        $changed = User::where('email', Auth::user()->email)->update([
            'change_email' => $request->email
        ]);

        $route = route('home');

        if($changed){
            try{
                MailController::sendEMailChangeLink($request->email, base64_encode($request->email), $route);
                return back()->with('success', 'Verification link has been sent to your new email address');
            }catch(\Exception $e){
                return back()->with('error', 'Something went wrong. Make sure your email is valid.');
            };
        }else{
            return back()->with('error', 'Something went wrong');
        }

    }

    public function verifyEmail(){
        $verification_code = \Illuminate\Support\Facades\Request::get('code');
        $email = base64_decode($verification_code);
        $user = User::where(['change_email' => $email])->first();

        if($user){
            $update = User::where('change_email', $email)->update([
                'email' => $email,
                'change_email' => ''
            ]);

            if($update){
                return redirect()->route('user.dashboard')->with('success', 'Email Updated Successfully!');
            }else{
                return back()->with('error', 'Something went wrong');
            }

        }

    }

}
