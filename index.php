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
$location['current_time'] = $data['location']['localtime'];

// current weather data
$current = [];
$current['info'] = 'Neste momento:';
$current['temperature'] = $data['current']['temp_c'];
$current['condition'] = $data['current']['condition']['text'];
$current['condition_icon'] = $data['current']['condition']['icon'];

// forecast weather data
$forecast = [];
foreach($data['forecast']['forecastday'] as $day) {
    $forecast_day = [];
    $forecast_day['info'] = null;
    $forecast_day['date'] = $day['date'];
    $forecast_day['condition'] = $day['day']['condition']['text'];
    $forecast_day['condition_icon'] = $day['day']['condition']['icon'];
    $forecast_day['max_temp'] = $day['day']['maxtemp_c'];
    $forecast_day['min_temp'] = $day['day']['mintemp_c'];
    $forecast[] = $forecast_day;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="bg-dark text-white">

    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-10 p-5 bg-light text-black">
                <h3>Tempo para a cidade <strong><?= $city ?></strong></h3>
                <hr>
                <!-- current  -->
                <?php 
                    $weather_info = $current;
                    include 'inc/weather_info.php';
                ?>
                <!-- forecast -->
                <?php foreach($forecast as $day) : ?>
                    <?php 
                        $weather_info = $day;
                        include 'inc/weather_info.php';
                    ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</body>
</html>