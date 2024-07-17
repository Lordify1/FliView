<?php  foreach($shop as $sho) ?>
<?php $product_total = count($all_products);  ?>

@extends("layouts.user")

@section("title")
    Shop View
@endsection


@section("content")

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5 border border-dark">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px; @if(isset($sho)) background:url('/image/shop_logo/{{$sho->shop_logo}}'); background-repeat:no-repeat; background-size:cover @endif">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">{{$sho->shop_name}} Shop</h1>
            {{-- @if(auth()->user())@if($sho->user_id != auth()->user()->id) @endif
            <a href="{{route("contact.view",[$sho->shop_name])}}" class="text-danger">Chat Shop</a> @endif --}}
        </div>
    </div>
    <!-- Page Header End -->

    {{-- shop info start --}}
    <div class="container text-center">
        <h1 class="display-4">Shop Info</h1>
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-lg-12 border border-secondary mt-2 pt-3 ">
                <i class="text-primary display-4"><i class="fa fa-pen"></i></i> <p>{{$sho->shop_description}}</p>
            </div>
            <div class="col-lg-6 border border-secondary mt-2 pt-3 ">
                <i class="display-4 text-primary"><i class="fa fa-location"></i></i><p> {{$sho->shop_address}}</p>
            </div>
            <div class="col-lg-6 border border-secondary mt-2 pt-3 ">
                <i class="display-4 text-primary"><i class="fa fa-phone"></i></i> <p> {{$sho->shop_phone}}</p>
            </div>
            <div class="col-lg-6 border border-secondary mt-2 pt-3 ">
                <i class="fa fa-clock display-4 text-primary"></i><p> {{$sho->opening_time}} to {{$sho->closing_time}}</p>
            </div>
            <div class="col-lg-6 border border-secondary mt-2 pt-3 ">
                <i class="fa fa-message display-4 text-primary"></i><p> {{$sho->shop_email}}</p>
            </div>
            <div class="col-lg-6 border border-secondary mt-2 pt-3 ">
                <i class="display-4 text-primary"><i class="fa fa-bank"></i></i> <p>{{$sho->payment_method}}</p>
            </div>
            {{-- <div class="col-lg-6 border border-secondary mt-2 pt-3 ">
                <i class="display-4 text-primary"><i class="fa fa-money-bill"></i></i> <p> {{$sho->payment_currency}}</p>
            </div>            --}}
        </div>
    </div>
    {{-- shop info end  --}}

    <div class="container">
        <hr>
    </div>

    <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            {{-- <div class="col-lg-2 col-md-12">
                <!-- Price Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Filter by price</h5>
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="price-all">
                            <label class="custom-control-label" for="price-all">All Price</label>
                            <span class="badge border font-weight-normal">1000</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-1">
                            <label class="custom-control-label" for="price-1">$0 - $100</label>
                            <span class="badge border font-weight-normal">150</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-2">
                            <label class="custom-control-label" for="price-2">$100 - $200</label>
                            <span class="badge border font-weight-normal">295</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-3">
                            <label class="custom-control-label" for="price-3">$200 - $300</label>
                            <span class="badge border font-weight-normal">246</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-4">
                            <label class="custom-control-label" for="price-4">$300 - $400</label>
                            <span class="badge border font-weight-normal">145</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" id="price-5">
                            <label class="custom-control-label" for="price-5">$400 - $500</label>
                            <span class="badge border font-weight-normal">168</span>
                        </div>
                    </form>
                </div>
                <!-- Price End -->
                
                <!-- Color Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Filter by color</h5>
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="color-all">
                            <label class="custom-control-label" for="price-all">All Color</label>
                            <span class="badge border font-weight-normal">1000</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="color-1">
                            <label class="custom-control-label" for="color-1">Black</label>
                            <span class="badge border font-weight-normal">150</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="color-2">
                            <label class="custom-control-label" for="color-2">White</label>
                            <span class="badge border font-weight-normal">295</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="color-3">
                            <label class="custom-control-label" for="color-3">Red</label>
                            <span class="badge border font-weight-normal">246</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="color-4">
                            <label class="custom-control-label" for="color-4">Blue</label>
                            <span class="badge border font-weight-normal">145</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" id="color-5">
                            <label class="custom-control-label" for="color-5">Green</label>
                            <span class="badge border font-weight-normal">168</span>
                        </div>
                    </form>
                </div>
                <!-- Color End -->

                <!-- Size Start -->
                <div class="mb-5">
                    <h5 class="font-weight-semi-bold mb-4">Filter by size</h5>
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="size-all">
                            <label class="custom-control-label" for="size-all">All Size</label>
                            <span class="badge border font-weight-normal">1000</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-1">
                            <label class="custom-control-label" for="size-1">XS</label>
                            <span class="badge border font-weight-normal">150</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-2">
                            <label class="custom-control-label" for="size-2">S</label>
                            <span class="badge border font-weight-normal">295</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-3">
                            <label class="custom-control-label" for="size-3">M</label>
                            <span class="badge border font-weight-normal">246</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-4">
                            <label class="custom-control-label" for="size-4">L</label>
                            <span class="badge border font-weight-normal">145</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" id="size-5">
                            <label class="custom-control-label" for="size-5">XL</label>
                            <span class="badge border font-weight-normal">168</span>
                        </div>
                    </form>
                </div>
                <!-- Size End -->
            </div> --}}
            <!-- Shop Sidebar End -->

            <!-- Shop Product Start -->
            @if($product_total > 0)
            <div class="col-lg-12 col-md-12">
                <h1 class="text-center">Products - {{$product_total}}</h1>
                <hr>
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <form action="{{route('shop.search_items')}}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search_shop_products" placeholder="Search by name">
                                    <input type="hidden" name="shop_id" value="{{$sho->id}}">
                                        <button class="btn btn-danger">
                                            <i class="fa fa-search"></i>
                                        </button>
                                </div>
                            </form>
                            <div class="dropdown ml-4">
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                    <a class="dropdown-item" href="#">Latest</a>
                                    <a class="dropdown-item" href="#">Popularity</a>
                                    <a class="dropdown-item" href="#">Best Rating</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach($all_products as $product)
                    <div class="text-center col-lg-4 col-md-6 pb-1" @if($product->how_many == 0) hidden @endif>
                            <div class="cat-item d-flex flex-column border mb-4 shadow-lg" style="padding: 30px;">
                                <p class="text-right">{{$product->how_many}} Available</p>
                                <?php $product_images = DB::select('select image_name from product_images where product_id = ? LIMIT 1', [$product->id]);?>
                                <a href="" class="cat-img position-relative overflow-hidden mb-3">
                                    @if(empty($product_images))
                                    <img class="img-fluid" src="/image/products/fliviewdefault.png" alt="">
                                    @endif
                                    @foreach($product_images as $image)
                                    <img class="img-fluid" @if($image->image_name == null) @else src="/image/products/{{$image->image_name}}" @endif alt="">
                                    @endforeach
                                </a>
                            <input type="hidden" name="shop_id" id="cart_shop_id" value="{{$product->shop_id}}">
                                <h5 class="font-weight-semi-bold m-0">{{$product->name}}</h5>
                                <span style="color: black" class="fw-bolder">&#8358;{{number_format($product->price)}}</span>
                                <p>{{$product->description}}</p>
                                <hr>
                                <h6 class="text-danger"><button class="btn text-danger all_products_cart_add p-0" value="{{$product->id}}"><i class="fas fa-shopping-cart"></i></button>&nbsp; |&nbsp;
                                    <a href="{{route('product.this',[$product->id])}}"  title="view product"><i class="fa fa-eye"></i></a></h6>
                            </div>
                        </div>
                        @endforeach
                       
                    {{-- <div class="col-12 pb-1">
                        <nav aria-label="Page navigation">
                          <ul class="pagination justify-content-center mb-3">
                            <li class="page-item disabled">
                              <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                              </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                              <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                              </a>
                            </li>
                          </ul>
                        </nav>
                    </div> --}}
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
        @else
        <div class="text-center display-4">
            <p>There are no products in this shop yet. Come back</p>
        </div>
        @endif
    </div>
  </div>
    <!-- Shop End -->

    <script>
        var addtocartUrl = '{{route("cart.add")}}'
        var csrftoken = '{{csrf_token()}}'
    </script>

@endsection