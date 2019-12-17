<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User, DB, Session;
class UserController extends Controller
{
    public function index(Request $request){
        $users = DB::table('users')
            ->leftJoin('groups','groups.gr_id','users.gr_id')
            ->select('users.*','groups.description');
        if (isset($request->sort) && isset($request->order)){
            $users->orderBy($request->sort, $request->order);
        }
        else{
            $users->orderBy('users.name','asc');
        }
        return view('user.index',['users' => $users->paginate(30)]);
    }

    public function show($id){
        $user = DB::table('users')
            ->where('users.id',$id)
            ->leftJoin('groups','groups.gr_id','users.gr_id')
            ->select('users.*','groups.description')->first();
        return response()->json(['user' => $user]);
    }
    public function update(Request $request, $id){
        $user = User::find($id);
        $user->gr_id = $request->gr_id;
        if(isset($request->active)){
            $user->active = 1;
        }
        else{
            $user->active = 0;
        }
        $user->save();
        Session::flash('success','Cập nhật thành công');
        return redirect()->route('user.index');
    }
}
