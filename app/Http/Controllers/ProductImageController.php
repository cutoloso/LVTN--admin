<?php

namespace App\Http\Controllers;

use App\ProductImage;
use Image;
use Session;
use File;
use Storage;
use DB;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $product_img = ProductImage::where('pro_id',$id)->get();
        return view('product.gallery',
            [
                'id'            => $id,
                'product_img'   => $product_img
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $gallery)
    {
        $product_img = ProductImage::find($gallery);
        return response()->json([
            'product_img' => $product_img
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $gallery)
    {
        $product_img = ProductImage::find($gallery);
        //active
        if ($request->active) {
            DB::table('product_image')->where('pro_id',$id)->update(['active' => 0]);
            $product_img->active = 1;
            $product_img->save();
        }
        elseif($product_img->active != 0){
            $product_img->active = 0;
            $product_img->save();
            Session::flash('success','Cập nhật thành công');
        }
        //front
        if ($request->front) {
            DB::table('product_image')->where('pro_id',$id)->update(['front' => 0]);
            $product_img->front = 1;
            $product_img->save();
        }
        elseif($product_img->front != 0){
            $product_img->front = 0;
            $product_img->save();
            Session::flash('success','Cập nhật thành công');
        }
        //back
        if ($request->back) {
            DB::table('product_image')->where('pro_id',$id)->update(['back' => 0]);
            $product_img->back = 1;
            $product_img->save();
        }
        elseif($product_img->back != 0){
            $product_img->back = 0;
            $product_img->save();
            Session::flash('success','Cập nhật thành công');
        }
        //above
        if ($request->above) {
            DB::table('product_image')->where('pro_id',$id)->update(['above' => 0]);
            $product_img->above = 1;
            $product_img->save();
        }
        elseif($product_img->above != 0){
            $product_img->above = 0;
            $product_img->save();
            Session::flash('success','Cập nhật thành công');
        }
        //below
        if ($request->below) {
            DB::table('product_image')->where('pro_id',$id)->update(['below' => 0]);
            $product_img->below = 1;
            $product_img->save();
        }
        elseif($product_img->below != 0){
            $product_img->below = 0;
            $product_img->save();
            Session::flash('success','Cập nhật thành công');
        }
        //left
        if ($request->left) {
            DB::table('product_image')->where('pro_id',$id)->update(['left' => 0]);
            $product_img->left = 1;
            $product_img->save();
        }
        elseif($product_img->left != 0){
            $product_img->left = 0;
            $product_img->save();
            Session::flash('success','Cập nhật thành công');
        }
        //right
        if ($request->right) {
            DB::table('product_image')->where('pro_id',$id)->update(['right' => 0]);
            $product_img->right = 1;
            $product_img->save();
        }
        elseif($product_img->right != 0){
            $product_img->right = 0;
            $product_img->save();
            Session::flash('success','Cập nhật thành công');
        }
        if( $product_img->active || $product_img->front || $product_img->back || $product_img->left || $product_img->right || $product_img->above || $product_img->below )
            Session::flash('success','Cập nhật thành công');

        return redirect()->back();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
//        dd($request->file('img')[0]);
        if ($request->hasFile('img')){
            foreach ($request->file('img') as $image){
                $product_img = new ProductImage();
                $product_img->pro_id = $id;
                //save image
                sleep(1);
                $filename = 'product-'.$id.'-'.time().'.'.$image->getClientOriginalExtension();
                $location = public_path('/storage/products/'.$filename);
                Image::make($image)->save($location);
                $product_img->img = $filename;
                $product_img->save();
            }
            Session::flash('success','Đã lưu thành công');
        }
        else{
            Session::flash('error','Có lỗi khi thêm mới hình ảnh, vui long kiểm tra lại');
        }
        return $this->index($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id, $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $gallery)
    {
        // Delete object
        $product_img = ProductImage::find($gallery);
        $image_path = public_path('/storage/products/'.$product_img->img);
        File::delete($image_path);
        $product_img->delete();
        Session::flash('success','Xóa thành công');
    }
}
