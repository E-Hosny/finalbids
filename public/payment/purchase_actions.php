<?php

require_once '../vendor/autoload.php';

$config = include('config.php');

$sitesway = new \Sitesway\SiteswayApi($config['brand_id'], $config['api_key'], $config['endpoint']);

$purchase_id = '999cce79-0e81-491a-b418-1779c88e6662';

$purchase = $sitesway->getPurchase($purchase_id);

//$refund = $sitesway->refundPurchase($purchase_id);

//$cancel = $sitesway->cancelPurchase($purchase_id);

//$release = $sitesway->releasePurchase($purchase_id);

//$capture = $sitesway->capturePurchase($purchase_id);

//$charge = $sitesway->chargePurchase($purchase_id, 'test');

//$deleteToken = $sitesway->deleteRecurringToken($purchase_id);

print json_encode($purchase);