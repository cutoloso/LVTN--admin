<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, App\Review, Session;
class ReviewController extends Controller
{
    public function index(Request $request)
    {
        if(!isset($request->product)) {
            $products = DB::table('products')
                ->select(DB::raw('count(reviews.id) as review_count, products.id, products.name'))
                ->leftJoin('reviews','reviews.pro_id', '=', 'products.id')
                ->groupBy('products.id', 'products.name');
            if (isset($request->sort) && isset($request->order)){
                $products->orderBy($request->sort, $request->order);
            }
            else{
                $products->orderBy('products.created_at','desc');
            }
            return view('review.index',['products'=>$products->paginate(20)]);
        }
        else {
            $pro_id = $request->product;
            $reviews = DB::table('reviews')
                ->select('reviews.*', 'users.name as usr_name')
                ->where('parent',0)
                ->where('pro_id', $pro_id)
                ->leftJoin('users','users.id','reviews.usr_id');
            if (isset($request->sort) && isset($request->order)){
                $reviews->orderBy($request->sort, $request->order);
            }
            else{
                $reviews->orderBy('reviews.created_at','desc');
            }
            return view('review.show', ['reviews' => $reviews->paginate(50), 'pro_id' => $pro_id]);
        }
    }

    public function show($id){
        $review = DB::table('reviews')
            ->select('reviews.*', 'users.name as usr_name')
            ->leftJoin('users','users.id','reviews.usr_id')
            ->where('reviews.id', $id)
            ->first();
        return response()->json(['review' => $review]);
    }

    public function update(Request $request, $id){
        $review = Review::find($id);
        if ($request->active)
            $review->active = 1;
        else
            $review->active = 0;
        $review->save();
        Session::flash('success','Cập nhật thành công');
//        return redirect('/reviews?product='.$request->pro_id);
        return redirect()->back();
    }
    public function getReviewStatics(Request $request){
        $sentiment = DB::table('reviews')
            ->select(DB::raw('count(reviews.id) as review_count, sentiment'))
            ->where('pro_id', $request->product)
            ->groupBy('sentiment')
            ->orderBy('sentiment')
            ->get();
        return response()->json(['data' => $sentiment]);
    }
}
