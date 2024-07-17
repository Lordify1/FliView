<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CustomerShippingInfoController extends Controller
{
    public function edit()
    {
        return view("profile.customer_shinfo");
    }

    public function store(Request $request)
    {

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

        $customer_name = $request->input("customer_name");
        $customer_email = $request->input("customer_email");
        $customer_phone = $request->input("customer_phone");
        $customer_address = $request->input("customer_address");
        $customer_country = $request->input("customer_country");
        $customer_city = $request->input("customer_city");
        $customer_state = $request->input("customer_state");
        $customer_zipcode = $request->input("customer_zipcode");
        $user_id = auth()->id();


        $check_info = DB::select('select * from customer_shipping_info where user_id = ?', [$user_id]);

            if(empty($check_info))
            {
                $shipping_info = DB::insert('insert into customer_shipping_info (user_id, name, customer_email, address, country, city, state, phone, zip_code) values (?,?,?,?,?,?,?,?,?)', [$user_id, $customer_name, $customer_email, $customer_address, $customer_country, $customer_city, $customer_state, $customer_phone, $customer_zipcode]);

                if ($shipping_info == true) {
                    return redirect()->route("shipping.edit")->with("status","Shipping Info Updated");
                }else {
                    return redirect()->route("shipping.edit")->with("status","Shipping Info Not Updated");
                }
            }else{
                // updated_at = ?
                $shipping_info_update = DB::update('update customer_shipping_info set user_id = ?, name = ?, customer_email = ?, address = ?, country = ?, city = ?, state = ?, phone = ?, zip_code = ? where user_id = ?', [$user_id, $customer_name, $customer_email, $customer_address, $customer_country, $customer_city, $customer_state, $customer_phone, $customer_zipcode, $user_id]);

                if ($shipping_info_update == true) {
                    return redirect()->route("shipping.edit")->with("status","Shipping Info Updated");
                }else {
                    return redirect()->route("shipping.edit")->with("status","No Change");
                }
            }

    }
}
