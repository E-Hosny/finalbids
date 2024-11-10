<?php
require_once '../vendor/autoload.php';

$config = include('config.php');

$sitesway = new \Sitesway\SiteswayApi($config['brand_id'], $config['api_key'], $config['endpoint']);

$content = '{"id": "", "due": 1642060235, "type": "purchase", "client": {"cc": [], "bcc": [], "city": "", "email": "", "phone": "", "country": "", "zip_code": "", "bank_code": "", "full_name": "", "brand_name": "", "legal_name": "", "tax_number": "", "client_type": null, "bank_account": "", "personal_code": "", "shipping_city": "", "street_address": "", "shipping_country": "", "shipping_zip_code": "", "registration_number": "", "shipping_street_address": ""}, "issued": "", "status": "created", "is_test": true, "payment": null, "product": "purchases", "user_id": null, "brand_id": "", "order_id": null, "platform": "api", "purchase": {"debt": 0, "notes": "", "total": 100, "currency": "EUR", "language": "en", "products": [{"name": "test", "price": 100, "category": "", "discount": 0, "quantity": "1.0000", "tax_percent": "0.00"}], "timezone": "UTC", "due_strict": false, "email_message": "", "total_override": null, "shipping_options": [], "subtotal_override": null, "total_tax_override": null, "payment_method_details": {}, "request_client_details": [], "total_discount_override": null}, "client_id": null, "reference": "", "viewed_on": null, "company_id": "", "created_on": 1642056635, "event_type": "purchase.created", "updated_on": 1642056635, "invoice_url": null, "checkout_url": "", "send_receipt": false, "skip_capture": false, "creator_agent": "", "issuer_details": {"website": "", "brand_name": "", "legal_city": "", "legal_name": "", "tax_number": "", "bank_accounts": [{"bank_code": "", "bank_account": ""}], "legal_country": "", "legal_zip_code": "", "registration_number": "", "legal_street_address": ""}, "marked_as_paid": false, "status_history": [{"status": "created", "timestamp": 1642056635}], "cancel_redirect": "", "created_from_ip": "", "direct_post_url": null, "force_recurring": false, "recurring_token": null, "failure_redirect": "", "success_callback": "", "success_redirect": "", "transaction_data": {"flow": "payform", "extra": {}, "country": "", "attempts": [], "payment_method": ""}, "refundable_amount": 0, "is_recurring_token": false, "billing_template_id": null, "currency_conversion": null, "reference_generated": "", "refund_availability": "none", "payment_method_whitelist": null}';
$signature = 'dHgVBR7qLldrgjMAM0exDnDIBsUU0ZpQC4lkPhAjmjZjkFlRoIYcaC4fR03avykxujZwakM1mGjvInFvCHE8zrrUemeJhHSHN+8n54zecQQ0U84JhdDufr0bSXvSduaqLW1cbBEOHKXm4UCVkMp3bRKzPGEYLM0L6PYd00x3yY53gDeOm05HWlXb5UG8hpKHJPhhr5S58r+hStlM0yAI7tkeTTy6neIin7WKS8imeiGGRh6n46mXEtIcwMzmOaRmQ7me3GAxvD8gDEPY6JV6r3eQZpTF7iX/rU0pod0P35XTvQ3pO2HMBCeRm5zfFCva9JGEVvtiJ1ZDZO/4/UfPEQ==';
$publicKey = "-----BEGIN PUBLIC KEY-----\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEArzedRaG/aa191+f3/Syf\nye4lbwaVDngwBpsV/JidZ3T/27oEAPtwZ3oqhmhsBQcVB/f94ecFdj49NTG1DZZN\nfkWjSZEViL22oEGBryK2MjkUrW30kY1Yh0vCa/e0nIG/+9b1TLfzHIwjm54hw1R/\nRi/m/tf1nLMEm06ogDNV/AUyg6uyNLqp21NxKP7+xV6yfPkfX1s+qSjciyCPzO6r\n+TsG3GTqopG1FSaWx+R0+bmsOEmV5YQKMUlLKlf0wJUD7mjsNioFomEp5QBpASbE\nLfNDO13L5FiUgLtWcz+ZazCZmNUdhstLvrEVt8NhvPWBy96YWm4GfXx7xr8F11yH\npQIDAQAB\n-----END PUBLIC KEY-----";

var_dump(\Sitesway\SiteswayApi::verify($content, $signature, $publicKey));

