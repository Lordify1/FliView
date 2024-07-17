@php
    use \Illuminate\Support\Facades\Cookie;
    use Illuminate\Support\Facades\DB;
    use App\Models\Cart;
    use App\Models\Product;
    $cartcookie = \Illuminate\Support\Facades\Cookie::get('cart');
    $cartitem = json_decode($cartcookie, true);

        $new_arrivals = DB::select('select * from products where product_status_id = ?', [7]);
        $instock = DB::select('select * from products where product_status_id = ?', [1]);
        $preorder = DB::select('select * from products where product_status_id = ?', [3]);
        $onsale = DB::select('select * from products where product_status_id = ?', [6]);
        $comingsoon = DB::select('select * from products where product_status_id = ?', [8]);


    if(Auth()->user()){

    $id = auth()->user()->id;

    $cartitems = DB::select('select * from carts where user_id = ?', [$id]);

    $ids = array_column($cartitems, "product_id");

    $cart_products = Product::whereIn("id",$ids)->get();

    $total = count($cartitems);
    }

@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FliView</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link rel="stylesheet" href="fa/css/all.css">
    <link rel="stylesheet" href="/css/animate.css">

    <!-- Libraries Stylesheet -->
    <link href="/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/css/style.css" rel="stylesheet">
</head>

