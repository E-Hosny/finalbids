<?php

require_once '../vendor/autoload.php';

$config = include('config.php');

$sitesway = new \Sitesway\SiteswayApi($config['brand_id'], $config['api_key'], $config['endpoint']);

$methods = $sitesway->getPaymentMethods('EUR');

print json_encode($methods);