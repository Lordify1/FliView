{{-- @php

if(!isset($check))
{
    die(); 
}

@endphp --}}

@extends('layouts.guest')

@section('title')
    Email Verify
@endsection

@section('content')
    
    <div class="container text-center p-3">
        <div class="row p-2">
            <div class="col ">
                <input type="email" name="email" id="email" class="form-control bg-danger text-white">
            </div>
        </div>

        <div class="row p-2">
            <div class="col">
                <button class="btn btn-danger"><i class="fa fa-envelope"></i> Get Email</button>
            </div>
        </div>

        <div class="row p-2">
            <div class="col img-fluid">
                <img src="/image/products/fliviewdefault.png" class="img-fluid w-25" alt="">
            </div>
        </div>
    </div>

@endsection
