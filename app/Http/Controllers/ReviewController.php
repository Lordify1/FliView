<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Controllers\Product_images;
use App\Models\Shop;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Review;
use App\Http\Requests\ReviewEditRequest;


class ReviewController extends Controller
{
    public function store(ReviewEditRequest $request): RedirectResponse
    {
        // $request->validate([
        //     "rating" => "required | string",
        //     "review_message" => "required | string",
        //     "reviewer_name" => "required | string",
        //     "reviewer_email" => "required | string",
        // ]);

        $request->user()->fill($request->validated());

        $me = DB::insert('insert into reviews (product_id, name, email, rating, review) values (?,?,?,?,?)', [$request->product_id, $request->reviewer_name, $request->reviewer_email, $request->rating, $request->review_message]);

        

        return Redirect::route('product.this',[$request->product_id])->with('status', 'review-sent');
    }
}
