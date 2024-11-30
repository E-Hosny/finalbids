@component('mail::message')

# Dear {{ $first_name }}

Thanks for signing up to Bid.sa,<br> we are very happy to have you onboard! Now you can participate in our luxurious auctions.

@component('mail::button', ['url' => 'https://bid.sa/'])
Explore Now
@endcomponent


Best Regards,,<br>
<a href="https://bid.sa">
{{ config('app.name') }}
</a>

@endcomponent
