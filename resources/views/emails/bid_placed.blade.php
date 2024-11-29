<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Bid Notification | Bidsa</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap');
        
        body {
            font-family: 'Poppins', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f7f7f7;
        }

        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            width: 150px;
            margin-bottom: 20px;
        }

        h1 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .bid-details {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }

        .bid-details p {
            margin: 10px 0;
        }

        .bid-amount {
            color: #27ae60;
            font-size: 20px;
            font-weight: 700;
        }

        .product-image {
            width: 100%;
            max-width: 300px;
            height: auto;
            border-radius: 6px;
            margin: 20px auto;
            display: block;
        }

        .cta-button {
            display: inline-block;
            background-color: #2980b9;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .cta-button:hover {
            background-color: #2471a3;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
        }

        .social-links a {
            color: #2980b9;
            text-decoration: none;
            margin: 0 5px;
        }

        .social-links a:hover {
            text-decoration: underline;
        }

        @media only screen and (max-width: 480px) {
            body {
                padding: 10px;
            }
            
            .email-container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="https://www.bid.sa/logo.png" alt="Bidsa Logo" class="logo">
            <h1>Hello Auction Admin!</h1>
        </div>

        <div class="main-content">
            <p>
                A new bid has been placed on your website
            </p>
            
            <div class="bid-details">
                <p><strong>Customer Name:</strong> {{ $first_name }}</p>
                <p><strong>Product Name:</strong> {{ $product_name }}</p>
                <p><strong>Bid Amount:</strong> <span class="bid-amount">SAR {{ $bid_amount }}</span></p>
                <p><strong>Auction End Time:</strong> {{ $auction_end_time }}</p>
            </div>

            <img src="{{ $product_image }}" alt="Product Image" class="product-image">
            
            <p>To manage and monitor auction status, please visit the admin panel:</p>
            
            <a href="https://www.bid.sa/admin/login" class="cta-button" target="_blank">
                Access Admin Panel
            </a>

            <p>You will be notified of any updates regarding this bid.</p>
        </div>

        <div class="footer">
            <p>Best Regards,<br>Team Bidsa</p>
            <p>For Support: info@bid.sa</p>
            <p class="social-links">Follow us on: 
                <a href="https://twitter.com/bidsa" target="_blank">Twitter</a> | 
                <a href="https://instagram.com/bidsa" target="_blank">Instagram</a>
            </p>
        </div>
    </div>
</body>
</html>