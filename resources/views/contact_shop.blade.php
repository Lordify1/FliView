
@extends("layouts.user")

@section("title")
    Cart items
@endsection


@section("content")


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Contact Shop</h1>
        </div>
    </div>
    <!-- Page Header End -->



    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-12">
                <div class="card border-secondary mb-5 shadow-lg">
                    <div class="card-body">
                        <div class="text-center">
                            <h4>Email : {{$shop_contact->shop_email}}</h4>
                            <hr>
                            <h4>Phone Number : {{$shop_contact->shop_phone}}</h4>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->


@endsection