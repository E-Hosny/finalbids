@component('mail::message')

# Hello {{ $first_name }}

We are sending you this email because you requested a password reset. Please use the following One Time Password (OTP): 

@component('mail::button', ['url' => ''])
{{ $otp }}
@endcomponent

Remember, never share this OTP with anyone.

Best Regards,<br>
<a href="https://bid.sa">
{{ config('app.name') }}
</a>
@endcomponent
