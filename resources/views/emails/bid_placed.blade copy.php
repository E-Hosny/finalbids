<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم وضع مزايدتك بنجاح | Bidsa</title>
    <style>
        /* استخدام الخط السعودي */
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');
        
        body {
            font-family: 'Tajawal', Arial, sans-serif;
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
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
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
            <h1>مرحباً ادارة مزادات!</h1>
        </div>

        <div class="main-content">
            <p>
                تم تقديم سعر  جديد في موقعكم
            </p>
            
            <div class="bid-details">
                <p><strong>اسم العميل:</strong> {{ $first_name }}</p>
                <p><strong>اسم المنتج:</strong> {{ $product_name }}</p>
                <p><strong>قيمة المزايدة:</strong> <span class="bid-amount">{{ $bid_amount }} ريال سعودي</span></p>
                <p><strong>تاريخ انتهاء المزاد:</strong> {{ $auction_end_time }}</p>
            </div>

            <img src="{{ $product_image }}" alt="صورة المنتج" class="product-image">
            
            <p>لإدارة مزايداتك ومتابعة حالة المزاد، يمكنك زيارة لوحة التحكم:</p>
            
            <a href="https://www.bid.sa/admin/bid-placed" class="cta-button" target="_blank">
                إدارة المزايدات
            </a>

            <p>سنقوم بإعلامك فور وجود أي تحديثات على مزايدتك.</p>
        </div>

        <div class="footer">
            <p>مع أطيب التحيات،<br>فريق Bidsa</p>
            <p>للمساعدة والدعم: info@bid.sa</p>
            <p>تابعنا على: 
                <a href="https://twitter.com/bidsa" target="_blank">تويتر</a> | 
                <a href="https://instagram.com/bidsa" target="_blank">انستغرام</a>
            </p>
        </div>
    </div>
</body>
</html>