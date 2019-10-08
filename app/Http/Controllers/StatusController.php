<?php

namespace App\Http\Controllers;

use Session;
use App\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = Status::orderBy('name')->paginate(10);
        return view('status.index', ['status' => $status]);
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
        $status = new Status();
        $status->name = $request->name;
        $status->description = $request->description;
        $status->color_code = $request->color_code;
        $status->bg_color_code = $request->bg_color_code;
        $status->save();
        Session::flash('success','Đã lưu thành công');
        return redirect()->route('status.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Show object
        $status = Status::find($id);
        return response()->json([
            'name' => $status->name,
            'description' => $status->description,
            'color_code' => $status->color_code,
            'bg_color_code' => $status->bg_color_code
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $status = Status::find($id);
        $status->name = $request->name;
        $status->description = $request->description;
        $status->color_code = $request->color_code;
        $status->bg_color_code = $request->bg_color_code;
        $status->save();

        Session::flash('success','Cập nhật thành công');
        return redirect()->route('status.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete object
        $status = Status::find($id);
        $status->delete();
        Session::flash('success','Xóa thành công');
    }

    public function getStatus(){
        $status = Status::orderBy('id')->get();
        return response()->json(['status' => $status]);
    }
}
