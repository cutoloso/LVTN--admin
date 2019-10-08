<?php

namespace App\Http\Controllers;
use App\AttributeGroupAttribute;
use App\AttributeValue;
use http\Env\Response;
use Session;
use App\Product;
use App\ProductImage;
use Image;
use Illuminate\Http\Request;
use DB;

use App\Exports\ProductExport;
use App\Imports\ProductImport;
use Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = DB::table('products')
            ->leftJoin('brands','products.bra_id','=','brands.id')
            ->leftJoin('suppliers', 'products.sup_id', '=', 'suppliers.id')
            ->leftJoin('attribute_group', 'products.att_gr_id', '=', 'attribute_group.id')
            ->select('products.*', 'brands.name as bra_name', 'suppliers.name as sup_name', 'attribute_group.name as att_gr_name');

        if (isset($request->sort) && isset($request->order)){
            $products->orderBy($request->sort, $request->order);
        }
        else{
            $products->orderBy('products.created_at','desc');
        }
        return view('product.index',['products'=>$products->paginate(10)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product        = new Product();
        $product->name  = $request->name;
        $product->code  = $request->code;
        $product->alias  = $request->alias;
        $product->price  = $request->price;
        $product->price_sale  = ($request->price_sale !='')? $request->price_sale:$request->price;
        $product->parent  = $request->parent;
        $product->quatity  = $request->quatity;
        $product->warranty    = $request->warranty;
        $product->description = $request->description;
        if ($request->active) $product->active = 1;
        else $product->active = 0;
        if ($request->best_sale) $product->best_sale = 1;
        else $product->best_sale = 0;
        if ($request->best_feature) $product->best_feature = 1;
        else $product->best_feature = 0;
        $product->sup_id  = $request->sup_id;
        $product->bra_id  = $request->bra_id;
        $product->att_gr_id  = $request->att_gr_id;

        $product->save();
        if ($product->att_gr_id != ''){
            $this->createAttVal($product->id, $product->att_gr_id);
        }

        //save image
        if ($request->hasFile('img')){
            $product_img = new ProductImage();
            $product_img->pro_id = $product->id;
            $image = $request->file('img');
            $filename = 'product-'.$product->id.'-'.time().'.'.$image->getClientOriginalExtension();
            $location = public_path('/storage/products/'.$filename);
            Image::make($image)->save($location);
            $product_img->img = $filename;
            $product_img->active = 1;
            $product_img->save();
        }

        Session::flash('success','Đã lưu thành công');
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product        = Product::find($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->name          = $request->name;
        $product->code          = $request->code;
        $product->alias         = $request->alias;
        $product->price         = $request->price;
        $product->price_sale    = $request->price_sale;
        $product->parent        = $request->parent;
        $product->quatity       = $request->quatity;
        $product->warranty       = $request->warranty;
        $product->description = $request->description;
        if ($request->active) $product->active = 1;
        else $product->active = 0;
        if ($request->best_sale) $product->best_sale = 1;
        else $product->best_sale = 0;
        if ($request->best_feature) $product->best_feature = 1;
        else $product->best_feature = 0;
        $product->sup_id        = $request->sup_id;
        $product->bra_id        = $request->bra_id;
        if ($product->att_gr_id != $request->att_gr_id){
            $this->destroyoAttVal($product->id);
            $product->att_gr_id     = $request->att_gr_id;
            $this->createAttVal($product->id, $product->att_gr_id);
        }
        $product->save();

        //save image
        if ($request->hasFile('img')){
            // Delete object
            $product_img = ProductImage::where('pro_id',$product->id)->where('active',1)->first();
            if($product_img){
                $image_path = public_path('/storage/products/'.$product_img->img);
                File::delete($image_path);
                $product_img->delete();
            }

            $product_img = new ProductImage();
            $product_img->pro_id = $product->id;
            $image = $request->file('img');
            $filename = 'product-'.$product->id.'-'.time().'.'.$image->getClientOriginalExtension();
            $location = public_path('/storage/products/'.$filename);
            Image::make($image)->save($location);
            $product_img->img = $filename;
            $product_img->active = 1;
            $product_img->save();
        }

        Session::flash('success','Cập nhật thành công');
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        $this->destroyoAttVal($id);
        Session::flash('success','Xóa thành công');
    }

    public function createAttVal($pro_id, $att_gr_id)
    {
        $Att_gr_id = AttributeGroupAttribute::where('att_gr_id',$att_gr_id)->get();
        foreach ($Att_gr_id as $item){
            AttributeValue::create(['att_id'=>$item->att_id, 'pro_id'=> $pro_id, 'att_value'=>'Đang cập nhật']);
        }
    }

    public function destroyoAttVal($pro_id)
    {
        AttributeValue::where('pro_id',$pro_id)->delete();
    }

    public function create(){
        return view('product.create');
    }
    public function edit($id){
        $product = Product::find($id);
        return view('product.edit',['product'=>$product]);
    }
    public function importView(){
        return view('product.import');
    }
    public function import(Request $request){
        if ($request->file->getClientOriginalExtension() != '.csv'){
            Session::flash('false','Vui lòng import file định dạng .csv.');
            return back();
        }
        $path = $request->file->getRealPath();
        $data = Excel::load($path)->get();
        foreach ($data as $value){
            $arr [] = [
                'name'          => $value->name,
                'code'          => $value->code,
                'alias'         => $value->alias,
                'price'         => (int)$value->price,
                'price_sale'    => (int)$value->price_sale,
                'sup_id'        => (int)$value->sup_id,
                'bra_id'        => (int)$value->bra_id,
                'att_gr_id'     => (int)$value->att_gr_id,
                'warranty'      => (int)$value->warranty
            ];
        }
        if (!empty($arr)){
            foreach ($arr as $item){
                Product::create($item);
            }
            Session::flash('success','Thêm sản phẩm thành công.');
        }
        else{
            Session::flash('false','Có lỗi khi thêm sản phẩm.');
        }
        return back();
    }

    public function export(Request $request){
        $product = Product::all();

        return Excel::create('danh-sach-san-pham', function ($excel) use ($product){
            $excel->sheet('danh sach san pham', function ($sheet) use ($product){
               $sheet->fromArray($product);
            });
        })->download($request->type);
    }
}
