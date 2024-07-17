<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Shop;
use App\Models\Product;
use Illuminate\Validation\Rule;
use App\Providers\RouteServiceProvider;
use App\Models\User;


class ShopController extends Controller
{
    public function edit(Request $request)
    {
        $shop = Shop::find(auth()->user()->id,"user_id");
        if(!empty($shop)){
            return redirect()->intended(RouteServiceProvider::HOME)->with("status","have_a_shop");
        };
        return view("profile.create_shop");
    }

    public function my_shop(Request $request): View
    {
        $user = Auth::user();
        $user_id = $request->user()->id;
        $shop = DB::select("select * from shops where user_id = $user_id");
        
        return view("profile.edit_shop",[
            "user"=> $request->user(),
            "shop" => $shop,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            "shop_name" => "string|required","unique:".Shop::class,
            "shop_description" => "string|required",
            "shop_address" => "string|required",
            "shop_phone" => "string|required",
            "opening_time" => "string|required",
            "closing_time" => "string|required",
            "shop_email" => "string|required",
            "payment_method" => "string|required",
            // "payment_currency" => "string|required",
        ]);

        $shop_name = Shop::find($request->shop_name,"shop_name");
        $shop_email = Shop::find($request->shop_email,"shop_email");


        if(!empty($shop_name))
        {
        return redirect()->route("shop.create")->with("status", "shop_name_error");
        }

        if(!empty($shop_email))
        {
        return redirect()->route("shop.create")->with("status", "shop_email_erorr");
        }
        
        $user_id = auth()->id();

        $shop = new Shop();
        $shop->shop_name = $request->shop_name;
        $shop->shop_description = $request->shop_description;
        $shop->shop_address = $request->shop_address;
        $shop->shop_phone = $request->shop_phone;
        $shop->opening_time = $request->opening_time;
        $shop->closing_time = $request->closing_time;
        $shop->shop_email = $request->shop_email;
        $shop->payment_method = $request->payment_method;
        // $shop->payment_currency = $request->payment_currency;
        $shop->user_id = $user_id;

        $shop->save();

        $shop_id = $shop->id;

        // dd($shop_id);


        if($request->hasFile("shop_logo"))
        {
        
        $logo = $request->file("shop_logo");

        $filename = "fliview_" . time() . $user_id . "." . $logo->getClientOriginalExtension();
        //2. move the image
        $logo->move(public_path("image/shop_logo"), $filename);

        $addlogo = DB::update('update shops set shop_logo = ? where id = ?', [$filename, $shop_id]);

        return redirect()->route("dashboard")->with("status", "shop_created",["shop" => $shop]);
        }

        $shop = Shop::find($shop_id);
        
        return redirect()->route("dashboard")->with("status", "shop_created",["shop" => $shop]);
    }

    public function update(Request $request)
    {

        $request->validate([
            "shop_name" => "string|required","",
            "shop_description" => "string|required",
            "shop_address" => "string|required",
            "shop_phone" => "string|required",
            "opening_time" => "string|required",
            "closing_time" => "string|required",
            "shop_email" => "string|required",
            "payment_method" => "string|required",
            // "payment_currency" => "string|required",
        ]);
        
        $user_id = auth()->id();
        
        if($request->hasFile("shop_logo"))
        {

        $logo = $request->file("shop_logo");

        $filename = "fliview_" . time() . $user_id . "." . $logo->getClientOriginalExtension();
        //2. move the image
        $logo->move(public_path("image/shop_logo"), $filename);

        $update = DB::update('update shops set shop_logo = ? where user_id = ?', [$filename, $user_id]);
        
        }

        

        $update_shop = DB::update(
            "update shops set 
            shop_name = ?,
            shop_description = ?,
            shop_address = ?,
            shop_phone = ?,
            opening_time = ?,
            closing_time = ?,
            shop_email = ?,
            payment_method = ?
            where user_id = ?",[
                $request->shop_name,
                $request->shop_description,
                $request->shop_address,
                $request->shop_phone,
                $request->opening_time,
                $request->closing_time,
                $request->shop_email,
                $request->payment_method,
                // $request->payment_currency,
                $user_id]);
        
        return redirect()->route("shop.edit")->with("status", "shop_updated");
    }

    public function all_shops()
    {
        $shops = Shop::all()->where("status","=","active");

        return view("all_shops")->with(["shops" => $shops]);
    }


    public function this_shop($fdl)
    {

        $shop = Shop::all()->where("shop_name","=","$fdl");
        foreach($shop as $sho){
            $shop_id = $sho->id;
        }
        
        $all_products = Product::all()->where("shop_id","=",$shop_id);

        return view("this_shop",["shop"=> $shop, "all_products" => $all_products]);
    }



    public function search_shops(Request $request)
    {

        $request->validate([
            "search_shops"=> "required|string",
        ]);

        $input = $request->input("search_shops");

        $search_result = DB::select('select * from shops where shop_name LIKE ? AND status = "active"',['%' . $input . '%']);

        return view("shop_search")->with(["search_result"=>$search_result]);
    }


    
}
