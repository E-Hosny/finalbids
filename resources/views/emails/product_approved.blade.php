<!DOCTYPE html>
<html>
<head>
    <title>Product Approved</title>
</head>
<body>
    <p>Dear {{ $user->first_name }},</p>
    <p>Your product "{{ $product->title }}" has been approved.</p>
    <p>You can now add the rest of the data.</p>
    <p>Thank you.</p>
</body>
</html>
