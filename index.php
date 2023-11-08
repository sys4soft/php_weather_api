<?php

require_once 'inc/config.php';
require_once 'inc/api.php';

$city = 'Lisbon';
$days = 1;

$results = Api::get($city, $days);

if($results['status'] === 'error') {
    echo $results['message'];
    exit;
}

$data = json_decode($results['data'], true);

echo '<pre>';
print_r($data);