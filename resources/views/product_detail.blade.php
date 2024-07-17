<?php 
use App\Models\Shop;
if(auth()->user())
$user_id = Shop::find(auth()->id(),"user_id");

$shop = DB::select('select * from shops where id = ?', [$product->shop_id]);
foreach($shop as $this_shop)
?>

@if(auth()->user())
<?php 
 $user_shop = DB::select('select * from shops where user_id = ?', [auth()->id()]);
?>
@endif
@foreach($rating_total as $total) @endforeach
@extends("layouts.user")

@section("title")
    Viewing Product
@endsection


@section("content")

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">{{$product->name}}</h1>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-3 shadow-sm">
                <?php $product_images = DB::select('select image_name from product_images where product_id = ? limit 1', [$product->id]); $no = 1;?>
                @if(empty($product_images))
                            <img class="w-100 h-100" src="/img/product-1.jpg" alt="Image">
                @endif
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                    @foreach($product_images as $image)
                        <div class="carousel-item active">
                        <img class="h-100 w-100" @if($image->image_name == null) @else src="/image/products/{{$image->image_name}}" @endif alt="">
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>


            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold">{{$product->name}} - &#8358; {{number_format($product->price)}}</h3>
                {{-- <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        <?php $rates_totaled = $total->rates;
                        if($rates_totaled < 10){
                        ?>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <?php }elseif($rates_totaled > 10 && $rates_totaled <= 30){ ?>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <?php }elseif($rates_totaled > 30 && $rates_totaled <= 50){ ?>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                        <?php }elseif($rates_totaled > 50 && $rates_totaled <= 75){ ?>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        <?php }elseif($rates_totaled > 75){ ?>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        <?php } ?>
                    </div>
                    <small class="pt-1">( @if(count($reviews) < 1) No reviews @else {{count($reviews)}} @if(count($reviews) > 1) reviews @else review @endif @endif)</small>
                </div> --}}
                
                <div class="d-flex mb-3">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Available sizes:</p>
                    <form>
                        <?php $sizeid = 1; $sizelabel = 1; $sizes = explode(",",$product->sizes); ?>
                        @foreach($sizes as $size)
                        {{-- <div> --}}
                            {{-- <input type="checkbox" class="custom-control-input product_sizes" value="{{$size}}" id="size-{{$sizeid++}}" name="size"> --}}
                            <label class="" for="size-{{$sizelabel++}}">{{$size}} | </label>
                        {{-- </div> --}}
                        @endforeach
                    </form>
                </div>
                <div class="d-flex mb-4">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Available Colors:</p>
                        <?php $colorid = 1; $colorlabel = 1; $colors = explode(",",$product->color); ?>
                        @foreach($colors as $color)
                        {{-- <div> --}}
                            {{-- class="custom-control custom-radio custom-control-inline" --}}
                            {{-- <input type="checkbox" class="custom-control-input product_colors" id="color-{{$colorid++}}" value="{{$color}}" name="color"> --}}
                            {{-- custom-control --}}
                            <label class="bg-secondary p-1" for="color-{{$colorlabel++}}"><span style="color: {{$color}}">{{$color}}</span> | </label>
                        {{-- </div> --}}
                        @endforeach
                </div>
                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-minus" >
                            <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="hidden" name="shop_id" value="{{$product->shop_id}}" id="shop_id">
                        <input type="text" class="form-control bg-secondary text-center" id="product_detail_increment" value="1" placeholder="1">
                        <input type="hidden" name="" id="product_count" value="{{$product->how_many}}">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                @if(Auth::user())<button class="btn btn-primary px-3" value="{{$product->id}}" @if(!empty($user_shop)) @foreach($user_shop as $shop) @if($shop->id == $product->shop_id) disabled @endif @endforeach @endif  class="add_to_cart" id="add_to_cart_advanced"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>@else<a href="{{route("login")}}" class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</a>@endif
                </div>
                {{-- <div class="d-flex pt-2">
                    <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        </a>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
                    <a class="nav-item nav-link " data-toggle="tab" href="#tab-pane-2">More</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews ({{count($reviews)}})</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane show fade active" id="tab-pane-1">
                        <h4 class="mb-3">"{{$product->name}}" Description</h4>
                        <p>{{$product->description}}</p>
                    </div>
                    <div class="tab-pane " id="tab-pane-2">
                        {{-- <h4 class="mb-3">Additional Information</h4> --}}
                        <div class="row px-xl-5">
                        <?php $product_images = DB::select('select * from product_images where product_id = ?', [$product->id]);?>
                        @if(!empty($product_images))
                        @foreach($product_images as $image)
                            <div class="col-lg-3 mb-5" id="image_col{{$image->id}}">
                                <div class="card product-item border border-secondary p-2 shadow-sm mb-4">
                                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                        <img class="img-fluid" style="border: 2px solid black" @if($image->image_name == null) @else src="/image/products/{{$image->image_name}}" @endif alt="">
                                        @if(auth()->user())
                                        @if(!empty($user_id))
                                        @if($user_id->user_id == auth()->id())
                                        <button class="btn delete_image" value="{{$image->id}}" ><i class="fa fa-trash text-danger"></i></button>
                                        @endif
                                        @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @endif
                        </div>
                    </div>
                    <div class="tab-pane  fade " id="tab-pane-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-4">@if(count($reviews) < 1) No reviews for this Product yet @else {{count($reviews)}} @if(count($reviews) > 1) reviews @else review @endif for "{{$product->name}}" @endif</h4>
                                <hr>
                                @foreach($reviews as $review)
                                <div class="media mb-4">
                                    <div class="media-body">
                                        <h6>{{$review->name}}<small> - <i><?php $input_date = $review->created_at; $parsed_date = date_create_from_format("Y-m-d H:i:s",$input_date);?> {{$formatted_date = date_format($parsed_date,"M. d, Y")}}</i></small></h6>
                                        <div class="text-primary mb-2">
                                            <?php $rating_count = $review->rating;
                                            for($i=0;$i < $rating_count; $i++){
                                            ?>
                                            <i class="fas fa-star"></i>
                                            <?php } ?>
                                        </div>
                                        <p>{{$review->review}}</p>
                                        <hr>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-4">Leave a review</h4>
                                <small>Your email address will not be published.</small>
                    @if (session('status') === 'review-sent')<div class="alert alert-success">Thanks for the review</div>@endif
                                <div class="d-flex my-3">
                                    <form action="{{route('review.store',[$product->id])}}" method="post">
                                    @csrf
                                    <p class="mb-0 mr-2">Your Rating  :</p>
                                    <div class="text-primary">
                                        {{-- <i id="reviewstar1" value="1" class="far fa-star"></i>
                                        <i id="reviewstar2" value="2" class="far fa-star"></i>
                                        <i id="reviewstar3" value="3" class="far fa-star"></i>
                                        <i id="reviewstar4" value="4" class="far fa-star"></i>
                                        <i id="reviewstar5" value="5" class="far fa-star"></i> --}}
                                        <input type="number" class="form-control" placeholder="1 to 5" value="{{old("rating")}}" name="rating" id="review_rating">
                                        @error('rating')
                                        <p class='text-danger'>{{$message}}</p>
                                        @enderror
                                        <p class='text-danger' id="rating_error"></p>
                                    </div>
                                </div>
                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                    <div class="form-group">
                                        <label for="message">Your Review </label>
                                        <textarea id="message" cols="30" rows="5" class="form-control" name="review_message">{{old("review_message")}}</textarea>
                                        @error('review_message')
                                        <p class='text-danger'>{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Your Name </label>
                                        <input type="text" class="form-control" id="name" value="{{old("reviewer_name")}}" name="reviewer_name">
                                        @error('reviewer_name')
                                        <p class='text-danger'>{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Your Email </label>
                                        <input type="email" class="form-control" id="email" value="{{old("reviewer_email")}}" name="reviewer_email">
                                        @error('reviewer_email')
                                        <p class='text-danger'>{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-0">
                                        <input type="submit" value="Leave Your Review" id="leavereview" class="btn btn-primary px-3">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->

    <div class="container">
        <hr>
    </div>

    <!-- Products Start -->
    <div class="container-fluid py-2">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
        </div>
        <div class="row px-xl-5">
                @foreach($some_products as $sproduct)
                <div class="col-lg-3 mb-5">
                    <div class="card product-item shadow-sm border-0 mb-4">
                    <?php $product_images = DB::select('select image_name from product_images where product_id = ? LIMIT 1', [$sproduct->id]);?>
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        @if(empty($product_images))
                        <img class="img-fluid w-100" src="/img/product-1.jpg" alt="">
                        @endif
                        @foreach($product_images as $image)
                        <img class="img-fluid w-100" @if($image->image_name == null) @else src="/image/products/{{$image->image_name}}" @endif alt="">
                        @endforeach
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">{{$sproduct->name}} | <i class="fa fa-shopping-cart"></i></h6>
                            <div class="d-flex justify-content-center">
                                <h6>&#8358;{{number_format($sproduct->price)}}</h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="{{route('product.this',[$sproduct->id])}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Product</a>
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
    <!-- Products End -->


    <script>
        var addtocartUrl = '{{route("cart.add")}}'
        var csrftoken = '{{csrf_token()}}'
        var imageDelete = "{{route('image.destroy')}}"
    </script>
@endsection