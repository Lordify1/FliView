{{-- {{dd($user)}} --}}
@extends("layouts.user")

@section("title")
    Profile Edit
@endsection


@section("content")

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">EDIT YOUR PROFILE</h1>
        </div>
    </div>
    <!-- Page Header End -->


        <!-- Profile edit Start -->
        <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Update your profile</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-12 mb-5">
                <div>
                   
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}" enctype="multipart/form-data">
                        @csrf
                    </form>

                    @if (session('status') === 'profile-updated')<div class="alert alert-success text-center">Profile Has been Updated</div>@endif
                    <form method="POST" action="{{route("profile.update")}}">
                        @csrf
                        @method("patch")
                        <div class="control-group mb-3">
                            <input name="username" type="text" class="form-control" id="username" placeholder="Your username"
                                required="required" value="{{$user->username}}"/>
                        </div>
                        <div class="control-group mb-3">
                            <input name="name" type="text" class="form-control" id="name" placeholder="Your Name"
                                required="required" value="{{$user->name}}"/>
                        </div>
                        <div class="control-group mb-3">
                            <input name="email" type="email" class="form-control" id="email" placeholder="Your Email"
                                required="required" value="{{$user->email}}"/>
                        </div>
                        <div class="control-group mb-3">
                            <input name="dob" type="date" class="form-control" id="date" placeholder="date"
                                required="required" value="{{$user->dob}}"/>
                        </div>
                        <div class="control-group mb-3">
                            <input name="phone" type="text" class="form-control mb-3" id="phone" placeholder="Your phone number" value="{{$user->phone}}"/>
                        </div>
                        <div class="control-group mb-3">
                            <select class="form-control mb-3" name="gender" id="gender" >
                                <option value="male" @if($user->gender == "male") {{"selected"}} @endif>Male</option>
                                <option value="female" @if($user->gender == "female") {{"selected"}} @endif>Female</option>
                            </select>
                        </div>
                        <div class="control-group mb-3">
                            <select class="form-control mb-3" name="state_id" id="state">
                                @foreach($states as $sta)
                                <option value="{{$sta->state_id}}" @if($user->state_id == $sta->state_id) {{"selected"}} @endif>{{$sta->state_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="control-group mb-3">
                            <select class="form-control mb-3" name="lgas" id="lgas">
                                <option value=""></option>
                            </select>
                        </div> --}}
                        <div>
                            <button class="btn btn-primary py-2 px-4" type="submit" id="profileupdatebutton">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Profile edit End -->


    <script>
        var LgaUrl = "{{route('state_lga')}}"
        var csrftoken = "{{csrf_token()}}"
    </script>
@endsection