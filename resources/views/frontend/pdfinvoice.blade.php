<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        /* Define your styles here */
        /* For example: */
        body {
            font-family: Arial, sans-serif;
        }
        .invoice {
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            max-width: 800px;
        }
        .invoice-header {
            border-bottom: 1px solid #ccc;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .invoice-header h1 {
            margin: 0;
        }
        .invoice-number {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .invoice-date {
            font-style: italic;
        }
        /* Add more styles as needed */
    </style>
</head>
<body>
    <div class="invoice">
        <div class="invoice-header">
            <h1>Invoice</h1>
            <div class="invoice-number">Invoice Number: {{ $invoiceData['invoiceNumber'] }}</div>
            <div class="invoice-date">Date: {{ $invoiceData['date'] }}</div>
        </div>
        
       
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                  
                </tr>
            </thead>
            <tbody>
                @foreach($bidspast as $bid)
                    <tr>
                        <td>{{ $bid->product->name }}</td>
                        <td>{{ $bid->product->price }}</td>
                     
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