<body>

    @if(session("status") == "error_category") <div class="alert alert-danger text-center">Category doesn't exist</div> @endif
    
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-danger font-weight-bold border px-3 mr-1">Fli</span>View</h1>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="{{route('all_products.search')}}" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search_products" placeholder="Search for products">
                        <div class="input-group-append">
                            <button class="btn btn-transparent border border-secondary"><i class="fa fa-search text-primary"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">
                <a href="" class="btn border">
                    <i class="fas fa-shopping-cart text-danger"></i>
                    <span class="badge" class="cart_counter">@if(auth()->user()) {{$total}} @else 0 @endif</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-danger font-weight-bold border px-3 mr-1">Fli</span>View</h1>
                    </a>
                    <button type="button" class="navbar-toggler" id="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="{{route("index")}}" class="nav-item nav-link">Home</a>
                            <a href="{{route("all_shops")}}" class="nav-item nav-link">Shops</a>
                            <a href="{{route("all_products")}}" class="nav-item nav-link">Products</a>
                            <a href="{{route("contact")}}" class="nav-item nav-link">Contact</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            @if(Auth::user())
                            <a href="{{route("dashboard")}}" class="nav-item nav-link">Dashboard</a>
                            @elseif(!Auth::user())
                            <a href="{{route("login")}}" class="nav-item nav-link">Login</a>
                            <a href="{{route("register")}}" class="nav-item nav-link">Register</a>
                            @endif
                        </div>
                    </div>
                </nav>
                <div id="header-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active " style="height: 520px;">
                            <img class="img-fluid" src="img/carousel-1.jpg" alt="Image">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">Tons of Products at Your Disposal</h3>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="carousel-item" style="height: 410px;">
                            <img class="img-fluid" src="img/carousel-2.jpg" alt="Image">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">What have you been looking for?</h3>
                                    <a href="" class="btn btn-light py-2 px-3">Shop Now</a>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    {{-- <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-prev-icon mb-n2"></span>
                        </div>
                    </a>
                    <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-next-icon mb-n2"></span>
                        </div>
                    </a> --}}
                </div>
            </div>
            <hr class="col-sm-12 d-sm-block d-lg-none">
            <div class="col-lg-3 col-sm-12 d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-danger text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0 text-white">Categories</h6>
                </a>
                <nav class="collapse show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0" id="navbar-vertical">
                    <div id="showing_cats" class="navbar-nav w-100 overflow-hidden">
                       <a href="{{route('products.category',['Shirts'])}}"><span class="nav-item nav-link">Shirts</span></a>
                       <a href="{{route('products.category',["Mens Dresses"])}}"><span class="nav-item nav-link">Men's Dresses</span></a>
                       <a href="{{route('products.category',["Womens Dresses"])}}"><span class="nav-item nav-link">Women's Dresses</span></a>
                       <a href="{{route('products.category',["Baby Dresses"])}}"><span class="nav-item nav-link">Baby Dresses</span></a>
                       <a href="{{route('products.category',["Childrens Dresses"])}}"><span class="nav-item nav-link">Childrens Dresses</span></a>
                       <a href="{{route('products.category',['Jeans'])}}"><span class="nav-item nav-link">Jeans</span></a>
                       <a href="{{route('products.category',['Swimwears'])}}"><span class="nav-item nav-link">Swimwears</span></a>
                       <a href="{{route('products.category',['Sleepwears'])}}"><span class="nav-item nav-link">Sleepwears</span></a>
                       <a href="{{route('products.category',['Sportwears'])}}"><span class="nav-item nav-link">Sportwears</span></a>
                       <a href="{{route('products.category',['Jumpsuits'])}}"><span class="nav-item nav-link">Jumpsuits</span></a>
                       <a href="{{route('products.category',['Blazers'])}}"><span class="nav-item nav-link">Blazers</span></a>
                       <a href="{{route('products.category',['Jackets'])}}"><span class="nav-item nav-link">Jackets</span></a>
                       <a href="{{route('products.category',['Shoes'])}}"><span class="nav-item nav-link">Shoes</span></a>
                       <a href="{{route('products.category',['Accessories'])}}"><span class="nav-item nav-link">Accessories</span></a>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->





        <div class="control-group mb-3">
            <h1 class="text-danger display-5 text-center">New Arrivals</h1>
        </div>

        <div class="row px-xl-5">
            @if(!empty($new_arrivals))
            @foreach($new_arrivals as $new)
            <div class="col-lg-3 mb-5">
                <div class="card product-item shadow-sm border-0 mb-4">
                <?php $product_images = DB::select('select image_name from product_images where product_id = ? LIMIT 1', [$new->id]);?>
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    @if(empty($product_images))
                    <img class="img-fluid w-100" src="/img/product-1.jpg" alt="">
                    @endif
                    @foreach($product_images as $image)
                    <img class="img-fluid w-100" @if($image->image_name == null) @else src="/image/products/{{$image->image_name}}" @endif alt="">
                    @endforeach
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">{{$new->name}} | <i class="fa fa-shopping-cart"></i></h6>
                        <div class="d-flex justify-content-center">
                            <h6><?php  echo "&#8358; " . number_format($new->price); ?></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="{{route('product.this',[$new->id])}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Product</a>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <hr>
            <div class="text-center col mt-2 mb-2">
            <p class="text-center">There are no products in this section yet</p>
            </div>
            @endif
        </div>

        

        <div class="control-group mb-3">
            <hr>
            <h1 class="text-danger display-5 text-center">In Stock</h1>
        </div>

        <div class="row px-xl-5">
            @if(!empty($instock))
            @foreach($instock as $inst)
            <div class="col-lg-3 mb-5">
                <div class="card product-item shadow-sm border-0 mb-4">
                <?php $product_images = DB::select('select image_name from product_images where product_id = ? LIMIT 1', [$inst->id]);?>
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    @if(empty($product_images))
                    <img class="img-fluid w-100" src="/img/product-1.jpg" alt="">
                    @endif
                    @foreach($product_images as $image)
                    <img class="img-fluid w-100" @if($image->image_name == null) @else src="/image/products/{{$image->image_name}}" @endif alt="">
                    @endforeach
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">{{$inst->name}} | <i class="fa fa-shopping-cart"></i></h6>
                        <div class="d-flex justify-content-center">
                            <h6><?php  echo "&#8358; " . number_format($inst->price); ?></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="{{route('product.this',[$inst->id])}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Product</a>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <hr>
            <div class="text-center col mt-2 mb-2">
            <p class="text-center">There are no products in this section yet</p>
            </div>
            @endif
        </div>




        <div class="control-group mb-3">
            <hr>
            <h1 class="text-danger display-5 text-center">Pre Order</h1>
        </div>

        <div class="row px-xl-5">
            @if(!empty($preorder))
            @foreach($preorder as $preo)
            <div class="col-lg-3 mb-5">
                <div class="card product-item shadow-sm border-0 mb-4">
                <?php $product_images = DB::select('select image_name from product_images where product_id = ? LIMIT 1', [$preo->id]);?>
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    @if(empty($product_images))
                    <img class="img-fluid w-100" src="/img/product-1.jpg" alt="">
                    @endif
                    @foreach($product_images as $image)
                    <img class="img-fluid w-100" @if($image->image_name == null) @else src="/image/products/{{$image->image_name}}" @endif alt="">
                    @endforeach
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">{{$preo->name}} | <i class="fa fa-shopping-cart"></i></h6>
                        <div class="d-flex justify-content-center">
                            <h6><?php  echo "&#8358; " . number_format($preo->price); ?></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="{{route('product.this',[$preo->id])}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Product</a>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <hr>
            <div class="text-center col mt-2 mb-2">
            <p class="text-center">There are no products in this section yet</p>
            </div>
            @endif
        </div>




        <div class="control-group mb-3">
            <hr>
            <h1 class="text-danger display-5 text-center">On Sale</h1>
        </div>

        <div class="row px-xl-5">
            @if(!empty($onsale))
            @foreach($onsale as $onsal)
            <div class="col-lg-3 mb-5">
                <div class="card product-item shadow-sm border-0 mb-4">
                <?php $product_images = DB::select('select image_name from product_images where product_id = ? LIMIT 1', [$onsal->id]);?>
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    @if(empty($product_images))
                    <img class="img-fluid w-100" src="/img/product-1.jpg" alt="">
                    @endif
                    @foreach($product_images as $image)
                    <img class="img-fluid w-100" @if($image->image_name == null) @else src="/image/products/{{$image->image_name}}" @endif alt="">
                    @endforeach
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">{{$onsal->name}} | <i class="fa fa-shopping-cart"></i></h6>
                        <div class="d-flex justify-content-center">
                            <h6><?php  echo "&#8358; " . number_format($onsal->price); ?></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="{{route('product.this',[$onsal->id])}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Product</a>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <hr>
            <div class="text-center col mt-2 mb-2">
            <p class="text-center">There are no products in this section yet</p>
            </div>
            @endif
        </div>


        <div class="control-group mb-3">
            <hr>
            <h1 class="text-danger display-5 text-center">Coming Soon</h1>
        </div>

        <div class="row px-xl-5">
            @if(!empty($comingsoon))
            @foreach($comingsoon as $soon)
            <div class="col-lg-3 mb-5">
                <div class="card product-item shadow-sm border-0 mb-4">
                <?php $product_images = DB::select('select image_name from product_images where product_id = ? LIMIT 1', [$soon->id]);?>
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    @if(empty($product_images))
                    <img class="img-fluid w-100" src="/img/product-1.jpg" alt="">
                    @endif
                    @foreach($product_images as $image)
                    <img class="img-fluid w-100" @if($image->image_name == null) @else src="/image/products/{{$image->image_name}}" @endif alt="">
                    @endforeach
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">{{$soon->name}} | <i class="fa fa-shopping-cart"></i></h6>
                        <div class="d-flex justify-content-center">
                            <h6><?php  echo "&#8358; " . number_format($soon->price); ?></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="{{route('product.this',[$soon->id])}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Product</a>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <hr>
            <div class="text-center col mt-2 mb-2">
            <p>There are no products in this section yet</p>
            </div>
            @endif
        </div>



    <!-- Subscribe Start -->
    {{-- <div class="container-fluid bg-danger my-3">
            <div class="row justify-content-md-center py-5 px-xl-5">
                <div class="col-md-6 col-12 py-5">
                    <div class="text-center mb-2 pb-2">
                        <h2 class=" text-white section-title px-5 mb-3"><span class="bg-danger px-2">Stay Strapped In</span></h2>
                        <p class="text-white">Sign Up to Fli's Newsletter</p>
                    </div>
                    <form action="">
                        <div class="input-group">
                            <input type="text" class="form-control border-white p-4" placeholder="Email Goes Here">
                            <div class="input-group-append">
                                <button class="btn btn-danger px-4">Subscribe</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </div> --}}
    <!-- Subscribe End -->



    <!-- Footer Start -->
    <div class="container-fluid bg-danger text-dark pt-1">
        <div class="row px-xl-5 pt-4">
            <div class="col-lg-6 col-md-12 mb-2 pr-3 pr-xl-5">
                <a href="" class="text-decoration-none">
                    <h1 class="mb-4 display-5 font-weight-semi-bold"><span class="text-white font-weight-bold border border-white px-3 mr-1">Fli</span>View</h1>
                </a>
    
        </div>
        <div class="row border-top border-light  py-2">
            <div class="col-md-6 px-xl-0 text-md-end">
                <p class="mb-md-0 text-center text-md-left text-dark">
                    &copy; <a class="text-dark font-weight-semi-bold" href="#">Copyright FliView</a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <p class="">Made with Lordacity By <b>LORDIFY</b></p>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-danger back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="/script/jqueryfile.js"></script>
    <script src="/js/bootstrap.bundle.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/lib/easing/easing.min.js"></script>
    <script src="/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="/mail/jqBootstrapValidation.min.js"></script>
    <script src="/mail/contact.js"></script>
    <script src="/js/fliview.js"></script>

    <!-- Template Javascript -->
    <script src="/js/main.js"></script>
    <script src="/script/fliview.js"></script>
</body>

</html>