<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
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
            if($user->seller == 1){

                $products = Product::where(['user_id' => $user->user_id ])->orderBy('id','DESC')->get();
                return view('seller.product.index', compact('products', 'user'));
            }else{
                return view('seller.product.seller_term');
            }

        }else{
            return redirect()->route('user.auth')->with('error','Please login to sell product');

        }
    }

    public function newOffer(Request $request, $id)
    {
        $this-> validate($request, [
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'stock' => 'nullable',
            'price' => 'required|numeric',
            'delivery' => 'required|string',
            'brand_id' => 'required|numeric',
            'server' => 'required|in:none,europe,north america,south america,africa,asia,australia',
        ]);
        $data =$request->all();

        $slug = Str::slug($data['summary']);
        $slug_count=Product::where('slug',$slug)->count();

        if($slug_count>0){
            $slug .= time(). '-' . Str::random(4);
        }

        $data['cat_id'] = $id;

        $power_id = Category::where('title', 'powerleveling')->first()->id;

        if($id == $power_id){
            $data['stock'] = 'Unlimited';
            $data['cat_id'] = $id;
        }

        $data['title'] = Brand::where('id', $request->brand_id)->first()->title;


        $data['slug'] = $slug;
        $data['added_by'] = Auth::user()->username;
        $data['user_id'] = Auth::user()->user_id;
        $data['status'] = 'active';

        $data['offer_price']  = ($request->price);


        $status = Product::create($data);
        if($status){
            $data['success'] = 1;
            $data['message'] = 'Uploaded Successfully!';
        }else{
            $data['success'] = 0;
        }

        return response()->json($data);

    }



    public function sellerTerms(Request $request)
    {
        DB::table('users')->where('user_id', $request->user_id)->update(['seller'=>1]);

        $user = Auth::user();


        $products = Product::where(['added_by' => $user->username,'user_id'=> $user->id ])->orderBy('id','DESC')->get();

        return view('seller.product.index', compact('products', 'user'));
    }

    public function productStatus(Request $request)
    {
        if($request->mode=='true'){
            DB::table('products')->where('id', $request->id)->update(['status'=>'active']);
        }else{
            DB::table('products')->where('id', $request->id)->update(['status'=>'inactive']);
        }
        return response()->json(['msg'=>'Successfully updated product', 'status' =>true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        if ($user) {
        return view('seller.product.create', compact( 'user'));
    }else{
        return redirect()->route('user.auth')->with('error','Please login to sell product');
    }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this-> validate($request, [
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'stock' => 'nullable',
            'photo' => 'nullable|mimes:png,jpg,jpeg|max:3000',
            'price' => 'required|numeric',
            'cat_id' => 'required|exists:categories,id',
            'delivery' => 'required|string',
            'brand_id' => 'required|numeric',
            'server' => 'required|in:none,europe,north america,south america,africa,asia,australia',
        ]);
        $data =$request->all();

        if($request->photo){
            $im = $request->file('photo');
            $filename = $im->getClientOriginalName();
            $request->file('photo')->move(public_path('images/products'), $filename);
            $filepath = url('images/products/'.$filename);
        }



        $slug = Str::slug($data['summary']);
        $slug_count=Product::where('slug',$slug)->count();

        if($slug_count>0){
            $slug .= time(). '-' . Str::random(4);
        }

        $power_id = Category::where('title', 'powerleveling')->first()->id;
        if($request->cat_id == $power_id){
            $data['stock'] = 'Unlimited';
        }
        $data['slug'] = $slug;
        if ($request->photo){
            $data['photo'] = $filepath;
        }
        $data['added_by'] = Auth::user()->username;
        $data['user_id'] = Auth::user()->user_id;
        $data['status'] = 'active';
        $data['title'] = Brand::where('id', $request->brand_id)->first()->title;


        $data['offer_price']  = ($request->price-($request->price * $request->discount)/100);


        $status = Product::create($data);

        if($status){
            return redirect()->route('seller-product.index')->with('success', 'Product successfully created!');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
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
            $conversations = Message::orderBy('id', 'DESC')->where('user_id', crc32($user->full_name))
                ->orWhere('receiver_id', crc32($user->full_name))->get();

            $users = $conversations->map(function ($conversation) {
                if ($conversation->receiver_id == crc32(Auth::user()->full_name)) {
                    return User::where('user_id', $conversation->user_id)->get(['full_name', 'id', 'last_seen', 'user_id', 'photo', 'username', 'full_name']);;
                }
            })->unique();

            $product = Product::find($id);
            $productattr = ProductAttribute::where('product_id', $id)->orderBy('id', 'DESC')->get();

            if ($product) {
                return view('seller.product.product-attribute', compact(['product', 'productattr', 'users', 'user']));
            } else {
                return back()->with('error', 'Product not found');
            }
        }else{
                return redirect()->route('user.auth')->with('error','Please login to sell product');
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
        $user = Auth::user();

        if($user) {

            $product = Product::find($id);
            if ($product) {
                return view('seller.product.edit', compact(['product',  'user']));
            } else {
                return back()->with('error', 'Category not found');
            }

        }else{
            return redirect()->route('user.auth')->with('error','Please login to sell product');
        }
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
        $product = Product::find($id);
        if($product){
            $this-> validate($request, [
                'summary' => 'string|required',
                'description' => 'string|nullable',
                'stock' => 'nullable',
                'photo' => 'nullable|mimes:png,jpg,jpeg|max:3000',
                'discount' => 'nullable|numeric',
                'price' => 'required|numeric',
                'cat_id' => 'required|exists:categories,id',
                'delivery' => 'required|string',
                'brand_id' => 'required|numeric',
                'server' => 'required|in:none,europe,north america,south america,africa,asia,australia',
            ]);
            $data =$request->all();
            if($request->photo){
                $im = $request->file('photo');
                $filename = $im->getClientOriginalName();
                $request->file('photo')->move(public_path('images/products'), $filename);
                $filepath = url('images/products/'.$filename);
                $data['photo'] = $filepath;
            }

            $data['title'] = Brand::where('id', $request->brand_id)->first()->title;
            $data['offer_price']  = ($request->price-($request->price* $request->discount)/100);

            $status = $product->fill($data)->save();
            if($status){
                return redirect()->route('seller-product.index')->with('success', 'Successfully updated product!');
            }else{
                return back()->with('error', 'Something went wrong!');
            }
        }else{
            return back()->with('error', 'product not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if($product){
            $status =$product->delete();
            if($status){
                return redirect()->route('seller-product.index')->with('success', 'Product Successfully deleted');
            }else{
                return back()->with('error', 'Something went wrong');
            }
        }else{
            return back()->with('error', 'Product not found');
        }
    }



}
