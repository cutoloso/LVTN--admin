<?php

namespace App\Http\Controllers;

use App\Supplier;
use Image;
use Illuminate\Http\Request;
use Session;
use File;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Suppliers = Supplier::orderBy('created_at','desc')->paginate(10);
        return view('supplier.index', ['suppliers' => $Suppliers]);
    }

    public function getSupplier()
    {
        $Suppliers = Supplier::orderBy('name')->get();
        return response()->json(['suppliers' => $Suppliers]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create new object
        $supplier = new Supplier();
        $supplier->name = $request->name;
        //save image
        if ($request->hasFile('img')){
            $image = $request->file('img');
            $filename = 'supplier_'.time().'.'.$image->getClientOriginalExtension();
            $location = public_path('storage/suppliers/'.$filename);
            Image::make($image)->save($location);
            $supplier->img = $filename;
        }
        else
            $supplier->img = '';
            $supplier->save();
            Session::flash('success','Đã lưu thành công');
        return redirect()->route('suppliers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Show object
        $supplier = Supplier::find($id);
        return response()->json([
            'name' => $supplier->name,
            'img' => $supplier->img
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Edit object
        $supplier = Supplier::find($id);
        $supplier->name = $request->name;
        //save image
        if ($request->hasFile('img')){
            $filename_old = $supplier->img;
            $image = $request->file('img');
            $filename = 'supplier_'.time().'.'.$image->getClientOriginalExtension();
            $location = public_path('storage/suppliers/'.$filename);
            Image::make($image)->save($location);
            $supplier->img = $filename;
            File::delete('storage/suppliers/'.$filename_old);
        }
        $supplier->save();

        Session::flash('success','Cập nhật thành công');

        return redirect()->route('suppliers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete object
        $supplier = Supplier::find($id);
        File::delete('storage/suppliers/'.$supplier->img);
        $supplier->delete();
        Session::flash('success','Xóa thành công');
    }
}
