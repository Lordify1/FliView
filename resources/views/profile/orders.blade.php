<?php 
use App\Models\Product_images;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;


// $specific_order = [];

// foreach($my_orders as $o){
// $specific_order = DB::select('select * from orders where order_token = ?', [$o->order_token]);
// };
// $not = DB::select('select note from orders where order_token = ? limit 1', [$o->order_token]);

// dd($specific_order);


?>
{{-- {{dd($shop)}} --}}
@extends("layouts.user")

@section("title")
    FliVIew - Your Dashboard
@endsection


@section("content")

    <!-- Page Header Start -->
<form action="{{route("logout")}}" class="dashboard-links" method="post">
                    @csrf
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px; @if(isset($shop)) background:url('/image/shop_logo/{{$shop->shop_logo}}'); background-repeat:no-repeat; background-size:cover @endif">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">ORDERS</h1>
            @if (session('status') === 'have_a_shop')<div class="alert alert-danger">You can only create 1 shop</div>@endif
        </div>
    </div>
</form>

    <!-- Page Header End -->


    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Orders Received</span></h2>
            <div class="row px-xl-5">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        @foreach($my_orders as $order)
                        <?php $product = Product::all()->where("id","=",$order->product_id); ?>
                            <table id="order{{$order->id}}" class="table table-striped table-hover table-borderless table-@if($order->status == 'pending')primary @else success @endif align-middle">
                                <thead class="table-light">
                                    <caption>
                                        <div
                                            class="modal fade"
                                            id="sinfo{{$order->id}}"
                                            tabindex="-1"
                                            role="dialog"
                                            aria-labelledby="modalTitleId"
                                            aria-hidden="true"
                                        >
<?php
$user = User::all()->where("id","=",$order->user_id);
foreach($user as $info)
if($info->user_type == "CUSTOMER")
$sinfo = DB::select('select * from customer_shipping_info where user_id = ?', [$info->id]);

if($info->user_type == "SHOP OWNER")
$sinfo = DB::select('select * from shopowner_shipping_info where user_id = ?', [$info->id]);

?>
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalTitleId">
                                                            Shipping Info
                                                        </h5>
                                                        <button
                                                            type="button"
                                                            class="btn btn-danger"
                                                            data-bs-dismiss="modal"
                                                            aria-label="Close"
                                                        ><i class="fa fa-close"></i></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                         @if($sinfo != null)
                                                         @foreach ($sinfo as $item)
                                                         <p class="">Name - {{$item->name}}</p>
                                                         <p class="">Address - {{$item->address}}</p>
                                                         <p class="">Country - {{$item->country}}</p>
                                                         <p class="">City - {{$item->city}}</p>
                                                         <p class="">State - {{$item->state}}</p>
                                                         <p class="">Phone - {{$item->phone}}</p>
                                                         <p class="">Zip Code - {{$item->zip_code}}</p>
                                                         @endforeach
                                                         @else
                                                         <p>Customer hasn't updated this Information</p>
                                                         @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        Customer: {{$order->user_email}} | 
                                        <button 
                                        class="btn btn-primary btn-sm"
                                        type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#sinfo{{$order->id}}">
                                        <i class="fa fa-location"></i></button> <!-- Button trigger modal -->
                                        @if($order->status == 'pending')
                                        <button
                                            type="button"
                                            class="btn btn-success btn-sm conclude_modal_trigger"
                                            id="conclude_modal_button{{$order->id}}"
                                            value="{{$order->id}}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#conclude_modal{{$order->id}}"
                                        >
                                            Conclude
                                        </button>
                                        
                                        <!-- Modal -->
                                        <div
                                            class="modal fade"
                                            id="conclude_modal{{$order->id}}"
                                            tabindex="-1"
                                            role="dialog"
                                            aria-labelledby="conclude_modal_title{{$order->id}}"
                                            aria-hidden="true"
                                        >
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="conclude_modal_title{{$order->id}}">
                                                            Conclude order
                                                        </h5>
                                                        <button
                                                            type="button"
                                                            class="close fa fa-close"
                                                            data-bs-dismiss="modal"
                                                            aria-label="Close"
                                                        ></button>
                                                    </div>
                                                    <div>
                                                        <input type="hidden" name="order_id" value="{{$order->id}}">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button
                                                            type="button"
                                                            class="btn btn-secondary"
                                                            data-bs-dismiss="modal"
                                                        >
                                                            No
                                                        </button>
                                                        <input type="hidden" id="selected2conclude{{$order->id}}" value="{{$order->id}}">
                                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                                        aria-label="Close" id="conclude_button{{$order->id}}">Yes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        @elseif($order->status == 'concluded')
                                        <!-- Button trigger modal -->
                                        <button
                                            type="button"
                                            class="btn btn-primary btn-sm pend_modal_trigger"
                                            id="pend_modal_button{{$order->id}}"
                                            value="{{$order->id}}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#pend_modal{{$order->id}}"
                                        >
                                            Pend
                                        </button>
                                        
                                        <!-- Modal -->
                                        <div
                                            class="modal fade"
                                            id="pend_modal{{$order->id}}"
                                            tabindex="-1"
                                            role="dialog"
                                            aria-labelledby="pend_modal_title{{$order->id}}"
                                            aria-hidden="true"
                                        >
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="pend_modal_title{{$order->id}}">
                                                            Pend order
                                                        </h5>
                                                        <button
                                                            type="button"
                                                            class="close fa fa-close"
                                                            data-bs-dismiss="modal"
                                                            aria-label="Close"
                                                        ></button>
                                                    </div>
                                                    <div>
                                                        <input type="hidden" name="order_id" value="{{$order->id}}">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button
                                                            type="button"
                                                            class="btn btn-secondary"
                                                            data-bs-dismiss="modal"
                                                        >
                                                            No
                                                        </button>
                                                        <input type="hidden" id="selected2pend{{$order->id}}" value="{{$order->id}}">
                                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                                        aria-label="Close" id="pend_button{{$order->id}}">Yes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        @endif
                                    </caption>
                                    <caption>
                                       Note: {{$order->note}}
                                    </caption>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <tr id="order_body{{$order->id}}" class="table-@if($order->status == 'pending')primary @else success @endif">
                                        @foreach($product as $pro)
                                        <td scope="row">{{$pro->name}}</td>
                                        <td>&#8358;{{number_format($pro->price)}}</td>
                                        @endforeach
                                        <td>{{$order->quantity}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->


    <script>
        var conclude_url = '{{route("orders.conclude")}}'
        var pend_url = '{{route("orders.pend")}}'
        var csrftoken = '{{csrf_token()}}'
    </script>

@endsection