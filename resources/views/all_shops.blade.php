{{-- {{dd($shops)}} --}}
@extends("layouts.user")

@section("title")
    All Shops
@endsection


@section("content")
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">ALL SHOPS</h1>
            <form action="{{route('shop.search')}}">
                <div class="input-group">
                    <input type="text" name="search_shops" placeholder="Search Shops" class="form-control" id="search_shops">
                    {{-- <input type="hidden" name="shop_id" value="{{$shop_id}}"> --}}
                    <button class="btn bg-primary text-white" id="search_allProducts_button"><i class="fa fa-search"></i></button>
                </div>
                </form>
        </div>
    </div>
    <!-- Page Header End -->


        <!-- Contact Start -->
        <div class="container-fluid pt-5">
            <div class="row px-xl-5">
                @foreach($shops as $shop)
                <div class="col-lg-3 mb-5">
                    <div class="card product-item border-0 mb-4 shadow-lg">
                        <h4 class="text-center py-2 ">{{$shop->shop_name}} Shop</h4>
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border shadow-sm p-0">
                            @if(empty($shop->shop_logo))
                            <img class="img-fluid" style="border: 2px solid black" src="/image/shop_logo/logodefault.jpg" alt="">
                            @else
                            <img class="img-fluid" style="border: 2px solid black" src="/image/shop_logo/{{$shop->shop_logo}}" alt="">
                            @endif
                        </div>
                        <div class="card-body shadow-lg text-start">
                            <p class="text-dark">Email: {{$shop->shop_email}}</p>
                            <p class="fa fa-clock text-danger"> <span class="text-dark">{{$shop->opening_time}} - {{$shop->closing_time}}</span></p>
                        </div>
                        <div class="card-footer d-flex justify-content-between border">
                            <a href="{{route('this_shop',['fdl'=> $shop->shop_name])}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-black mr-1"></i>View Shop</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
    </div>
    <!-- Contact End -->

@endsection