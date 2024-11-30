<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Congratulations! You are the winner of the auction: </title>
    <style>
        /* Global styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }

        h1 {
            color: #333333;
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .booking-details {
            margin-bottom: 20px;
        }

        .booking-details h2 {
            color: #007bff;
            margin-bottom: 10px;
        }

        .booking-details table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .booking-details th,
        .booking-details td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #888888;
            font-size: 12px;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="header">
            <img src="https://bid.sa/img/settings/1705055836image.jpg" alt="Logo">
            <h1>Congratulations! You are the winner of the auction: </h1>
        </div>

        <p>Hello {{ $first_name }},</p>

        <div class="booking-details">
            <h2>Congratulations! You are the winner of the auction: :</h2>
            <table>
                <tr>
                    <th>Product Name:</th>
                    <td>{{ $product_name }}</td>
                </tr>
                <tr>
                    <th>Product Image:</th>
                    <td><img src="{{ $product_image }}" alt="{{ $product_name }}" style="max-width: 100px; margin-bottom: 20px;"></td>
                </tr>
                <tr>
                    <th>Bid Amount:</th>
                    <td>{{ $bid_amount }}</td>
                </tr>
                <tr>
                    <th>Auction End Date:</th>
                    <td>{{ $auction_end_time }}</td>
                </tr>
            </table>
        </div>

        <p class="footer">
          Next Step:

        1. Payment: Please proceed with payment for the item within 48 hours
        2. Shipping: Once payment is received, we will arrange for the safe and prompt shipment of your item to the address provided during registration.
        </p>
                <p style="text-align: center;">
                    <a href="https://bid.sa/" class="btn">Finish Your Purchase</a>
                </p>
        Best Regards,<br>
        <a href="https://bid.sa">
        {{ config('app.name') }}
        </a>
    </div>
   

</body>

</html>
