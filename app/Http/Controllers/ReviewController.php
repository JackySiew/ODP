<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        auth()->user()->reviews()->create($request->all());
        return back()->with('status','Comment Posted!');
    }
    public function delete($id)
    {
        $review = Review::find($id);
        $review->delete();
        return back()->with('status','Comment Deleted!'); 
    }

}
