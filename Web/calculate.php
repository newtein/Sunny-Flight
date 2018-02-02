<?php
require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config.php';

if (empty($hideDebug)) {
    header('Content-type: text/plain');
}

$flightNumber = filter_input(INPUT_GET, 'flightno');
$startDate = filter_input(INPUT_GET, 'start_date');
$startTime = filter_input(INPUT_GET, 'start_time');

if (empty($flightNumber) || empty($startDate) || empty($startTime)) {
    echo 'Need flight info';
    exit;
}

if (empty($hideDebug)) {
    echo 'Calculate track for the flight ' . htmlspecialchars($flightNumber) . ' @ ' 
        . htmlspecialchars($startDate) . ' ' . htmlspecialchars($startTime) .  ': ' . PHP_EOL;
}

$startDateTime = DateTime::createFromFormat(
    'm/d/Y H:i', 
    $startDate . ' ' . $startTime, 
    new DateTimeZone('GMT')
);
if (!$startDateTime) {
    echo 'Invalid date time format';
    exit;
}

try
{
    $flight = new Flight($flightNumber);
    $flight->load();
    $flight->setStartDatetime($startDateTime);
}
catch (Exception $exc)
{
    echo $exc->getMessage();
    exit;
}

if (empty($hideDebug)) {
    echo 'the track was loaded', PHP_EOL;
}

try
{
    $aggregator = new Aggregator($flight);
    $aggregator->calculate();
    $sunPosition = $aggregator->getStat();
}
catch (Exception $exc)
{
    echo $exc->getMessage();
    exit;
}

if (empty($hideDebug)) {
    echo 'Sun position: ';
    print_r($sunPosition);

    echo 'Finish';
}
