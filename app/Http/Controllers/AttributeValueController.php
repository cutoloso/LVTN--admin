<?php

namespace App\Http\Controllers;
use App\AttributeValue;
use App\AttributeGroupAttribute;
use DB;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $att_val = DB::table('attribute_value')->where('pro_id',$id)
        ->leftJoin('attributes','attribute_value.att_id','=','attributes.id')
        ->select('attribute_value.*','attributes.name')
        ->orderBy('attributes.id')
        ->paginate(20);
        return view('attributeValue.index', [
            'att_vals'  => $att_val,
            'pro_id'    => $id
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
//    public function store(Request $request)
//    {
//        $attribute = new Attribute();
//        $attribute->name = $request->name;
//        $attribute->save();
//        Session::flash('success','Đã lưu thành công');
//        return redirect()->route('attributes.index');
//    }

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
    public function update(Request $request, $id, $attribute_value)
    {
        DB::table('attribute_value')->where([['pro_id','=',$id],['att_id','=',$attribute_value]])->update([
            'att_value' => $request->att_value,
        ]);
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
