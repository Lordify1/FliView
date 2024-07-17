<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;

class OrderController extends Controller
{
    public function view_my_orders(Request $request)
    {

        $user_id = DB::select('select * from shops where user_id = ?', [auth()->id()]);

        if($user_id == null)
        {
            return redirect()->route("dashboard")->with("status","create_a_shop_first");
        }


        $shop = Shop::all()->where("user_id","=",auth()->id());

        foreach($shop as $shop_id)

        $my_orders = Order::all()->where('shop_id',"=",$shop_id->id);

        $id = $shop_id->id;
        
        // dd($my_orders);


        return view("profile.orders")->with(["my_orders" => $my_orders, "id" => $id]);
    }

    public function store(Request $request)
    {

        $request->validate([
            "the_products_id"=>"required",
            "the_products_count"=>"required",
            "customer_note"=>"required",
        ]);

        if(auth()->user()->user_type == "SHOP OWNER"){
        $request->validate([
                "customer_name" => "required",
                "customer_email"=>"required",
                "customer_phone"=>"required",
                "customer_address"=>"required",
                "customer_country"=>"required",
                "customer_city"=>"required",
                "customer_state"=>"required",
                "customer_zipcode"=>"required",
        ]);
        }


        $id = $request->input("the_products_id");
        $count = $request->input("the_products_count");


        $order = [];

        foreach ($id as $key => $product_id) {
            $cou = $count[$key];
                $order[$product_id] = $cou;
            
        };

        // dd($order);

        foreach ($id as $sho) {
            $shopme = Product::all()->where("id","=",$sho);
        }

        // dd($shopme);
        foreach ($shopme as $shop_id)

        

        $note = $request->input("customer_note");

        if(auth()->user()->user_type == "SHOP OWNER"){
        $customer_name = $request->input("customer_name");
        $customer_email = $request->input("customer_email");
        $customer_phone = $request->input("customer_phone");
        $customer_address = $request->input("customer_address");
        $customer_country = $request->input("customer_country");
        $customer_city = $request->input("customer_city");
        $customer_state = $request->input("customer_state");
        $customer_zipcode = $request->input("customer_zipcode");
        }
        $order_token = rand();
        $user_id = auth()->id();
        $user_email = auth()->user()->email;

        foreach ($order as $product_id => $total) {
                $my_orders = DB::insert('insert into orders (user_email, product_id, quantity, note, order_token, shop_id, user_id) values (?,?,?,?,?,?,?)', [$user_email, $product_id, $total, $note, $order_token, $shop_id->shop_id,$user_id]);
        }

        

        if($order == true)
        {
        
            if(auth()->user()->user_type == "SHOP OWNER"){
            $check_info = DB::select('select * from shopowner_shipping_info where user_id = ?', [$user_id]);

            if(empty($check_info))
            {
                $shipping_info = DB::insert('insert into shopowner_shipping_info (user_id, name, email, address, country, city, state, phone, zip_code) values (?,?,?,?,?,?,?,?,?)', [$user_id, $customer_name, $customer_email, $customer_address, $customer_country, $customer_city, $customer_state, $customer_phone, $customer_zipcode]);

                if ($shipping_info == true) {
                    return redirect()->route("cart.view")->with("status","order_sent");
                }else {
                    echo "Bad";
                }
            }else{
                // updated_at = ?
                $shipping_info_update = DB::update('update shopowner_shipping_info set user_id = ?, name = ?, email = ?, address = ?, country = ?, city = ?, state = ?, phone = ?, zip_code = ? where user_id = ?', [$user_id, $customer_name, $customer_email, $customer_address, $customer_country, $customer_city, $customer_state, $customer_phone, $customer_zipcode, $user_id]);

                if ($shipping_info_update == true) {
                    return redirect()->route("cart.view")->with("status","order_sent");
                }else {
                    echo "Bad";
                }
            }
            }

            return redirect()->route("cart.view")->with("status","order_sent");
        }else{
            echo 'Bad';
        }

    }


    public function conclude(Request $request)
    {

        $order_id = $request->input("targetted_order");

        $conclude = DB::update('update orders set status = "concluded" where id = ?', [$order_id]);

        return response()->json(['success' => true]);
    }


    public function pend(Request $request)
    {
        
        $order_id = $request->input("targetted_order");

        $pend = DB::update('update orders set status = "pending" where id = ?', [$order_id]);

        return response()->json(['success' => true]);
    }
}
