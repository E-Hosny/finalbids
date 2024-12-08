<?php

require_once '../../vendor/autoload.php'; // تحميل Composer Autoloader

// إعدادات MyFatoorah
$config = [
    'api_key'      => 'QwWAWFglnYtbgkqDdcWbsHEbdowhUZo_ywOPPCI8O8fAdJtMQ0AuDiRMDrlc8gy6wU0yeJEOfdZ2IrsQV3-Ycla0PDXIXSchkeWfECdYV04pllHFfLu1rDHdvsjk3MOtTGXG_ZziwvFQQvAcX6ZXL933YULNeGa9m5ORvnMNVBltOgeUfjdJoudjVw_ksUqX1IKwhcqDe3rm3TJtkBCVANO-IS66IYVO0V4ZrU1WoWBwEgp3GFD8uZ8c4MDp_BlGftaOG80RlzjVM2ZbA3ROuZOSDydi-oVMYIMtDhfTNgitHESm7tpiESGZWKcfiAVKUVNH_ty38_F_3jDlEdYB9_yH_tH08ScFImRA4gU4IAg5B_9ZZxM9bFnmKcl2CFbfowCuLX1Ooa6RTKTWMb8G3paJd2m8MA9JUcFz4XfEEp87G159JmukCZPqd6NNDVEGRbCZZcR5t0CVw8izNFfI4IxAc3IIx5_vPvu7rbTy00sphaKBRZ6IotUHpOAaciWMT5gcvVLbfF_AoL7ti0YKSP-f1z0_hdTQQzdLBB42whhNIo_Yvu5437CBVCVP_GnyonjffM1fnws1JrWF6hhfroiW9M399-YmL3zssMVgMs86bVDzzkYQVm9NJED62BwJkPPKAjyD4ZWJZy-IrfIHj6x9NEkzXePIPBvkrnB8ypFdwcnn_1CqpYTaVwkmM1oeQttxRA', // مفتاح API
    'test_mode'    => false,                  // true إذا كنت في وضع الاختبار
    'country_iso'  => 'SAR',                 // رمز الدولة
];

// قراءة البيانات المرسلة عبر الرابط
$user_id = $_GET['user_id'] ?? null;
$bid_place_id = $_GET['bid_place_id'] ?? null;
$product_id = $_GET['product_id'] ?? null;
$price = $_GET['price'] ?? null;

if (!$user_id || !$bid_place_id || !$product_id || !$price) {
    die("Missing required parameters.");
}

// إعداد روابط النجاح والفشل
$success_url = 'https://example.com/paymentSuccess?success=1&user_id=' . $user_id . '&bid_place_id=' . $bid_place_id . '&product_id=' . $product_id;
$failure_url = 'https://example.com/paymentFail?success=0';

try {
    // إعداد مكتبة MyFatoorah
    $myFatoorah = new \MyFatoorah\Library\MyFatoorah(
        $config['api_key'],
        $config['test_mode'],
        $config['country_iso']
    );

    // إعداد بيانات الفاتورة
    $payload = [
        'CustomerName'       => 'Test Customer',
        'InvoiceValue'       => (float) $price,
        'DisplayCurrencyIso' => 'KWD',
        'CustomerEmail'      => 'customer@example.com', // استبدل ببريد العميل
        'CallBackUrl'        => $success_url,
        'ErrorUrl'           => $failure_url,
        'MobileCountryCode'  => '+965',
        'CustomerMobile'     => '12345678', // استبدل برقم العميل
        'Language'           => 'en',      // أو 'ar' حسب اللغة المطلوبة
        'CustomerReference'  => $product_id,
    ];

    // إنشاء الفاتورة
    $result = $myFatoorah->getInvoiceURL($payload, 0); // 0 = طريقة الدفع الافتراضية

    if ($result && isset($result['invoiceURL'])) {
        // إعادة توجيه المستخدم إلى صفحة الدفع
        header("Location: " . $result['invoiceURL']);
        exit;
    } else {
        throw new Exception('Failed to create payment invoice.');
    }
} catch (Exception $e) {
    // معالجة الأخطاء
    echo "Error: " . $e->getMessage();
    exit;
}
