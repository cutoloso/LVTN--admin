<?php

namespace App\Http\Controllers;

use App\Brand;
use Image;
use Illuminate\Http\Request;
use Session;
use File;
use Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::orderBy('created_at','desc')->paginate(5);
        return view('brand.index', ['brands' => $brands]);
    }

    public function getBrand()
    {
        $brands = Brand::orderBy('name')->get();
        return response()->json(['brands' => $brands]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create new object
        $brand = new Brand();
        $brand->name = $request->name;
        //save image
        if ($request->hasFile('img')){
            $image = $request->file('img');
            $filename = 'brand_'.time().'.'.$image->getClientOriginalExtension();
            $location = public_path('/storage/brands/'.$filename);
            Image::make($image)->save($location);
            $brand->img = $filename;
        }
        else
            $brand->img = '';
        $brand->save();
        Session::flash('success','Đã lưu thành công');
        return redirect()->route('brands.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Show object
        $brand = Brand::find($id);
        return response()->json([
            'name' => $brand->name,
            'img' => $brand->img
        ]);
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
        // Edit object
        $brand = Brand::find($id);
        $brand->name = $request->name;
        //save image
        if ($request->hasFile('img')){
            $filename_old = $brand->img;
            $image = $request->file('img');
            $filename = 'brand_'.time().'.'.$image->getClientOriginalExtension();
            $location = public_path('/storage/brands/'.$filename);
            Image::make($image)->save($location);
            $brand->img = $filename;
            $location_old = public_path('/storage/brands/'.$filename_old);
            File::delete($location_old);
        }
        $brand->save();

        Session::flash('success','Cập nhật thành công');

        return redirect()->route('brands.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete object
        $brand = Brand::find($id);
        $image_path = public_path('/storage/brands/'.$brand->img);

        File::delete($image_path);
        $brand->delete();
        Session::flash('success','Xóa thành công');
    }
}
