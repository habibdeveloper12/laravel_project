<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
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
        $products = Product::orderBy('id','DESC')->get();
        return view('backend.product.index', compact('products'));
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
        return view('backend.product.create');

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
            'photo' => 'nullable|mimes:png,jpg,jpeg|max:3000',
            'brand_id' => 'numeric|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'stock' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'cat_id' => 'required|exists:categories,id',
            'vendor_id' => 'required|exists:users,user_id',
            'delivery' => 'nullable|string',
            'server' => 'required|in:none,europe,north america,south america,africa,asia,australia',
        ]);

        $data['title'] = Brand::where('id', $request->brand_id)->first()->title;

        $slug = Str::slug($data['title']);
        $slug_count=Product::where('slug',$slug)->count();
        $seller = User::where('user_id', $request->vendor_id)->first();

        $data = $request->all();
        if($slug_count>0){
            $slug .= time(). '-' . $slug;
        }

        $power_id = Category::where('title', 'powerleveling')->first()->id;
        if($request->cat_id == $power_id){
            $data['stock'] = 'Unlimited';
        }
        if($request->photo){
            $im = $request->file('photo');
            $filename = $im->getClientOriginalName();
            $request->file('photo')->move(public_path('images/products'), $filename);
            $filepath = url('images/products/'.$filename);
            $data['photo'] = $filepath;
        }

        $data['slug'] = $slug;
        $data['user_id'] = $request->vendor_id;
        $data['added_by'] = $seller->username;

        $data['offer_price']  = ($request->price-($request->price* $request->discount)/100);

        $status = Product::create($data);
        if($status){
            return redirect()->route('product.index')->with('success', 'Product successfully created!');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        if($product){
            return view('backend.product.edit', compact(['product']));
        }else{
            return back()->with('error', 'Category not found');
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
                'photo' => 'nullable|mimes:png,jpg,jpeg|max:3000',
                'brand_id' => 'numeric|required',
                'summary' => 'string|required',
                'description' => 'string|nullable',
                'stock' => 'nullable|string',
                'price' => 'nullable|numeric',
                'cat_id' => 'required|exists:categories,id',
                'vendor_id' => 'required|exists:users,user_id',
                'delivery' => 'nullable|string',
                'server' => 'required|in:none,europe,north america,south america,africa,asia,australia',
            ]);
            $data =$request->all();

            $data['title'] = Brand::where('id', $request->brand_id)->first()->title;

            $power_id = Category::where('title', 'powerleveling')->first()->id;
            if($request->cat_id == $power_id){
                $data['stock'] = 'Unlimited';
            }

            if($request->photo){
                $im = $request->file('photo');
                $filename = $im->getClientOriginalName();
                $request->file('photo')->move(public_path('images/products'), $filename);
                $filepath = url('images/products/'.$filename);
                $data['photo'] = $filepath;
            }else{
                $data['photo'] = $product->photo;
            }

            $data['offer_price']  = ($request->price-($request->price* $request->discount)/100);

             $status = $product->fill($data)->save();
            if($status){
                return redirect()->route('product.index')->with('success', 'Successfully updated product!');
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
                return redirect()->route('product.index')->with('success', 'Product Successfully deleted');
            }else{
                return back()->with('error', 'Something went wrong');
            }
        }else{
            return back()->with('error', 'Product not found');
        }
    }



}
