{{-- @include('frontend.layouts.header') --}}


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #282c34;
            font-family: Arial, sans-serif;
            color: #ffffff;
            text-align: center;
            overflow: hidden;
        }

        .coming-soon {
            font-size: 3em;
            font-weight: bold;
            background: linear-gradient(45deg, #ff416c, #ff4b2b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: pulse 2s infinite;
        }

        .subtitle {
            font-size: 1.2em;
            color: #b3b3b3;
            margin-top: 10px;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
    </style>
</head>
<body>
    <div>
        <h1 class="coming-soon">Coming Soon</h1>
        <p class="subtitle">Our website will be live soon. Stay tuned!</p>
    </div>
</body>
</html>







{{--

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


@include('frontend.products.script.addToWishListScript')

@include('frontend.layouts.requestbidscript')

@include('frontend.layouts.footer') --}}
