
@extends('layouts.user')

@section('content')

    <form action="{{route('mail')}}" method="post">
        @csrf
        <input type="email" name="email" id="">
        <button type="submit">Submit</button>
    </form>

@endsection