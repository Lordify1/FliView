
@extends("layouts.user")

@section("title")
    Product Image Upload
@endsection


@section("content")


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">ADD PRODUCT IMAGES</h1>
        </div>
    </div>
    <!-- Page Header End -->


        <!-- Contact Start -->
        <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Show your product</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-7 mb-5">
                <div class="contact-form">
                    <div id="success"></div>
                    <form name="sentMessage" id="contactForm" novalidate="novalidate">
                        <div class="control-group">
                            <input type="file" multiple="true" class="form-control" id="product_images" name="product_images[]" required="required"/>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div>
                            <button class="btn btn-danger text-white py-2 px-4" type="submit" id="updatebutton">Add</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="img/product-1.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->


@endsection