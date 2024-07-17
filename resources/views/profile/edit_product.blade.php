
@extends("layouts.user")

@section("title")
    Update {{$product->name}}
@endsection


@section("content")


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">UPDATE PRODUCT</h1>
        </div>
    </div>
    <!-- Page Header End -->


        <!-- Contact Start -->
        <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Update your product</span></h2>
            @if(session("status") === "product_updated") <div class="alert alert-success text-center">Product has been updated</div>@endif
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-12 mb-5">
                <div class="contact-form">
                    <div id="success"></div>
                    <form action="{{route('product.update',['id' => $product->id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="control-group mb-2">
                            <input type="text" class="form-control" id="name" name="product_name" placeholder="Product name"
                                 value="{{$product->name}}" />
                            @error('product_name')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>
                        <input type="hidden" name="shop_id">
                        <div class="control-group mb-2">
                            <textarea class="form-control" cols="30" rows="5" id="product_description" name="product_description"  placeholder="Product Description"
                                 >{{$product->description}}</textarea>
                            @error('product_description')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>
                        <div class="control-group mb-2">
                            <select class="form-control mb-3" name="product_category" id="product_category">
                                <option value="">Select a category</option>
                                @foreach($categories as $cat)
                                <option value="{{$cat->id}}" @if($product->product_category_id == $cat->id) {{"selected"}} @endif>{{$cat->cat_name}}</option>
                                @endforeach
                            </select>
                            @error('product_category')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>
                        <div class="control-group mb-2">
                        <input type="text" name="product_sizes" class="form-control" id="product_sizes" placeholder="Product Sizes (XS,S,M,L,XL)" value="{{$product->sizes}}">
                        @error('product_sizes')
                                <p class='text-danger'>{{$message}}</p>
                        @enderror
                        </div>
                        <div class="control-group mb-2">
                            <input type="text" class="form-control" name="product_colors" placeholder="Product colors(Red,Green...)" id="product_colors" value="{{$product->color}}">
                            @error('product_colors')
                                <p class='text-danger'>{{$message}}</p>
                        @enderror
                        </div>
                        <div class="control-group mb-2">
                            <input type="number" class="form-control" id="product_count" placeholder="Product count"
                            name="product_count"  value="{{$product->how_many}}"/>
                            @error('product_count')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>
                        <div class="control-group mb-2">
                            <input type="number" class="form-control" id="product_price" placeholder="Product price"
                            name="product_price" value="{{$product->price}}"/>
                            @error('product_price')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>
                        <div class="control-group mb-2">
                            <label for="product_images">Product Image/s</label>
                            <input type="file" multiple class="form-control" id="product_images"
                            name="product_images[]" value=""/>
                            @error('product_images')
                                <p class='text-danger'>{{$message}}</p>
                             @enderror
                        </div>
                        <div class="control-group mb-2">
                            <select class="form-control mb-3" name="product_status" id="product_status">
                                <option value="">Select product status</option>
                                @foreach($statuses as $status)
                                <option value="{{$status->id}}" @if($product->product_status_id == $status->id) {{"selected"}} @endif>{{$status->status_name}}</option>
                                @endforeach
                            </select>
                            @error('product_status')
                                <p class='text-danger'>{{$message}}</p>
                        @enderror
                        </div>
                        <div>
                            <button class="btn btn-danger text-black py-2 px-4" type="submit" id="update_product_button">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->


@endsection