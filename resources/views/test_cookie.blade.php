
@extends('layouts.user')

@section('content')
    <div class="row" style="min-height:60vh">
        <div class="col">
            <form action="{{route('namecookie')}}" method="POST" name="formeed[]">
                @csrf

                <input type="text" name="product_id" id=""  class="form-control">
                <input type="text" name="quantity" id="" class="form-control">

                <button id="add" value="2">Add to Cookie</button>
            </form>
        </div>
    </div>
@endsection


{{-- if($request->hasCookie('usercookie'))
        // {

        // foreach($form as $key => $value)
        // {
        //     if(array_key_exists($key, $items))
        //     {
        //         $items[$key] += $value;
        //     }

        //     return response(view('test_cookie'))->withCookie('usercookie', json_encode($items), 1);
        // }

        // } --}}