<?php

namespace App\Http\Controllers;
use App\Order;
use App\OrderProduct;
use App\Product;
use Carbon\Carbon;
use DB, Session;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request){
        $orders = DB::table('orders')
            ->join('status','status.id','orders.sta_id')
            ->join('payment_status','payment_status.id','orders.pay_sta_id')
            ->join('payment_method','payment_method.id','orders.pay_mth_id')
            ->select('orders.*','status.name as status_name', 'status.color_code', 'status.bg_color_code', 'payment_status.name as payment_status_name', 'payment_status.id as payment_status_id', 'payment_method.name as payment_method_name');
        if (isset($request->sort) && isset($request->order)){
            $orders->orderBy($request->sort, $request->order);
        }
        else{
            $orders->orderBy('orders.created_at','desc');
        }
        return view('order.index',[
            'orders'=>$orders->paginate(50)
        ]);
    }
    public function show($id){
        $order = DB::table('orders')
            ->where('orders.id', $id)
            ->join('status','status.id','orders.sta_id')
            ->join('payment_status','payment_status.id','orders.pay_sta_id')
            ->join('payment_method','payment_method.id','orders.pay_mth_id')
            ->select('orders.*','status.name as status_name', 'status.color_code', 'status.bg_color_code', 'payment_status.name as payment_status_name', 'payment_method.name as payment_method_name')
            ->first();
        return response()->json(['order'=>$order]);
    }

    public function update($id, Request $request){
        $order = Order::find($id);
        $order->sta_id = $request->sta_id;
        if ($request->pay_sta_id && $request->pay_sta_id == 2){
            $order->pay_sta_id = $request->pay_sta_id;
            $orderProduct = DB::table('order_product')->where('ord_id',$id)->get();
            $dateNow = Carbon::now();
            foreach ($orderProduct as $item) {
                $warranty = Product::find($item->pro_id)->warranty;
                OrderProduct::where('ord_id',$id)
                    ->where('pro_id', $item->pro_id)
                    ->update([
                        'warranty_start'    => Carbon::now(),
                        'warranty_end'      => Carbon::now()->addMonths($warranty),
                        ]);
            }
        }
        $order->save();
        Session::flash('success','Cập nhật thành công');
        return redirect('order/show/'.$id);
    }

    public function showOrderDetail($id){
        $orderProduct = DB::table('order_product')
            ->join('products','order_product.pro_id','=','products.id')
            ->where('ord_id', $id)
            ->select('order_product.*', 'products.name', 'products.code')
            ->get();

        $order = DB::table('orders')
            ->where('orders.id', $id)
            ->join('payment_method','orders.pay_mth_id','=','payment_method.id')
            ->join('payment_status','orders.pay_sta_id','=','payment_status.id')
            ->join('status','orders.sta_id','=','status.id')
            ->select('orders.*', 'payment_method.name as pay_mth_name', 'payment_status.name as pay_sta_name', 'status.name as sta_name')
            ->first();
        return view('order.show',[
            'orderProduct'  => $orderProduct,
            'order'         => $order
        ]);
    }
}
