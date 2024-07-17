<?php

namespace App\Http\Controllers;

// use App\Http\Requests\ProfileUpdateRequest;
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
use App\Models\Review;
use Illuminate\Validation\Rule;
use App\Providers\RouteServiceProvider;

use App\Models\User;

class ProductController extends Controller
{
    public function edit(Request $request): View
    {
        $cat = DB::select("select * from product_categories");
        $status = DB::select("select * from product_status");
        return view("profile.create_product")->with([ "categories" => $cat, "statuses" => $status]);
    }


    public function store(Request $request)
    {

        $request->validate([
            "product_name"=>"required|string|min:5|max:100",
            "product_description"=>"required|string|min:10",
            "product_category"=>"required",
            "product_sizes"=>"required|string",
            "product_price" => "required",
            "product_colors"=>"required",
            "product_count"=>"required",
            "product_status"=>"required",
            "product_images"=>"required",
        ]);

        $user = Auth::user();
        $shop = DB::select('select id from shops where user_id = ?', [auth()->id()]);
        foreach($shop as $shop_id)
        $shop_id = $shop_id->id;

        $product = new Product;
        $product->name = $request->product_name;
        $product->description = $request->product_description;
        $product->product_category_id = $request->product_category;
        $product->price = $request->product_price;
        $product->how_many = $request->product_count;
        $product->product_status_id = $request->product_status;
        $product->sizes = $request->product_sizes;
        $product->color = $request->product_colors;
        $product->shop_id = $shop_id;

        $product->save();

        $product_id = $product->id;

        if($request->hasFile("product_images"))
        {

        $images = $request->file("product_images");

        foreach($images as $key => $file)
        {
        $filename = "fliview_product" . time() . $shop_id . "." . $file->getClientOriginalExtension();
        //2. move the image
        $file->move(public_path("image/products"), $filename);

        // $croppedimg = Image::make("image/products" . $filename)->crop()

        $product_image = DB::insert("insert into product_images (image_name,product_id) values (?,?)",[$filename, $product_id]);


        }

        return redirect()->route("product.create")->with("status","product_created", ["id" => $product_id]);
        };
        
        return redirect()->route("product.create")->with("status","product_created", ["id" => $product_id]);
       
    }

    public function redo($id): View
    {
        $product = Product::find($id);
        $cat = DB::select("select * from product_categories");
        $status = DB::select("select * from product_status");
        return view("profile.edit_product",["product" => $product, "categories" => $cat, "statuses" => $status]);
    }


    public function update(Request $request)
    {

        $request->validate([
            "product_name"=>"required|string|min:5|max:100",
            "product_description"=>"required|string|min:10",
            "product_category"=>"required",
            "product_sizes"=>"required|string",
            "product_price" => "required",
            "product_colors"=>"required",
            "product_count"=>"required",
            "product_status"=>"required",
        ]);

        $user = Auth::user();
        $shop = DB::select('select id from shops where user_id = ?', [auth()->id()]);
        foreach($shop as $shop_id)
        $shop_id = $shop_id->id;
        $id = $request->id;


        $update_product = DB::update(
            "update products set
            name = ?,
            description = ?,
            product_category_id = ?,
            price = ?,
            how_many = ?,
            product_status_id = ?,
            sizes = ?,
            color = ?
            where id = ?",[
                $request->product_name,
                $request->product_description,
                $request->product_category,
                $request->product_price,
                $request->product_count,
                $request->product_status,
                $request->product_sizes,
                $request->product_colors,
                $id
            ]);

        $product_id = $id;

        if($request->hasFile("product_images"))
        {

        $images = $request->file("product_images");

        foreach($images as $key => $file)
        {
        $filename = "fliview_product" . time() . $shop_id . "." . $file->getClientOriginalExtension();
        //2. move the image
        $file->move(public_path("image/products"), $filename);

        $product_image = DB::insert("insert into product_images (image_name,product_id) values (?,?)",[$filename, $id]);
        };

        return redirect()->route("product.edit",["id" => $id])->with("status","product_updated", ["id" => $product_id]);
        };

        return redirect()->route("product.edit",["id" => $id])->with("status","product_updated", ["id" => $product_id]);
    }

    public function destroy(Request $request)
    {

        $product = Product::find($request->id);
        $product->delete();

        return redirect()->route("dashboard")->with("status","product_deleted");

    }

    public function all_products()
    {

        $all_products = Product::all()->where("status","=","active");

        $user_shop = DB::select('select * from shops where user_id = ?', [auth()->id()]);
        
        return view("all_products",["all_products" => $all_products, "user_shop" => $user_shop]);

    }

    public function this_product($id)
    {
        $product = Product::find($id);
        $shop_id = Shop::find($product->shop_id);
        $reviews = DB::select('select * from reviews where product_id = ?', [$id]);
        $rating_total = DB::select('select sum(rating) as rates from reviews');
        $some_products = DB::select("select * from products where shop_id = ? and product_category_id = ? LIMIT 4",[$shop_id->id, $product->product_category_id]);
        $sizes = DB::select('select * from product_sizes');
        
        return view("product_detail",["product" => $product,"sizes"=> $sizes, "some_products" => $some_products, "reviews"=>$reviews, "rating_total"=> $rating_total]);
    }


    public function search_all_products(Request $request)
    {
        $request->validate([
            "search_products" => "required|string",
        ]);

        $input = $request->input("search_products");

        $all_products = Product::all();

        $search_result = DB::select('select * from products where name LIKE ? AND status = "active"',['%' . $input . '%']);

        return view("all_products_search")->with(["search_result"=>$search_result,"status","search_result_available"]);
    }

    public function search_shop_products(Request $request)
    {

        $request->validate([
            "search_shop_products"=> "required|string",
            "shop_id"=> "required|string"
        ]);

        $input = $request->input("search_shop_products");
        $shop_id = $request->input("shop_id");

        $search_result = DB::select('select * from products where name LIKE ? AND shop_id = ? AND status = "active"',['%' . $input . '%', $shop_id]);

        return view("shop_products_search")->with(["search_result"=>$search_result, "shop_id"=>$shop_id]);
    }

    public function product_category_show($name)
    {

        // dd($name);

        $cat = DB::select('select * from product_categories where cat_name = ?', [$name]);

        if(!empty($cat))
        {
        foreach($cat as $c)
        $products = DB::select('select * from products where product_category_id = ? AND status = "active"', [$c->id]);
    
        return view("products_by_category")->with([
            "products"=>$products
        ]); 
        }else
        {
            return redirect("/")->with("status","error_category");
        };

    }

    
}
