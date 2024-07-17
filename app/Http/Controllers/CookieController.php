<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Models\Product;

class CookieController extends Controller
{
    
    public function index(Request $request)
{
    
    $prod_id = $request->input('product_id');
    $quantity = $request->input('quantity');

    
    $cart_data = json_decode(Cookie::get('usercookie', '[]'), true);

    $existing_item_key = array_search($prod_id, array_column($cart_data, 'item_id'));

    if ($existing_item_key !== false) {
        
        $cart_data[$existing_item_key]['item_quantity'] += $quantity;
    } else {
        
        $product = Product::find($prod_id);

        if ($product) {
            
            $item_array = [
                'item_id' => $prod_id,
                'item_name' => $product->name,
                'item_quantity' => $quantity,
                'item_price' => $product->price,
            ];
            $cart_data[] = $item_array;
        } else {
            
            return response()->json(['error' => 'Product not found']);
        }
    }

    Cookie::queue('usercookie', json_encode($cart_data), 60);

    
    if ($existing_item_key !== false) {
        return response()->json(['status' => 'Quantity of "' . $cart_data[$existing_item_key]['item_name'] . '" updated in Cart']);
    } else {
        return response()->json(['status' => '"' . $product->product_name . '" Added to Cart']);
    }
}


    public function get()
    {
        return request()->cookie('usercookie');
    }

    public function destroy()
    {
        return response('deleted')->cookie('usercookie', null, -1);
    }

    public function test()
    {
        return view('test_cookie');
    }

}
