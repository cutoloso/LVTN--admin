<?php

namespace App\Http\Controllers;
use Session;
use App\PaymentStatus;
use Illuminate\Http\Request;

class PaymentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment_status = PaymentStatus::orderBy('name')->paginate(10);
        return view('paymentStatus.index', ['payment_status' => $payment_status]);
    }

    public function getPaymentStatus(){
        $payment_status = PaymentStatus::orderBy('id')->get();
        return response()->json(['payment_status' => $payment_status]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payment_status                = new PaymentStatus();
        $payment_status->name          = $request->name;
        $payment_status->description   = $request->description;
        $payment_status->save();
        Session::flash('success','Đã lưu thành công');
        return redirect()->route('payment-status.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentStatus  $paymentStatus
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment_status = PaymentStatus::find($id);
        return response()->json([
            'name'          => $payment_status->name,
            'description'   => $payment_status->description,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentStatus  $paymentStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $payment_status = PaymentStatus::find($id);
        $payment_status->name          = $request->name;
        $payment_status->description   = $request->description;
        $payment_status->save();
        Session::flash('success','Cập nhật thành công');
        return redirect()->route('payment-status.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentStatus  $paymentStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment_status = PaymentStatus::find($id);
        $payment_status->delete();
        Session::flash('success','Xóa thành công');
    }
}
