@component('mail::message')

# Hello {{ $first_name }}

We're writing to confirm that your profile information on Bid.sa has been successfully updated. It's great to keep things fresh and up to date!


Best Regards,<br>
<a href="https://bid.sa">
{{ config('app.name') }}
</a>
@endcomponent
