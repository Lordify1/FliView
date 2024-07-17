
@extends("layouts.user")

@section("title")
    Admin Login
@endsection


@section("content")

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">ADMIN LOGIN</h1>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Access Authority</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-12 mb-5">
                <div class="contact-form">
                    <form action="{{route('login')}}" method="POST">
                        @csrf
                        <div class="control-group mb-3">
                            <x-text-input type="email" class="form-control" id="email" name="email" :value="old('email')" placeholder="Your Email"
                               data-validation-required-message="Please enter your email" />
                                <x-input-error :messages="$errors->get('email')" class="text-danger" />
                        </div>
                        <div class="control-group input-group mb-3">
                            <x-text-input type="password" class="form-control" id="password" name="password" placeholder="Your password"
                                 data-validation-required-message="Please enter your password" />
                                <button class="btn fa fa-eye text-white bg-danger" id="see_password" type="button"></button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="text-danger" />
                        <div>
                            <x-primary-button class="btn btn-primary text-white py-2 px-4" type="submit" id="loginbutton">Login</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->


@endsection