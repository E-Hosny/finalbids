<?php

require_once 'vendor/autoload.php';

$config = include('config.php');
$user_id=$_GET['user_id'];
$bid_place_id=$_GET['bid_place_id'];
$product_id=$_GET['product_id'];
$price=$_GET['price'];
$url='https://bid.sa/paymentSuccess?success=1&user_id='.$user_id.'&bid_place_id='.$bid_place_id.'&product_id='.$product_id;
$sitesway = new \Sitesway\SiteswayApi($config['brand_id'], $config['api_key'], $config['endpoint']);
// /print_r($sitesway);die;
$client = new \Sitesway\Model\ClientDetails();
$client->email = 'gopaljploft@gmail.com';
$purchase = new \Sitesway\Model\Purchase();
$purchase->client = $client;
$details = new \Sitesway\Model\PurchaseDetails();
$product = new \Sitesway\Model\Product();
$product->name = 'Test';
$product->price = $price*100;
$details->products = [$product];
$purchase->purchase = $details;
$purchase->brand_id = $config['brand_id'];
$purchase->success_redirect = $url;
$purchase->failure_redirect = 'https://bid.sa/paymentFail?success=0';
//print_r($purchase);die;
$result = $sitesway->createPurchase($purchase);

if ($result && $result->checkout_url) {
	// Redirect user to checkout
	header("Location: " . $result->checkout_url);
	exit;
}