

{{-- @foreach($cartitem as $product => $quantity) 

{{$quantity}}

@endforeach --}}

@extends("layouts.user")

@section("title")
    All Products
@endsection


@section("content")
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">ALL PRODUCTS</h1>
            <form action="{{route('all_products.search')}}">
            <div class="input-group">
                <input type="text" name="search_products" placeholder="Search Products" class="form-control" id="search_all_products">
                <button class="btn bg-primary text-white" id="search_allProducts_button"><i class="fa fa-search"></i></button>
            </div>
            </form>
        </div>
    </div>
    <!-- Page Header End -->

    {{-- <div class="nav-scroller mb-3 border-bottom position-sticky bg-secondary" style="top: 0.2rem; z-index:500">
        <nav class="nav nav-underline justify-content-between mb-3">
        <h1 class="nav-item nav-link link-body-emphasis">Mine</h1>
        </nav>
    </div> --}}

@if(session("status") == "Done") Good @endif
        <!-- Contact Start -->
        <div class="container-fluid pt-5">
            <div class="row px-xl-5" id="all_products_box">
                @foreach($all_products as $product)
                <div class="col-lg-3 mb-5">
                    <div class="card product-item border border-secondary p-2 shadow-sm mb-4">
                        <?php $shop = DB::select('select shop_name from shops where id = ?', [$product->shop_id]); foreach($shop as $shoname) ?>
                        <?php $status = DB::select('select status_name from product_status where id = ?',[$product->product_status_id]); ?>
                        <span >@if(isset($ushop))@if($product->shop_id == $ushop->id) Your Shop @else {{$shoname->shop_name}} @endif @else {{$shoname->shop_name}} @endif | @foreach($status as $st) @endforeach{{$st->status_name}}</span>
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <?php $product_images = DB::select('select image_name from product_images where product_id = ? LIMIT 1', [$product->id]);?>
                            @if(empty($product_images))
                            <img class="img-fluid" style="border: 2px solid black" src="/image/products/fliviewdefault.png" alt="">
                            @endif
                            @foreach($product_images as $image)
                            <img class="img-fluid" style="border: 2px solid black" @if($image->image_name == null) @else src="/image/products/{{$image->image_name}}" @endif alt="">
                            @endforeach
                        </div>
                        <div class="col text-center">
                            <?php $category = DB::select('select cat_name from product_categories where id = ?', [$product->product_category_id]) ?>
                            @foreach($category as $cat)
                            <span>Category : {{$cat->cat_name}}</span><br>
                            @endforeach
                            <span>Sizes : {{$product->sizes}}</span><br>
                            <span>Colors : {{$product->color}}</span>
                        </div>  
                        <?php $colorid = 1; $colorlabel = 1; $colors = explode(",",$product->color); ?>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-2">
                            <input type="hidden" name="shop_id" id="cart_shop_id" value="{{$product->shop_id}}">
                           <h6 class="text-truncate mb-3">{{$product->name}} | 
                            @if(auth()->user()) 
                            <button  class="btn text-black all_products_cart_add" @if(!empty($user_shop)) @foreach($user_shop as $shop) @if($shop->id == $product->shop_id) disabled @endif @endforeach @endif value="{{$product->id}}"><i class="fa fa-shopping-cart text-danger" ></i></button> 
                            @else
                            <a href="{{route("login")}}"><i class="fa fa-shopping-cart" ></i></a> 
                            @endif 
                           </h6>
                            <div class="d-flex justify-content-center">
                                <h6><?php  echo "&#8358; " . number_format($product->price); ?></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="{{route('product.this',[$product->id])}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Product</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
    </div>
    <!-- Contact End -->


    <script>
        var addtocartUrl = '{{route("cart.add")}}'
        var csrftoken = '{{csrf_token()}}'
        
    </script>

@endsection