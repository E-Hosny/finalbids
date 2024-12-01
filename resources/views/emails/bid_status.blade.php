<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bid Status Update</title>
</head>
<body>
    <h1>Bid Status Update</h1>
    
    <p>Hello {{ $bid->user->first_name }},</p>
    
    @if($status == 'approved')
        <p>Your bid has been <strong>approved</strong> successfully. Congratulations!</p>
    @elseif($status == 'rejected')
        <p>Unfortunately, your bid has been <strong>rejected</strong>.</p>
    @else
        <p>Your bid is currently <strong>pending</strong>.</p>
    @endif
    
    <p>Thank you for participating in our auction.</p>
</body>
</html>
