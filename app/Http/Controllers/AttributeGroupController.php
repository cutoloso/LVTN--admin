<?php

namespace App\Http\Controllers;

use Session;
use App\AttributeGroupAttribute;
use App\AttributeGroup;
use Illuminate\Http\Request;

class AttributeGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attribute_group = AttributeGroup::orderBy('name')->paginate(10);
        return view('attributeGroup.index', ['attribute_group' => $attribute_group]);
    }

    public function getAttributeGroup()
    {
        $attribute_group = AttributeGroup::orderBy('name')->get();
        return response()->json(['attribute_group' => $attribute_group]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attribute_group                = new AttributeGroup();
        $attribute_group->name          = $request->name;
        $attribute_group->alias         = $request->alias;
        $attribute_group->att_name_1    = $request->att_name_1;
        $attribute_group->att_name_2    = $request->att_name_2;
        $attribute_group->save();
        Session::flash('success','Đã lưu thành công');
        return redirect()->route('attribute-group.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AttributeGroup  $attributeGroup
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $attribute_group = AttributeGroup::find($id);
        return response()->json([
            'name'          => $attribute_group->name,
            'alias'         => $attribute_group->alias,
            'att_name_1'    => $attribute_group->att_name_1,
            'att_name_2'    => $attribute_group->att_name_2
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AttributeGroup  $attributeGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $attribute_group = AttributeGroup::find($id);
        $attribute_group->name          = $request->name;
        $attribute_group->alias         = $request->alias;
        $attribute_group->att_name_1    = $request->att_name_1;
        $attribute_group->att_name_2    = $request->att_name_2;
        $attribute_group->save();
        Session::flash('success','Cập nhật thành công');
        return redirect()->route('attribute-group.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AttributeGroup  $attributeGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attribute_group = AttributeGroup::find($id);
        $attribute_group->delete();
        AttributeGroupAttribute::where('att_gr_id',$id)->delete();
        Session::flash('success','Xóa thành công');
    }
    public function postAttribute(Request $request)
    {
        $idGroup = $request->idGroup;
        $arrAtt = $request->atts;
        $arrAtt_start = explode(",",$request->arrs_start);
        foreach ($arrAtt as $att){
            AttributeGroupAttribute::firstOrCreate(
                ['att_gr_id'=>$idGroup, 'att_id'=>$att]
            );
        }
        foreach ($arrAtt_start as $start){
            if (!in_array($start, $arrAtt)) {
                AttributeGroupAttribute::where(['att_gr_id'=>$idGroup, 'att_id'=>$start])->delete();
            }
        }
        Session::flash('success','Cập nhật thành công');
        return redirect()->route('attribute-group.index');
    }
}
