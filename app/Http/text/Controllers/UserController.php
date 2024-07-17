<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Order;
use App\Models\Product_images;

class UserController extends Controller
{
    
    public function index()
    {
        
        return view("index");
    }

    public function all_shops()
    {
        return view("all_shops");
    }

    public function contact_us()
    {
        return view("contact");
    }

    public function login()
    {
        return view("auth/login");
    }

    public function register()
    {
        return view("auth/register");
    }

    public function dashboard(Request $request)
    {
        if(auth()->user()->user_type != "ADMIN")
        {
        $user = Auth::user();
        $userid = $user->id;
        $shop = Shop::all()->where("user_id","=",$userid);
        foreach($shop as $shop){
        if(!empty($shop)) { $shop_id = $shop->id;
        $product = Product::all()->where("shop_id","=",$shop_id);
        return view("profile.dashboard")->with(["shop"=> $shop,"user"=> $user,"products" => $product]);
        }
        }

        return view("profile.dashboard")->with(["user"=>$user]);
        }elseif(auth()->user()->user_type == "ADMIN")
        {
            $users = DB::select('select * from users where user_type = "SHOP OWNER" OR user_type = "CUSTOMER"');
            $shops = Shop::all();
            $products = Product::all();
            $orders = Order::all();

            return view("profile.dashboard")->with(["users"=>$users, "products"=>$products, "shops"=>$shops, "orders"=>$orders]);
        };
    }


    
}
