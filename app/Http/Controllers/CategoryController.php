<?php

namespace App\Http\Controllers;

use Session;
use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::orderBy('sort_order')->paginate(10);
        return view('category.index', ['category' => $category]);
    }
    public function getCategory()
    {
        $category = Category::all();
        return response()->json(['category' => $category]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->icon         = $request->icon;
        $category->name         = $request->name;
        $category->sort_order   = $request->sort_order;
        $category->save();
        Session::flash('success','Đã lưu thành công');
        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        return response()->json([
            'icon'          => $category->icon,
            'name'          => $category->name,
            'sort_order'    => $category->sort_order
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->icon = $request->icon;
        $category->name = $request->name;
        $category->sort_order = $request->sort_oder;
        $category->save();
        Session::flash('success','Cập nhật thành công');
        return redirect()->route('Category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        Session::flash('success','Xóa thành công');
    }
}
