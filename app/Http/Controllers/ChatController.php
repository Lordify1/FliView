<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ChatController extends Controller
{
    public function contact_shop($name)
    {

        $contact = Shop::all()->where("shop_name","=",$name);
        foreach($contact as $shop_contact)
        return view("contact_shop")->with(["shop_contact"=>$shop_contact]);
    }
}
