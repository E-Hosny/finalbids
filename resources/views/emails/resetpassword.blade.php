@component('mail::message')

# Hello {{ $first_name }}

We are delighted that you have signed up and are pleased to have you on board! Use the below OTP to complete your Sign Up procedures and verify your account on Bid.sa.

@component('mail::button', ['url' => ''])
{{ $otp }}
@endcomponent

Remember, never share this OTP with anyone.

Thanks,<br>
<a href="https://bid.sa">
{{ config('app.name') }}
</a>
@endcomponent
