
@extends('layouts.user')

@section('content')
<HTML>

    <HEAD>
      <TITLE>SQUAD</TITLE>
    </HEAD>
    
    <BODY>
    
      <form id="paymentForm" action="{{route('payup')}}" method="post">
        @csrf
        <div class="container">
          <div class="text-left" style="color:red; font-family: Verdana; font-size: 30px;">SAMPLE CHECKOUT</div>
          <h6>Note: Amount should be between $1 to $10,000 (USD), NGN100 to NGN5,000,000 and KSH100 to KSH5,000,000</h6>
          <div class="row">
            <div class="col-lg-4">
              <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email-address" name="email" class="form-control" required /><br>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-group">
                <label for="amount">Amount</label>
                <input type="tel" id="amount" name="amount" class="form-control" required /><br>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="form-submit">
              <button type="submit"  class="btn btn-danger">Check Out</button><br><br>
            </div>
          </div>
        </div>
      </form>

      {{-- <script>
        onclick="SquadPay()"
        function SquadPay() {
 
 const squadInstance = new squad({
   onClose: () => console.log("Widget closed"),
   onLoad: () => console.log("Widget loaded successfully"),
   onSuccess: () => console.log(`Linked successfully`),
   key: "sandbox_sk_3c825a6306636bcc24700aae71f1a6fb2c9804d34065",
   //Change key (test_pk_sample-public-key-1) to the key on your Squad Dashboard
   email: document.getElementById("email-address").value,
   amount: document.getElementById("amount").value * 100,
   //Enter amount in Naira or Dollar (Base value Kobo/cent already multiplied by 100)
   currency_code: "NGN"
 });
 squadInstance.setup();
 squadInstance.open();

}
      </script> --}}
    
    </BODY>
    <HTML>
@endsection