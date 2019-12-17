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
    public function getSalesByYear(Request $request){
        $year = $request->year;
        $month = $request->month;
        $salesByYear = [];
        if( $month == '-1'){
            for ($i=1; $i<=12; $i++){
                $data = DB::table("orders")
                    ->where('pay_sta_id',2)
                    ->whereRaw('YEAR(created_at) = ?',[$year])
                    ->whereRaw('MONTH(created_at) = ?',[$i])
                    ->select('total_price')
                    ->sum('total_price');
                array_push($salesByYear, $data);
            }
        }
        else{
            $dateString = $year.'-'.$month.'-01';
            //Last date of current month.
            $lastDateOfMonth = date("t", strtotime($dateString));

            for ($i=1; $i<=$lastDateOfMonth; $i++){
                $data = DB::table("orders")
                    ->where('pay_sta_id',2)
                    ->whereRaw('YEAR(created_at) = ?',[$year])
                    ->whereRaw('MONTH(created_at) = ?',[$month])
                    ->whereRaw('DAY(created_at) = ?',[$i])
                    ->select('total_price')
                    ->sum('total_price');
                array_push($salesByYear, $data);
            }
        }
        return response()->json(['data' => $salesByYear]);
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
        $m = $request->month;
//        $orderProduct = DB::table('order_product')->whereRaw('YEAR(warranty_start) = ?',[$year])->get();
        $orderProduct = DB::table('order_product')
            ->whereYear('warranty_start', $y)
            ->leftJoin('products','order_product.pro_id','products.id')
            ->leftJoin('brands','products.bra_id','brands.id')
            ->select('brands.name',DB::raw('SUM(order_product.price) totalPrice'))
            ->groupBy('brands.name');
        if ($m != '-1'){
            $orderProduct->whereMonth('warranty_start', $m);
        }

        return response()->json(['data' => $orderProduct->get()]);
    }

    public function getProductByBrand(Request $request){
        $bra_id = $request->bra_id;
        $y = $request->year;
        $m = $request->month;
        $orderProduct = DB::table('order_product')
            ->whereYear('warranty_start', $y)
            ->leftJoin('products','order_product.pro_id','products.id')
            ->leftJoin('brands','products.bra_id','brands.id')
            ->select(DB::raw('count(products.id) as count, products.name'))
            ->groupBy('products.name');
        if ($m != '-1'){
            $orderProduct->whereMonth('warranty_start', $m);
        }
        if ($bra_id != '-1'){
            $orderProduct->where('brands.id', $bra_id);
        }

        return response()->json(['data' => $orderProduct->get()]);
    }
}

