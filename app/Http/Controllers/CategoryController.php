<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth('admin')->user();
        if($user) {
            $categories = Category::orderBy('id', 'DESC')->get();
            return view('backend.category.index', compact('categories'));
        }else{
            return redirect()->route('user.auth');
        }
    }

    public function categoryStatus(Request $request)
    {
        $user = auth('admin')->user();
        if($user) {
            if ($request->mode == 'true') {
                DB::table('categories')->where('id', $request->id)->update(['status' => 'active']);
            } else {
                DB::table('categories')->where('id', $request->id)->update(['status' => 'inactive']);
            }
            return response()->json(['msg' => 'Successfully updated status', 'status' => true]);
        }else{
            return redirect()->route('user.auth');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth('admin')->user();
        if($user) {
            $parent_cats = Category::where('is_parent', 1)->orderBy('title', 'ASC')->get();
            return view('backend.category.create', compact('parent_cats'));
        }else{
            return redirect()->route('user.auth');
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
        $user = auth('admin')->user();
        if($user) {
            $this->validate($request, [
                'title' => 'string|required',
                'summary' => 'string|nullable',
                'parent_id' => 'nullable|exists:categories,id',
                'status' => 'required|in:active,inactive',
                'rate' => 'required|numeric|between:1,100',

            ]);
            $data = $request->all();
            $slug = Str::slug($request->input('title'));
            $slug_count = Category::where('slug', $slug)->count();

            if ($slug_count > 0) {
                $slug .= time() . '-' . $slug;
            }
            $data['slug'] = $slug;
            $data['is_parent'] = 1;
            $data['rate_per_purchase'] = $request->rate;


            $status = Category::create($data);
            if ($status) {
                return redirect()->route('category.index')->with('success', 'Category successfully created!');
            } else {
                return back()->with('error', 'Something went wrong!');
            }
        }else{
            return redirect()->route('user.auth');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $parent_cats=Category::where('is_parent', 1)->orderBy('title', 'ASC')->get();

        if($category){
            return view('backend.category.edit', compact(['category', 'parent_cats']));
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
        $category = Category::find($id);
        if($category){
            $this-> validate($request, [
                'title' => 'string|required',
                'summary' => 'string|nullable',
                'rate' => 'required|numeric|between:1,100',
                'parent_id' => 'nullable|exists:categories,id',
            ]);
            $data =$request->all();

            if($request->is_parent ==1){
                $data['parent_id'] = null;
            }

            $data['rate_per_purchase'] = $request->rate;

            $data['is_parent'] = 1;
            $status = $category->fill($data)->save();
            if($status){
                return redirect()->route('category.index')->with('success', 'Successfully updated category!');
            }else{
                return back()->with('error', 'Something went wrong!');
            }
        }else{
            return back()->with('error', 'Category not found');
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
        $category = Category::find($id);
        $child_cat_id = Category::where('parent_id', $id)->pluck('id');
        if($category){
            $status =$category->delete();
            if($status){
                if(count($child_cat_id)>0){
                    Category::shiftChild($child_cat_id);
                }
                return redirect()->route('category.index')->with('success', 'Category Successfully deleted');
            }else{
                return back()->with('error', 'Something went wrong');
            }
        }else{
            return back()->with('error', 'Data not found');
        }
    }

    public function getChildByParentID(Request $request,$id): \Illuminate\Http\JsonResponse
    {
            $category=Category::find($request->id);
            if($category){
                $child_id=Category::getChildByParentID($request->id);
                if(count($child_id)<=0){
                    return response()->json(['status'=>false, 'data'=>null, 'msg'=>'']);
                }
                return response()->json(['status'=>true, 'data'=>$child_id, 'msg'=>'']);

            }else{
                return response()->json(['status'=>false, 'data'=>null, 'msg'=>'Category not found']);
            }
    }
}
