@extends('layouts.guest')

@section('title')
    Email Verify
@endsection

@section('content')
    
    <div class="container text-center p-3">
        <div class="row p-2">
            <div class="col">
                The Token was incorrect.<br> Provide your email and Request for another link to complete your account verification.
                @if(session("status") === "email_not_found") <p>Email not found. Create an account first</p> @endif
            </div>
        </div>

        <form action="{{route('resend_regmail')}}" method="POST">
            @csrf
        <div class="row p-2 d-flex flex-column align-items-center justify-content-center ">
            <div class="col-lg-5">
                <input type="email" name="email" id="resend_to_email" class="form-control shadow-sm" placeholder="Email">
            </div>
            @error('email')
                <p class='text-danger'>{{$message}}</p>
            @enderror
        </div>

        <div class="row p-2">
            <div class="col">
                <button class="btn btn-danger" id="resend_email"><i class="fa fa-envelope"></i> Resend Email</button>
            </div>
        </div>
        </form>

        <div class="row p-2">
            <div class="col img-fluid">
                <img src="/image/products/fliviewdefault.png" class="img-fluid w-25" alt="">
            </div>
        </div>
    </div>

    <script>
        resendMail = "{{route('resend_regmail')}}"
        csrftoken = "{{csrf_token()}}"
    </script>

@endsection


