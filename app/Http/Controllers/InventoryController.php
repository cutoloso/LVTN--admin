<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\Product, DB, Session;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $products = DB::table('products');
        if (isset($request->sort) && isset($request->order)){
            $products->orderBy($request->sort, $request->order);
        }
        else{
            $products->orderBy('products.quatity');
        }
        return view('inventory.index', ['products' => $products->paginate(30)]);
    }

    public function show($id){
        $product = DB::table('products')->where('id',$id)->first();
        $inventory = DB::table('inventory')->where('pro_id',$id)->get();
        return view('inventory.show',  ['product' => $product, 'inventorys' => $inventory]);
    }
    public function store(Request $request){
        $inventory = new Inventory();
        $inventory->updated_at = $request->date;
        $inventory->quantity = $request->quantity;
        $inventory->pro_id = $request->pro_id;
        $inventory->save();

        $product = Product::find($request->pro_id);
        $product->quatity += $request->quantity;
        $product->save();
        Session::flash('success','Cập nhật thành công');
        return redirect()->back();
    }
}
