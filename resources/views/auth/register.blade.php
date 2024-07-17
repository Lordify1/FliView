@extends("layouts.user")

@section("title")
    FliView Register
@endsection


@section("content")


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">REGISTER</h1>
        </div>
    </div>
    <!-- Page Header End -->
    

    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Create an Account</span></h2>
        </div>
        <div
        class="container alert alert-success alert-dismissible fade show"
        role="alert"
        id="report_div"
        hidden
        >
        
        <button
                type="button"
                class="btn btn-danger"
                data-bs-dismiss="alert"
                aria-label="Close"
            >x</button>
        <p id="register_report"></p>
        </div>
        
        <div class="row px-xl-5">
            <div class="col-lg-12 mb-5">
                <div class="contact-form">
                    <div id="success"></div>
                    <form   method="POST" id="registerForm">
                    <div class="control-group mb-3">
                            <label for="user_type">Please choose your user model</label>
                           <select class="form-control mb-3" name="user_type" id="user_type">
                            <option value="SHOP OWNER">Shop Owner</option>
                            <option value="CUSTOMER">Customer</option>
                           </select>
                        </div>
                        <hr>
                        <div class="control-group mb-3">
                            <x-text-input type="text" class="form-control" id="username" name="username" :value="old('username')" placeholder="Your username"
                                required="required" data-validation-required-message="Please enter your username" />
                            <x-input-error :messages="$errors->get('username')" class="text-danger" />
                        </div>
                        <div class="control-group mb-3">
                            <x-text-input type="text" class="form-control" id="name" name="name" :value="old('name')" placeholder="Your Name"
                                required="required" data-validation-required-message="Please enter your name" />
                            <x-input-error :messages="$errors->get('name')" class="text-danger" />
                        </div>
                        <div class="control-group mb-3">
                            <x-text-input type="email" class="form-control" id="email" name="email" :value="old('email')" placeholder="Your Email"
                                required="required" data-validation-required-message="Please enter your email" />
                            <x-input-error :messages="$errors->get('email')" class="text-danger" />
                        </div>
                        <div class="control-group mb-3">
                            <x-text-input type="date" class="form-control" id="dob" name="dob" :value="old('dob')"
                                />
                            <x-input-error :messages="$errors->get('date of birth')" class="text-danger" />
                        </div>
                        <div class="control-group mb-3">
                            <div class="input-group">
                                <x-text-input type="password" class="form-control" id="password" name="password" :value="old('password')" placeholder="Password"
                                required="required" data-validation-required-message="Please enter your password" />
                                <button type="button" class="btn fa fa-eye text-white bg-danger" id="see_password"></button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="text-danger" />
                        </div>
                        <div>
                            <button class="btn btn-danger text-white py-2 px-4" type="submit" id="registerbutton">Register</button>
                            
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->


    <script>
        registerUrl = "{{ route('register') }}"
        var csrftoken = '{{csrf_token()}}'

    </script>
@endsection

