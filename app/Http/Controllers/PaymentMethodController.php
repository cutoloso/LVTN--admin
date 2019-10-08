<?php

namespace App\Http\Controllers;
use Session;
use App\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment_method = PaymentMethod::orderBy('name')->paginate(10);
        return view('paymentMethod.index', ['payment_method' => $payment_method]);
    }

    public function getPaymentMethod(){
        $payment_method = PaymentMethod::orderBy('id')->first();
        return response()->json(['payment_method' => $payment_method]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payment_method                = new PaymentMethod();
        $payment_method->name          = $request->name;
        $payment_method->description   = $request->description;
        $payment_method->save();
        Session::flash('success','Đã lưu thành công');
        return redirect()->route('payment-method.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment_method = PaymentMethod::find($id);
        return response()->json([
            'name'          => $payment_method->name,
            'description'   => $payment_method->description,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $payment_method = PaymentMethod::find($id);
        $payment_method->name          = $request->name;
        $payment_method->description   = $request->description;
        $payment_method->save();
        Session::flash('success','Cập nhật thành công');
        return redirect()->route('payment-method.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment_method = PaymentMethod::find($id);
        $payment_method->delete();
        Session::flash('success','Xóa thành công');
    }
}
