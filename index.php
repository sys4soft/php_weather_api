<?php

require_once 'inc/config.php';
require_once 'inc/api.php';

$city = 'Lisbon';
$days = 5;

$results = Api::get($city, $days);

if($results['status'] === 'error') {
    echo $results['message'];
    exit;
}

$data = json_decode($results['data'], true);

// location data
$location = [];
$location['name'] = $data['location']['name'];
$location['region'] = $data['location']['region'];
$location['country'] = $data['location']['country'];
$location['latitude'] = $data['location']['lat'];
$location['longitude'] = $data['location']['lon'];
$location['current_time'] = $data['location']['localtime'];

// current weather data
$current = [];
$current['temperature'] = $data['current']['temp_c'];
$current['condition'] = $data['current']['condition']['text'];
$current['condition_icon'] = $data['current']['condition']['icon'];
$current['wind_speed'] = $data['current']['wind_kph'];

// forecast weather data
$forecast = [];
foreach($data['forecast']['forecastday'] as $day) {
    $forecast_day = [];
    $forecast_day['date'] = $day['date'];
    $forecast_day['condition'] = $day['day']['condition']['text'];
    $forecast_day['condition_icon'] = $day['day']['condition']['icon'];
    $forecast_day['max_temp'] = $day['day']['maxtemp_c'];
    $forecast_day['min_temp'] = $day['day']['mintemp_c'];
    $forecast[] = $forecast_day;
}

echo '<pre>';
print_r($location);
print_r($current);
print_r($forecast);