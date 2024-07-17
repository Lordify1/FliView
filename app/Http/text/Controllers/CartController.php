<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Cart;

class CartController extends Controller
{

    public function cartItems(Request $request)
    {
        $user_id = Auth::user()->id;
        $cart_items = Cart::where("user_id",$user_id);
        
        


        // $products = DB::select('select * from products where id = ?', [$cart_items->product_id]);
        // dd($products);
        return view("cart")->with(["cart_items"=>$cart_items]);
    }

    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $shop_id = $request->input('shop_id');

        // Check if user is logged in
        // if (auth()->user()) {
            $user_id = auth()->id();
            // Handle logic for registered users (insert into DB)
            DB::insert('insert into carts (product_id, quantity, shop_id, user_id) values (?,?,?,?)', [$productId, $quantity, $shop_id, $user_id]);

            return response()->json(['success' => true]);
        // } else {
        //     // Handle logic for unregistered users (use cookies)
        //     $cart = json_decode($request->cookie('cart', []), true);

        //     // Add or update product in the cookie
        //     if(array_key_exists($productId, $cart))
        //     {
        //         $cart[$productId] += $quantity;
        //     }else{
        //         $cart[$productId] = $quantity;
        //     }

        //     return response()->json(['success' => true])->cookie('cart', json_encode($cart), 500);
        // }
           
             // Set a cookie for 60 minutes
    }

    public function removeFromCart(Request $request)
    {
        $delete_product_id = $request->input('delete_product_id');
        $user_id = auth()->id();

        $deletion = DB::delete('delete from carts where user_id = ? AND product_id = ? LIMIT 1', [$user_id, $delete_product_id]);

        return response()->json(['success' => true]);
    }


    public function destroyFromCart(Request $request)
    {
        $item_id = $request->input("item");
        $user_id = auth()->id();

        $delete_items = DB::delete('delete from carts where user_id = ? AND product_id = ?', [$user_id, $item_id]);

        return response()->json(['success' => true]);
    }
    }

