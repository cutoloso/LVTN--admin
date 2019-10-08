<?php

namespace App\Http\Controllers;
use Session;
use App\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sale = Sale::orderBy('date_end','desc')->paginate(10);
        return view('sales.index', ['sales' => $sale]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sale                = new Sale();
        $sale->name          = $request->name;
        $sale->description   = $request->description;
        $sale->date_start   = $request->date_start;
        $sale->date_end   = $request->date_end;
        $sale->save();
        Session::flash('success','Đã lưu thành công');
        return redirect()->route('sale.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale = Sale::find($id);
        return response()->json([
            'name'          => $sale->name,
            'description'   => $sale->description,
            'date_start'    => $sale->date_start,
            'date_end'      => $sale->date_end,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sale = Sale::find($id);
        $sale->name          = $request->name;
        $sale->description   = $request->description;
        $sale->date_start   = $request->date_start;
        $sale->date_end   = $request->date_end;
        $sale->save();
        Session::flash('success','Cập nhật thành công');
        return redirect()->route('sale.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = Sale::find($id);
        $sale->delete();
        Session::flash('success','Xóa thành công');
    }
}
