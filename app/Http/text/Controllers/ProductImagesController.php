<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductImagesController extends Controller
{
    public function delete_image(Request $request)
    {
        $request->validate([
            "image_id"=> "required|string",
        ]);

        $image_id = $request->input("image_id");

        $image_delete = DB::delete('delete from product_images where id = ?', [$image_id]);

        if($image_delete == true)
        {
        return response()->json(["success" => true]);
        }else
        {
        return response()->json(["success" => false]);
        }
    }
}
