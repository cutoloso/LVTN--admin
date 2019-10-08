<?php

namespace App\Http\Controllers;

use App\AttributeGroupAttribute;
use Session;
use App\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attribute = Attribute::orderBy('name')->paginate(10);
        return view('attribute.index', ['attributes' => $attribute]);
    }
//    api get list attribute
    public function getAttribute($id)
    {
        $attribute = Attribute::all();
        $attGroupAtt = AttributeGroupAttribute::where('att_gr_id',$id)->get();
        return response()->json([
            'attributes' => $attribute,
            'attributesGroupAttribute'=>$attGroupAtt
            ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attribute = new Attribute();
        $attribute->name = $request->name;
        $attribute->save();
        Session::flash('success','Đã lưu thành công');
        return redirect()->route('attributes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $attribute = Attribute::find($id);
        return response()->json([
            'name'          => $attribute->name,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $attribute = Attribute::find($id);
        $attribute->name          = $request->name;
        $attribute->save();
        Session::flash('success','Cập nhật thành công');
        return redirect()->route('attributes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attribute = Attribute::find($id);
        $attribute->delete();
        AttributeGroupAttribute::where('att_id',$id)->delete();

        Session::flash('success','Xóa thành công');
    }
}
