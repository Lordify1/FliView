@php
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
if(Auth()->user())

$id = auth()->user()->id;

$cartitems = DB::select('select * from carts where user_id = ?', [$id]);

$ids = array_column($cartitems, "product_id");

// $colors = array_column($cartitems, "color");

$cart_products = Product::whereIn("id",$ids)->get();

$total = count($cartitems);

$ids_sum = array_count_values($ids);

$shipping_info = DB::select('select * from shopowner_shipping_info where user_id = ?', [auth()->id()]);

@endphp

@if(!empty($shipping_info))
@foreach($shipping_info as $s_info) @endforeach
@endif

@extends("layouts.user")

@section("title")
    Cart items
@endsection


@section("content")



    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Cart Items</h1>
        </div>
    </div>
    <!-- Page Header End -->

    @if($cart_items != null)

    <!-- Checkout Start -->
    @if (session('status') === 'order_sent')<div class="alert alert-success text-center">Order sent</div>@endif
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-12">
                @if(auth()->user()->user_type == "CUSTOMER")
                <span class="text-danger"> *Please make sure to update your Shipping Information from your dashboard</span>
                @endif
                <div class="card border-secondary mb-5 mt-2">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0"></h4>
                    </div>
                    <div class="card-body m-0 p-0">
                            <table class="table text-dark">
                                <thead>
                                    <th>Items</th>
                                    <th>Available Colors</th>
                                    <th>Available Sizes</th>
                                </thead>
                        @foreach($cart_products as $product)
                                <tbody>
                                    <tr class="items_rows">
                                        
                                        <td><a href="{{route('product.this',[$product->id])}}">{{$product->name}}</a></td> 
                                        <td>{{$product->color}}</td>
                                        <td>{{$product->sizes}}</td>                                          
                                    </tr>
                                </tbody>
                        @endforeach
                    </table>
                </div>

                <hr>
                <form action="{{route('order.store')}}" method="POST">
                    @csrf
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                    </div>
                    <div class="card-body m-0 p-0">
                            <table class="table text-dark">
                                <thead>
                                    <th>Items</th>
                                    <th>#</th>
                                    <th>Price Per 1</th>
                                    <th><i class="fa fa-edit"></i></th>
                                </thead>
                                <?php $cici = 1; $cibip = 1; $cibim = 1; ?>

                        @foreach($cart_products as $product)
                    <input type="hidden" name="the_products_id[]" value="{{$product->id}}">
                    <input type="hidden" name="the_products_count[]" 
                    value="
                                        @php 
                                        $id = $product->id;
                                            foreach ($ids_sum as $key => $value) {
                                                if($key == $product->id){
                                                    echo $value;
                                                }
                                            }
                                        @endphp
                    ">
                                <tbody>
                                    <tr class="items_rows" id="item_row{{$product->id}}">
                                        <td><button class="btn m-0 p-0 delete_this_item" value="{{$product->id}}"><i class="fa fa-trash"></i></button><b> | </b><a href="{{route('product.this',[$product->id])}}">{{$product->name}}</a>
                                            {{-- <div class="col-2">
                                                <?php $product_images = DB::select('select image_name from product_images where product_id = ? LIMIT 1', [$product->id]);?>
                                            @if(empty($product_images))
                                            <img class="img-" style="border: 2px solid black" src="/image/products/fliviewdefault.png" alt="">
                                            @endif
                                            @foreach($product_images as $image)
                                            <img class="img-fluid" style="border: 2px solid black" @if($image->image_name == null) @else src="/image/products/{{$image->image_name}}" @endif alt="">
                                            @endforeach
                                            </div> --}}
                                        </td>
                                        <td class="" value="{{$cici++}}" id="{{$product->id}}">                                            
                                        @php 
                                        $id = $product->id;
                                            foreach ($ids_sum as $key => $value) {
                                                if($key == $product->id){
                                                    echo $value;
                                                }
                                            }
                                        @endphp
                                        </td>
                                        
                                        <input value="@php
                                        foreach ($ids_sum as $key => $value) {
                                            if($key == $product->id){
                                                echo $product->price * $value;
                                            }
                                        }
                                        @endphp" type="hidden" class="sums" id="sums{{$product->id}}">
                                        <input type="hidden" name="naira" id="naira" value="&#8358;">
                                        <input type="hidden" id="cart_item_price{{$product->id}}" value="{{$product->price}}">
                                        <td class="cart_items_price">&#8358;{{number_format($product->price)}}</td>
                                        <input type="hidden" name="shop_id" id="cart_shop_id" value="{{$product->shop_id}}">
                                        <td><button class="fa fa-minus m-0 p-1 btn-sm minus_cart_item_quantity btn-danger" value="{{$product->id}}"></button><button class="fa fa-plus m-0 p-1 btn-sm btn-success all_products_cart_add" value="{{$product->id}}"></button></td>
                                    </tr>
                                </tbody>
                        @endforeach
                                <tbody class="border border-danger">
                                    <tr>
                                      <td>Total</td>
                                      <td id="items_totalled">{{count($ids)}}</td>
                                      <td id="price_total"></td>
                                      <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        <hr class="mt-0">

                        @if(auth()->user()->user_type == "SHOP OWNER")
                        <div class="col">
                            <div class="mb-4">
                                <h4 class="font-weight-semi-bold mb-4">Shipping Address</h4>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Name</label>
                                        <input class="form-control" type="text" required name="customer_name" placeholder="Doe" 
                                        @if(!empty($shipping_info))
                                        value="{{$s_info->name}}" @endif>
                                        
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>E-mail</label>
                                        <input class="form-control" type="text" required name="customer_email" placeholder="example@email.com"
                                        @if(!empty($shipping_info))
                                        value="{{$s_info->email}}" @endif>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Mobile No</label>
                                        <input class="form-control" type="text" required name="customer_phone" placeholder="+123 456 789"
                                        @if(!empty($shipping_info))
                                        value="{{$s_info->phone}}" @endif>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Address</label>
                                        <input class="form-control" type="text" required name="customer_address" placeholder="123 Street"
                                        @if(!empty($shipping_info))
                                        value="{{$s_info->address}}" @endif>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Country</label>
                                        <input class="form-control" type="text" required name="customer_country" placeholder="Nigeria"
                                        @if(!empty($shipping_info))
                                        value="{{$s_info->country}}" @endif>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>City</label>
                                        <input class="form-control" type="text" required name="customer_city" placeholder="New York"
                                        @if(!empty($shipping_info))
                                        value="{{$s_info->city}}" @endif>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>State</label>
                                        <input class="form-control" type="text" required name="customer_state" placeholder="New York"
                                        @if(!empty($shipping_info))
                                        value="{{$s_info->state}}" @endif>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>ZIP Code</label>
                                        <input class="form-control" type="text" required name="customer_zipcode" placeholder="123"
                                        @if(!empty($shipping_info))
                                        value="{{$s_info->zip_code}}" @endif>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="m-2">
                            <textarea name="customer_note" id="" cols="30" rows="10" class="form-control shadow-sm" placeholder="Enter a Detailed explanation of your order preference"></textarea>
                        </div>

                    <div class="card-footer border-secondary bg-transparent">
                        <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3 placeorder" id="place_my_order" type="submit" name="place_order">Place Order</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Checkout End -->

    @endif

    <script>
        var addtocartUrl = '{{route("cart.add")}}'
        var csrftoken = '{{csrf_token()}}'

        var removecartUrl = '{{route("cart.delete")}}'

        var deletecartUrl = '{{route("item.destroy")}}'

        var sendOrderUrl = '{{route("order.store")}}'
    </script>

@endsection