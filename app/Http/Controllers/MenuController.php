<?php

namespace App\Http\Controllers;
use DB;
use Session;
use App\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = DB::table('menus')
            ->leftJoin('category','menus.cat_id','=','category.id')
            ->select('menus.*','category.name as name')
            ->orderBy('menus.sort')
            ->get();
        return view('menu.index', ['menus' => $menus]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $menus = Menu::orderBy('sort','desc')->first();
        if ($menus){
            Menu::create(['sort' => (int)$menus->sort +1, 'cat_id' =>$request->cat_id]);
        }
        else{
            Menu::create(['sort' => 1, 'cat_id' =>$request->cat_id]);
        }
        return $this->index();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $memu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::where('cat_id',$id);
        $menu->link = $request->link;
        $menu->update(['link'=>$request->link]);
        Session::flash('success','Đã cập nhật thành công');
        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $memu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('menus')->where('cat_id',$id)->delete();
        Session::flash('success','Xóa thành công');
    }

    public function show($id)
    {
        $menus = DB::table('menus')
            ->where('menus.cat_id',$id)
            ->leftJoin('category','menus.cat_id','=','category.id')
            ->select('menus.*','category.name as name')
            ->orderBy('menus.sort')
            ->get();
        return response()->json(['menus' => $menus]);
    }
}
