{{-- @if() --}}
@extends("layouts.user")

@section("title")
    Create your Shop
@endsection


@section("content")


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">CREATE YOUR SHOP</h1>
        </div>
    </div>
    <!-- Page Header End -->


        <!-- Contact Start -->
        <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            @if (session('status') === 'shop_created')<div class="alert alert-success">Shop Has been Created</div>@endif
            {{-- @if (session('status') === 'shop_name_success')<div class="alert alert-danger">Shop name is available</div>@endif --}}
            @if (session('status') === 'shop_name_error')<div class="alert alert-danger">Shop name already exist</div>@endif
            @if (session('status') === 'shop_email_error')<div class="alert alert-danger">Shop email already exist</div>@endif
            <h2 class="section-title px-5"><span class="px-2">Create your Fli shop</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-12 mb-5">
                <div class="contact-form">
                    <div id="success"></div>
                    <form action="{{route('shop.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" id="name" placeholder="Shop name"
                                name="shop_name" @if(isset($request)) value="{{$request->shop_name}}"@else value="{{old("shop_name")}}" @endif/>
                                {{-- <button class="btn btn-danger" type="submit">See</button> --}}
                            @error('shop_name')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>
                        <div class="control-group mb-2">
                            <input type="email" class="form-control" id="email" placeholder="Shop Email"
                                name="shop_email" value="{{old("shop_email")}}"/>
                                @error('shop_email')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>
                        <div class="control-group mb-2">
                            <textarea class="form-control" cols="30" rows="5" id="shop_description"  placeholder="Shop Description"
                                name="shop_description">{{old("shop_description")}}</textarea>
                                @error('shop_description')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>

                        <div class="control-group mb-2">
                            <input type="text" class="form-control" id="shop_address" placeholder="Shop Address"
                                name="shop_address" value="{{old("shop_address")}}"/>
                            @error('shop_address')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>
                        
                        <div class="control-group mb-2">
                            <input type="number" class="form-control" id="phone" placeholder="Shop Phone number"
                                name="shop_phone" value="{{old("shop_phone")}}"/>
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
                            <input type="time" class="form-control" id="opening_time" placeholder="opening_time" name="opening_time" value="{{old("opening_time")}}"/>
                            @error('opening_time')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>
                        <div class="control-group mb-2">
                            <label for="closing_time">Closing time</label>
                            <input type="time" class="form-control" id="closing_time" placeholder="closing_time" name="closing_time" value="{{old("closing_time")}}"/>
                            @error('closing_time')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>
                        <div class="control-group mb-2">
                            <label for="payment_method">Payment Method</label>
                            <input type="text" class="form-control" id="payment_method" placeholder="Shop Payment Method" name="payment_method" value="{{old("payment_method")}}"/>
                            @error('payment_method')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>
                        {{-- <div class="control-group mb-2">
                            <label for="payment_currency">Payment Currency</label>
                            <input type="text" class="form-control" id="payment_currency" placeholder="Shop Payment Currency" name="payment_currency" value="{{old("payment_currency")}}"/>
                            @error('payment_currency')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div> --}}
                        <div>
                            <button class="btn btn-danger text-black py-2 px-4" type="submit"  name="create_shop">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->


@endsection