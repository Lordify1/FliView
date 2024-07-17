@php
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
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
    <title>@yield("title")</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="/img/fliview.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/fa/css/all.css">
    <link rel="stylesheet" href="/css/animate.css">
    <link rel="stylesheet" href="/css/preloader.css">

    <!-- Libraries Stylesheet -->
    <link href="/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/css/style.css" rel="stylesheet">

    <style>
    ::-webkit-scrollbar{
    width:9px;
    background: white;
    }

    ::-webkit-scrollbar-thumb{
        background: #dc3545;
        /* border-radius: 10px; */
    }
    </style>
</head>

<body>

    <div class="preloader" id="preloader">
        <div class="spinner"></div>
    </div>


        <!-- Topbar Start -->
        <div class="container-fluid">
            <div class="row align-items-center py-3 px-xl-5">
                <div class="col-lg-3 d-none d-lg-block">
                    <a href="" class="text-decoration-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-danger font-weight-bold border px-3 mr-1">Fli</span>View</h1>
                    </a>
                </div>
                @if(auth()->user())
                @if(auth()->user()->user_type != "ADMIN")
                <div class="col-lg-9 col-12 text-right">
                    <a href="{{route('cart.view')}}" class="btn border">
                        <i class="fas fa-shopping-cart text-danger"></i>
                        <span class="badge cart_counter">@if(auth()->user()) {{$total}}  @else 0 @endif</span>
                    </a>
                </div>
                @endif
                @endif
            </div>
        </div>
        <!-- Topbar End -->
    <!-- Navbar Start -->
    <div class="container-fluid">
        <div class="row border-top px-xl-5">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">Fli</span>View</h1>
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
            </div>
        </div>
    </div>
    <!-- Navbar End -->

    @yield("content");

     <!-- Footer Start -->
 <div class="container-fluid bg-danger text-white pt-1 m-auto">
    <div class="row border-top border-light pt-2 py-2">
        <div class="col-md-5 m-auto p-auto px-xl-0 text-lg-end">
            <p class="mb-md-0 text-center text-md-left text-dark">
                &copy; <a class="text-dark font-weight-semi-bold" href="#">Copyright FliView</a>
            </p>
        </div>
        <div class="col-md-6 col-6 m-auto p-auto px-xl-0 text-lg-end">
            <p class="mb-md-0 text-center text-md-left">Made with Lordacity By <b>LORDIFY</b></p>
        </div>
    </div>
</div>
<!-- Footer End -->


<!-- Back to Top -->
<a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>



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

<script src="https://checkout.squadco.com/widget/squad.min.js"></script> 

<script src="api.js"></script>


</body>

</html>