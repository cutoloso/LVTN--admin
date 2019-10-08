<?php

namespace App\Http\Controllers;
use Image;
use Illuminate\Http\Request;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {

            $image = $request->file('upload');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $location = public_path('/uploads/'.$filename);
            Image::make($image)->save($location);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('uploads/'.$filename);
            $msg = 'Image successfully uploaded';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            // Render HTML output
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
    }
}
