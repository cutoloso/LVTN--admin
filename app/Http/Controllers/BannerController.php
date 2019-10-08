<?php

namespace App\Http\Controllers;
use Session;
use Image;
use File;
use App\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::all();
        return view('banner.index',['banners' => $banners]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $banner = new Banner();
        $banner->link = $request->link;
        //save image
        if ($request->hasFile('img')){
            $image = $request->file('img');
            $filename = 'banner-'.time().'.'.$image->getClientOriginalExtension();
            $location = public_path('/storage/banners/'.$filename);
            Image::make($image)->save($location);
            $banner->img = $filename;
        }
        $banner->save();
        Session::flash('success','Đã lưu thành công');
        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Show object
        $banner = Banner::find($id);
        return response()->json([
            'link' => $banner->link,
            'img' => $banner->img
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $banner = Banner::find($id);
        $banner->link = $request->link;
        //save image
        if ($request->hasFile('img')){
            $filename_old = $banner->img;
            $image = $request->file('img');
            $filename = 'banner_'.time().'.'.$image->getClientOriginalExtension();
            $location = public_path('/storage/banners/'.$filename);
            Image::make($image)->save($location);
            $banner->img = $filename;
            $location_old = public_path('/storage/banners/'.$filename_old);
            File::delete($location_old);
        }
        $banner->save();

        Session::flash('success','Cập nhật thành công');

        return redirect()->route('banner.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy($banner)
    {
        // Delete object
        $banner_img = Banner::find($banner);
        $image_path = public_path('/storage/banners/'.$banner_img->img);
        File::delete($image_path);
        $banner_img->delete();
        Session::flash('success','Xóa thành công');
    }
}
