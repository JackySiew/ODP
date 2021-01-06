<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use App\User;
use App\Product;
use App\Notifications\Action;
class ReviewController extends Controller
{
    //users save rate & comment
    public function store(Request $request)
    {
        $product = Product::find($request->input('product_id'));
        $user = User::find($product->presentBy);
        auth()->user()->reviews()->create($request->all());
        $action = ["Action"=>"Someone just commented to your product"];
        $user->notify(new Action($action));
        return back()->with('status','Comment Posted!');
    }

    //users delete rate & comment
    public function delete($id)
    {
        $review = Review::find($id);
        $review->delete();
        return back()->with('status','Comment Deleted!'); 
    }

}
