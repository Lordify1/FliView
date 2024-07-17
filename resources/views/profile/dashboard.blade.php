

<?php 
use App\Models\Product_images;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;

?>


{{-- {{dd($shop)}} --}}

@extends("layouts.user")

@section("title")
    FliVIew - Your Dashboard
@endsection


@section("content")

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px; @if(isset($shop)) background:url('/image/shop_logo/{{$shop->shop_logo}}'); background-repeat:no-repeat; background-size:cover @endif">
            <h1 class="font-weight-semi-bold text-uppercase mb-3 bg-white p-2 border rounded">DASHBOARD</h1>
            @if(auth()->user()->user_type == "SHOP OWNER")
            @if (session('status') === 'have_a_shop')<div class="alert alert-danger">You can only create 1 shop</div>@endif
            <ul>
            <a href="{{route('profile.edit')}}" class="dashboard-links">Edit Profile /</a>
            @if(isset($shop))
            @if($shop != null)
            <a href="{{route("product.create")}}" class="text-center dashboard-links">Create a product /</a>
            <a href="{{route("shop.edit")}}" class="dashboard-links"> Edit Shop /</a>
            <a href="{{route('orders.view')}}" class="text-center dashboard-links">Orders /</a>
            @endif
            @endif
            <a href="{{route('logout')}}" class="dashboard-links">Logout </a>
            @elseif(auth()->user()->user_type == "CUSTOMER")
            <a href="{{route('profile.edit')}}" class="dashboard-links">Edit Profile /</a>
            <a href="{{route('shipping.edit')}}" class="dashboard-links">Edit Shipping Info /</a>
            <a href="{{route('logout')}}" class="dashboard-links">Logout </a>
            @elseif(auth()->user()->user_type == "ADMIN")
            <a href="{{route('logout')}}" class="dashboard-links">Logout </a>
            @endif
            </ul>
        </div>
    </div>

    <!-- Page Header End -->


    @if(session("status") == "create_a_shop_first")
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <button
            type="button"
            class="btn"
            data-bs-dismiss="alert"
            aria-label="Close"
        ><i class="fa fa-close"></i></button>
    
        <strong>Create a Shop First</strong>
    </div>
    @endif

    @if(session("status") == "account_created")
    @if(auth()->user()->user_type == "CUSTOMER")
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button
            type="button"
            class="btn"
            data-bs-dismiss="alert"
            aria-label="Close"
        ><i class="fa fa-close"></i></button>
    
        <p class="text-center">Account Created. Do well to fill in your shipping Information</p>
    </div>
    @elseif(auth()->user()->user_type == "SHOP OWNER")
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button
            type="button"
            class="btn"
            data-bs-dismiss="alert"
            aria-label="Close"
        ><i class="fa fa-close"></i></button>
    
        <p class="text-center">Account Created.</p>
    </div>
    @endif
    @endif
    

    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">@if(auth()->user()->user_type == "SHOP OWNER")<?php 
                if(isset($shop)){ echo $shop->shop_name . "'s Shop"; }else{  echo "<a href='/shop'>" . "Create a Shop" . "</a>"; }
                ?>@elseif(auth()->user()->user_type == "CUSTOMER"){{auth()->user()->username}} Orders @elseif(auth()->user()->user_type == "ADMIN") Authority @endif</span></h2>
            @if (session('status') === 'product_deleted')<div class="alert alert-success">Product Deleted</div>@endif
        </div>
        <div class="row" style="min-height: 100px">
        @if(auth()->user()->user_type == "SHOP OWNER")
        @if(isset($products))
        @foreach($products as $product)
        <div class="text-center col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4 shadow-lg" style="padding: 30px;">
                    <p class="text-right">{{$product->how_many}} Available</p>
                    <?php $product_images = DB::select('select image_name from product_images where product_id = ? LIMIT 1', [$product->id]);?>
                    <a href="" class="cat-img position-relative overflow-hidden mb-3">
                        @if(empty($product_images))
                        <img class="img-fluid" style="border: 2px solid black" src="/image/products/fliviewdefault.png" alt="">
                        @endif
                        @foreach($product_images as $image)
                        <img class="img-fluid" style="border: 2px solid black" @if($image->image_name == null) @else src="/image/products/{{$image->image_name}}" @endif alt="">
                        @endforeach
                    </a>
                    <h5 class="font-weight-semi-bold m-0">{{$product->name}}</h5>
                    <p>{{$product->description}}</p>
                    <ul class="text-start">
                      <a href="{{route('product.edit', ['id' => $product->id])}}" class="fa fa-edit btn btn-danger" title="edit product"></a>
                      <a href="{{route('product.this',[$product->id])}}" class="fa fa-eye btn btn-danger" title="view product"></a>
                      <a href="{{route('product.destroy',['id' => $product->id])}}" class="btn btn-danger" title="delete product"><i class="fa fa-trash"></i></a>
                    </ul>
                </div>
            </div>
            @endforeach
            @endif
            @elseif(auth()->user()->user_type == "CUSTOMER")
            <?php
            $user_orders = Order::all()->where("user_email","=",auth()->user()->email);
            ?>
            @if(!empty($user_orders))
            <div
                class="table-responsive m-2"
            >
                <table
                    class="table table-primary text-dark"
                >
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Shop</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    @foreach($user_orders as $my_orders)
                    <?php $product_info = Product::all()->where("id","=",$my_orders->product_id); $shop = Shop::all()->where("id","=",$my_orders->shop_id); ?>
                    <tbody class="@if($my_orders->status == 'pending') table-primary @elseif($my_orders->status == 'concluded') table-success @endif">
                        <tr class="">
                            @foreach($product_info as $b_pro)
                            <td scope="row"><a href="{{route('product.this',[$b_pro->id])}}">{{$b_pro->name}}</a></td>
                            <td scope="row">&#8358;{{number_format($b_pro->price * $my_orders->quantity)}}</td>
                            @endforeach
                            <td scope="row">{{$my_orders->quantity}}</td>
                            @foreach($shop as $shop_name)
                            <td scope="row">{{$shop_name->shop_name}}</td>
                            @endforeach
                            <td scope="row">{{strtoupper($my_orders->status)}}</td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
            @else
            <p class="text-center display-4">You haven't made any orders yet</p>
            @endif
            @elseif(auth()->user()->user_type == "ADMIN")

            <div class="nav-scroller p-2 border-bottom container position-sticky bg-dark border rounded text-center" style="top: 0.2rem; z-index: 300">
                <nav class="nav nav-underline justify-content-between">
                    <a href="#users_table">Users</a>
                    <a href="#shops_table">Shops</a>
                    <a href="#products_table">Products</a>
                    <a href="#orders_table">Orders</a>
                </nav>
            </div>

            {{-- users table --}}
            <div class="container-fluid border rounded border-success mt-5 pt-5">
            <div class="table-responsive">
            <h4 id="users_table">Users</h4>
                <table class="table table-success">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">UT</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td scope="row">{{$user->username}}</td>
                            <td scope="row">{{$user->email}}</td>
                            <td scope="row">{{$user->user_type}}</td>
                            <td scope="row">
                               <div class="input-group">
                                <button id="userblockbtn{{$user->id}}" @if($user->status == "blocked") hidden @endif class="btn text-danger block_user" name="block_user" value="{{$user->id}}"><i id="userblock{{$user->id}}" class="fa fa-stop"></i></button>
                                <button id="userunblockbtn{{$user->id}}" @if($user->status == "active") hidden @endif class="btn text-success unblock_user" name="unblock_user" value="{{$user->id}}"><i id="userunblock{{$user->id}}" class="fa fa-play"></i></button>
                               </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            </div>
            {{-- users table end --}}


            <hr class="text-danger">

            {{-- shops table --}}
            <div class="container-fluid border rounded border-success mt-5 pt-5">
                <div class="table-responsive">
                <h4 id="shops_table">Shops</h4>
                    <table class="table table-success ">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($shops as $shop)
                            <tr class="">
                                <td scope="row">{{$shop->shop_name}}</td>
                                <td scope="row">{{$shop->shop_email}}</td>
                                <td scope="row">
                                    <div class="input-group">
                                        @if($shop->status == "active")<button id="shopblockbtn{{$shop->id}}" class="btn text-danger block_shop"  value="{{$shop->id}}"><i id="shopblock{{$shop->id}}" class="fa fa-stop"></i></button>@endif
                                        @if($shop->status == "blocked")<button id="shopunblockbtn{{$shop->id}}" class="btn text-success unblock_shop" value="{{$shop->id}}"><i id="shopunblock{{$shop->id}}" class="fa fa-play"></i></button>@endif
                                       </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- shops table end --}}


                        {{-- products table --}}
                        <div class="container-fluid border rounded border-success mt-5 pt-5">
                            <div class="table-responsive">
                            <h4 id="products_table">Products</h4>
                                <table class="table table-success">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Shop</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)
                                        <?php $shop_name = Shop::find($product->shop_id,"shop_name"); ?>
                                        <tr class="">
                                            <td scope="row">{{$product->name}}</td>
                                            <td scope="row">{{$shop_name->shop_name}}</td>
                                            <td scope="row">
                                                <div class="btn-group">
                                                @if($product->status == "active")<button id="productblockbtn{{$product->id}}" class="btn text-danger block_product" value="{{$product->id}}"><i id="productblock{{$product->id}}" class="fa fa-stop"></i></button>@endif
                                                @if($product->status == "blocked")<button id="productunblockbtn{{$product->id}}" class="btn text-success unblock_product" value="{{$product->id}}"><i id="productunblock{{$product->id}}" class="fa fa-play"></i></button>@endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- products table end --}}

                        {{-- orders table --}}
                        <div class="container-fluid border rounded border-success mt-5 pt-5">
                            <div class="table-responsive">
                            <h4 id="orders_table">Orders</h4>
                                <table class="table table-success">
                                    <thead>
                                        <tr>
                                            <th scope="col">Customer email</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <?php $product_name = Product::find($order->product_id,"name"); ?>
                                        <tr class="">
                                            <td scope="row">{{$order->user_email}}</td>
                                            <td scope="row">{{$product_name->name}}</td>
                                            <td scope="row">{{$product->created_at}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- orders table end --}}

                        <script>
                            BlockUserUrl = "{{route('block_user')}}"
                            unBlockUserUrl = "{{route('unblock_user')}}"
                            BlockShopUrl = "{{route('block_shop')}}"
                            unBlockShopUrl = "{{route('unblock_shop')}}"
                            BlockProductUrl = "{{route('block_product')}}"
                            unBlockProductUrl = "{{route('unblock_product')}}"
                            csrftoken = '{{csrf_token()}}'
                        </script>

            @endif
        </div>
    </div>
    <!-- Contact End -->

@endsection
