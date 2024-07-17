<?php foreach($shop as $sho) ?>
@extends("layouts.user")

@section("title")
    Shop Edit
@endsection


@section("content")

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">EDIT YOUR SHOP</h1>
        </div>
    </div>
    <!-- Page Header End -->


        <!-- Contact Start -->
        <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Update your shop</span></h2>
            @if (session('status') === 'shop_updated')<div class="alert alert-success">Shop Has been Updated</div>@endif
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-12 mb-5">
                <div class="contact-form">
                    <div id="success"></div>
                    <form action="{{route('shop.update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" id="name" placeholder="Shop name"
                                name="shop_name" value="{{$sho->shop_name}}"/>
                            @error('shop_name')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>
                        <div class="control-group mb-2">
                            <input type="email" class="form-control" id="email" placeholder="Shop Email"
                                name="shop_email" value="{{$sho->shop_email}}"/>
                                @error('shop_email')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>
                        <div class="control-group mb-2">
                            <textarea class="form-control" cols="30" rows="5" id="shop_description"  placeholder="Shop Description"
                                name="shop_description">{{$sho->shop_description}}</textarea>
                                @error('shop_description')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>

                        <div class="control-group mb-2">
                            <input type="text" class="form-control" id="shop_address" placeholder="Shop Address"
                                name="shop_address" value="{{$sho->shop_address}}"/>
                            @error('shop_address')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>
                        
                        <div class="control-group mb-2">
                            <input type="number" class="form-control" id="phone" placeholder="Shop Phone number"
                                name="shop_phone" value="{{$sho->shop_phone}}"/>
                            @error('shop_phone')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>
                        <div class="control-group mb-2">
                            <label for="shop_logo">Shop Logo</label>
                            <input type="file" class="form-control" id="shop_logo"
                                name="shop_logo" value="{{old("shop_logo")}}"/>
                            @error('shop_logo')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>
                        <div class="control-group mb-2">
                            <label for="opening_time">Opening time</label>
                            <input type="time" class="form-control" id="opening_time" placeholder="opening_time" name="opening_time" value="{{$sho->opening_time}}"/>
                            @error('opening_time')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>
                        <div class="control-group mb-2">
                            <label for="closing_time">Closing time</label>
                            <input type="time" class="form-control" id="closing_time" placeholder="closing_time" name="closing_time" value="{{$sho->closing_time}}"/>
                            @error('closing_time')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>
                        <div class="control-group mb-2">
                            <label for="payment_method">Payment Method</label>
                            <input type="text" class="form-control" id="payment_method" placeholder="Shop Payment Method" name="payment_method" value="{{$sho->payment_method}}"/>
                            @error('payment_method')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>
                        {{-- <div class="control-group mb-2">
                            <label for="payment_currency">Payment Currency</label>
                            <input type="text" class="form-control" id="payment_currency" placeholder="Shop Payment Currency" name="payment_currency" value="{{strtoupper($sho->payment_currency)}}"/>
                            @error('payment_currency')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div> --}}
                        <div>
                            <button class="btn btn-danger text-black py-2 px-4" type="submit"  name="create_shop">Update</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

@endsection