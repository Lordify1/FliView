
<div>
    Account has been Created Successfully using this email  - {{$user->email}}<br>
    Click Button to Verify
    <button name="verify_button"><a href="{{route('verify_email',[$user->verification_token])}}">Click</a></button>
</div>
