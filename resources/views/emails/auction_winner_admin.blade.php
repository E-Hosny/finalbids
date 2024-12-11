@component('mail::message')
# إشعار فوز بالمزاد

مرحباً مدير النظام،

تم إغلاق المزاد على المنتج التالي:

**معلومات المنتج:**
- اسم المنتج: {{ $product_title }}
- سعر الفوز: {{ number_format($winning_amount, 2) }} ريال

**معلومات الفائز:**
- الاسم: {{ $first_name }}
- البريد الإلكتروني: {{ $winner_email }}
- رقم الهاتف: {{ $winner_phone }}

**تفاصيل إضافية:**
- تاريخ ووقت الإغلاق: {{ $auction_end_date }}

@if($product_image)
![صورة المنتج]({{ $product_image }})
@endif

شكراً لكم،<br>
{{ config('app.name') }}
@endcomponent