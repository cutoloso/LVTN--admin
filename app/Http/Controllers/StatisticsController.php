<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class StatisticsController extends Controller
{
    public function index(){
        return view('statistics.index');
    }
    /**
     * Tính doanh thu theo từng tháng,
     * Trả về mảng chứa 12 phần tử tưng ứng vs 12 tháng
     */
    public function getSalesByMounth(Request $request){
        $year = $request->year;
        $salesByMount = [];
        for ($i=1; $i<=12; $i++){
            $data = DB::table("orders")
                ->where('pay_sta_id',2)
                ->whereRaw('YEAR(created_at) = ?',[$year])
                ->whereRaw('MONTH(created_at) = ?',[$i])
                ->select('total_price')
                ->sum('total_price');
            array_push($salesByMount, $data);
        }
        return response()->json(['data' => $salesByMount]);
    }

    public function getOrderYear(){
        $orderYear = DB::table('orders')
            ->select(DB::raw('YEAR(created_at) year'))
            ->groupby('year')
            ->orderBy('year','desc')
            ->get();
        return response()->json(['data' => $orderYear]);
    }

    public function getSalesByBrand(Request $request){
        $y = $request->year;
//        $orderProduct = DB::table('order_product')->whereRaw('YEAR(warranty_start) = ?',[$year])->get();
        $orderProduct = DB::table('order_product')
            ->whereYear('warranty_start', $y)
            ->leftJoin('products','order_product.pro_id','products.id')
            ->leftJoin('brands','products.bra_id','brands.id')
            ->select('brands.name',DB::raw('SUM(order_product.price) totalPrice'))
            ->groupBy('brands.name')
            ->get();
        return response()->json(['data' => $orderProduct]);
    }
}

