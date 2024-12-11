@component('mail::message')
# تهانينا! {{ $first_name }}

لقد فزت بالمزاد على المنتج التالي:

**تفاصيل المزاد:**
- اسم المنتج: {{ $product_title }}
- سعر الفوز: {{ number_format($winning_amount, 2) }} ريال
- تاريخ إغلاق المزاد: {{ $auction_end_date }}

@if($product_image)
![صورة المنتج]({{ $product_image }})
@endif

للمتابعة والدفع، يرجى الضغط على الزر أدناه:

@component('mail::button', ['url' => $payment_link])
اضغط هنا للدفع
@endcomponent

**ملاحظة هامة:**
يرجى إتمام عملية الدفع في أقرب وقت ممكن لتأكيد الفوز بالمزاد.

مع تحياتنا،<br>
{{ config('app.name') }}
@endcomponent
