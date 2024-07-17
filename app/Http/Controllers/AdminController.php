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

class AdminController extends Controller
{
    public function admin_login()
    {
        return view("admin.admin_login");
    }

    
    public function block_user(Request $request)
    {
        $user = $request->input("id");
        
        $blockuser = DB::update('update users set status = "blocked" where id = ?', [$user]);

        if($blockuser == true)
        {
            return response()->json(['success' => true]);
        }else
        {
            return response()->json(['success' => false]);
        };
    }

    public function unblock_user(Request $request)
    {
        $user = $request->input("id");
        
        $unblockuser = DB::update('update users set status = "active" where id = ?', [$user]);

        if($unblockuser == true)
        {
            return response()->json(['success' => true]);
        }else
        {
            return response()->json(['success' => false]);
        };
    }

    public function block_shop(Request $request)
    {
        $shop = $request->input("id");
        
        $blockshop = DB::update('update shops set status = "blocked" where id = ?', [$shop]);

        if($blockshop == true)
        {
            return response()->json(['success' => true]);
        }else
        {
            return response()->json(['success' => false]);
        };
    }

    public function unblock_shop(Request $request)
    {
        $shop = $request->input("id");
        
        $unblockshop = DB::update('update shops set status = "active" where id = ?', [$shop]);

        if($unblockshop == true)
        {
            return response()->json(['success' => true]);
        }else
        {
            return response()->json(['success' => false]);
        };
    }

    public function block_product(Request $request)
    {
        $product = $request->input("id");
        
        $blockproduct = DB::update('update products set status = "blocked" where id = ?', [$product]);

        if($blockproduct == true)
        {
            return response()->json(['success' => true]);
        }else
        {
            return response()->json(['success' => false]);
        };
    }

    public function unblock_product(Request $request)
    {
        $product = $request->input("id");
        
        $unblockproduct = DB::update('update products set status = "active" where id = ?', [$product]);

        if($unblockproduct == true)
        {
            return response()->json(['success' => true]);
        }else
        {
            return response()->json(['success' => false]);
        };
    }
}
