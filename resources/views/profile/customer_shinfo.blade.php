@php
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;


$shipping_info = DB::select('select * from customer_shipping_info where user_id = ?', [auth()->id()]);

@endphp

@if(!empty($shipping_info))
@foreach($shipping_info as $s_info) @endforeach
@endif

@extends("layouts.user")

@section("title")
    Customer Shipping Info
@endsection


@section("content")



    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">SHIPPING INFO</h1>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Checkout Start -->
    @if (session('status') === 'Shipping Info Updated')<div class="alert alert-success text-center">Shipping Info Updated</div>@endif
    @if (session('status') === 'Shipping Info Not Updated')<div class="alert alert-danger text-center">Something went wrong</div>@endif
    @if (session('status') === 'No Change')<div class="alert alert-danger text-center">Make a Change At Least</div>@endif
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-12">
                <form action="{{route('shipping.store')}}" method="POST">
                    @csrf
                        <div class="col">
                            <div class="mb-4">
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
                                        value="{{$s_info->customer_email}}" @endif>
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
                    <div class="border-secondary bg-transparent">
                        <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3" id="c_shipping_info" type="submit" name="c_shipping_info">Update</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Checkout End -->

@endsection