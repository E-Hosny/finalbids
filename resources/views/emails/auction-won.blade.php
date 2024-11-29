<!DOCTYPE html>
<html>
<head>
    <title>تهانينا! لقد فزت بالمزاد</title>
</head>
<body>
    <h1>تهانينا!</h1>
    <p>لقد فزت بمزاد المنتج: {{ $bid->product->title }}</p>
    <p>للدفع، يرجى النقر على الرابط التالي:</p>
    <a href="{{ route('payment.page', ['bid_id' => $bid->id]) }}">ادفع الآن</a>
</body>
</html>
