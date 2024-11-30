<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bid-Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .invoice {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-width: 150px;
            height: auto;
        }
        .invoice-title {
            font-size: 24px;
        }
        .details {
            margin-bottom: 20px;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .details table td {
            padding: 8px;
            border: 1px solid #ccc;
        }
        .items {
            margin-bottom: 20px;
        }
        .items table {
            width: 100%;
            border-collapse: collapse;
        }
        .items th,
        .items td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: center;
        }
        .total {
            text-align: right;
        }
    </style>
</head>
<body>
<div class="invoice">
        <div class="header">
            <div class="logo">
                <img src="https://bid.sa/img/settings/1705055836image.jpg" alt="Logo">
            </div>
            <div class="invoice-title" style="text-align: center;">Invoice</div>
        </div>
        <div class="details">
            <table>
                <tr>
                    <td><strong>Invoice Number:</strong> {{ $invoiceData['invoiceNumber'] }}</td>
                    <td><strong>Date:</strong> {{ $invoiceData['date'] }}</td>
                </tr>
               
            </table>
        </div>
        <div class="items">
            <table>
                <tr>
                    <th>Bidder Name</th>
                    <th>Auction Type</th>
                    <th>Product Name</th>
                    <th>Bid Date Time</th>
                    <th>Bid Amount</th>
                    <!-- <th>Vat(%)</th>
                    <th>Buyers Premium</th>
                    <th>Total Amount</th> -->
                </tr>
            
                @foreach ($bidspast as $bid)
                <tr>
                    <td>{{ $bid->user->first_name }}</td>
                    <td>{{ $bid->product->project->auctionType->name }}</td>
                    <td>{{ $bid->product->title }}</td>
                    <td>{{ $bid->created_at->format('d M') }}</td>
                    <td>${{ $bid->bid_amount }}</td>
                    <!-- <td>15%</td>
                    <td>{{ $bid->buyers_premium}}%</td>
                    <td>${{ $bid->	total_amount }}</td> -->
                </tr>
                @endforeach
            </table>
        </div>
        <div class="total">
           
    @php
      $totalAmount = $bidspast->sum('total_amount');
    
    @endphp
    @foreach($bidspast as $bid)
            <p><strong>Bid Amount:</strong>${{ $bid->bid_amount }}</p>
            <p><strong>Buyer's Premium ({{ $bid->buyers_premium }}%):</strong>{{ number_format($bid->bid_amount * ($bid->buyers_premium / 100), 2) }}</p>
            <p><strong>Vat (15%):</strong>{{ number_format($bid->bid_amount * (15 / 100), 2) }}</p>
    @endforeach
    <p><strong>Total:</strong> ${{ $totalAmount }}</p>
        </div>
    </div>
</body>
</html>
