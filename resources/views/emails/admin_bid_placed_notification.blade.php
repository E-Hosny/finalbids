<!DOCTYPE html>
<html>
<head>
    <title>New Bid Placed Notification</title>
</head>
<body>
    <h2>New Bid Placed by {{ $bidDetails['user_name'] }}</h2>
    <p><strong>Product:</strong> {{ $bidDetails['product_name'] }}</p>
    <p><strong>Project:</strong> {{ $bidDetails['project_name'] }}</p>
    <p><strong>Bid Amount:</strong> {{ $bidDetails['bid_amount'] }}</p>
    <p><strong>Buyer's Premium:</strong> {{ $bidDetails['buyers_premium'] }}</p>
    <p><strong>Total Amount:</strong> {{ $bidDetails['total_amount'] }}</p>
    <p>You can review the bid by visiting the <a href="{{ $bidDetails['admin_panel_link'] }}">Admin Panel</a>.</p>
</body>
</html>
