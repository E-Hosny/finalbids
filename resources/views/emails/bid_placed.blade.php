<!DOCTYPE html>
<html>
<head>
    <title>Your Bid Has Been Placed</title>
</head>
<body>
    <h1>Hello {{ $first_name }},</h1>
    <p>Thank you for placing a bid on {{ $product_name }}.</p>
    <p><strong>Bid Amount:</strong> {{ $bid_amount }}</p>
    <p><strong>Auction Ends At:</strong> {{ $auction_end_time }}</p>
    <p>To manage your bids, visit the admin panel:</p>
    <a href="https://www.bid.sa/admin/bid-placed" target="_blank">https://www.bid.sa/admin/bid-placed</a>
    <img src="{{ $product_image }}" alt="Product Image" style="max-width: 300px;">
    <p>Best regards,<br>bid.sa</p>
    
</body>
</html>
