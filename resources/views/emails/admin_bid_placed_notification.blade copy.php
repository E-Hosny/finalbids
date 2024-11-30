<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Product Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            background-color: #0B3058;
            color: #fff;
            padding: 15px 0;
            border-radius: 10px 10px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            margin: 20px 0;
            line-height: 1.6;
        }
        .content h2 {
            color: #0B3058;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #aaa;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0B3058;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            margin-bottom: 10px;
        }
        ul li strong {
            color: #0B3058;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Bid.sa</h1>
        </div>
        <div class="content">
            <h2>New Product Notification</h2>
            <p>Dear Admin,</p>
            <p>A new product has been added to the platform. Here are the details:</p>
            <ul>
                <li><strong>Title:</strong> {{ $product->title }}</li>
                <li><strong>Arabic Title:</strong> {{ $product->title_ar }}</li>
                <li><strong>Reserved Price:</strong> {{ $product->reserved_price }}</li>
                <li><strong>Description:</strong> {{ $product->description }}</li>
                <li><strong>Description (Arabic):</strong> {{ $product->description_ar }}</li>
                <li><strong>Lot Number:</strong> {{ $product->lot_no }}</li>
            </ul>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Bid.sa. All rights reserved.
        </div>
    </div>
</body>
</html>
