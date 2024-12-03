<!DOCTYPE html>
<html>
<head>
    <title>Product Rejected</title>
</head>
<body>
    <p>Dear {{ $user->first_name }},</p>
    <p>Your product "{{ $product->title }}" has been rejected.</p>
    <p>Reason: {{ $rejectionReason }}</p>
    <p>Please contact support for more details.</p>
    <p>Thank you.</p>
</body>
</html>
