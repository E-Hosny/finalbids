<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة منتج جديد</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background-color: #f6f6f6;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #2563eb;
            color: white;
            padding: 24px;
            text-align: center;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .content {
            padding: 24px;
        }

        .intro {
            color: #4b5563;
            margin-bottom: 24px;
            font-size: 16px;
            line-height: 1.5;
        }

        .product-details {
            background-color: #f8fafc;
            border-radius: 6px;
            padding: 20px;
        }

        .detail-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 16px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 16px;
        }

        .detail-item:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }

        .detail-label {
            font-weight: 600;
            color: #374151;
            width: 140px;
            flex-shrink: 0;
        }

        .detail-value {
            color: #4b5563;
            flex: 1;
        }

        .footer {
            text-align: center;
            padding: 24px;
            background-color: #f8fafc;
            color: #6b7280;
            font-size: 14px;
        }

        @media (max-width: 640px) {
            .container {
                margin: 0;
            }

            .detail-item {
                flex-direction: column;
            }

            .detail-label {
                width: 100%;
                margin-bottom: 8px;
            }
        }
    </style>
</head>
<body>

    
    <div class="container">
        <div class="header">
            <h1>تم إضافة منتج جديد</h1>
        </div>
        
        <div class="content">
            <p class="intro">تم إرسال طلب لإضافة منتج للمزاد . فيما يلي تفاصيل المنتج:</p>
            
            <div class="product-details">
                <div class="detail-item">
                    <div class="detail-label">العنوان:</div>
                    <div class="detail-value">{{ $product->title }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">العنوان (بالعربية):</div>
                    <div class="detail-value">{{ $product->title_ar }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">الوصف:</div>
                    <div class="detail-value">{{ $product->description }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">الوصف (بالعربية):</div>
                    <div class="detail-value">{{ $product->description_ar }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">رقم المجموعة:</div>
                    <div class="detail-value">{{ $product->lot_no }}</div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            هذا البريد الإلكتروني تم إرساله تلقائياً - الرجاء عدم الرد عليه
        </div>
    </div>
</body>
</html>