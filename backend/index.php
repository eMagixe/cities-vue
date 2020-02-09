<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$method = $_SERVER['REQUEST_METHOD'];
$file_name = "cities.json";
header('Access-Control-Allow-Origin: *');

if($method != "GET") echo ('Неверный тип запроса...<br>');
else {
    $route = $_GET['route'];
    switch (true) {
        case $route == "cities/" or $route == "cities":
            getCities($file_name);
            break;
        case preg_match('/^cities\/[0-9]/', $route):
            $id = (int)substr(stristr($route, '/'), 1);
            if(is_int($id)) getCityId($file_name, $id);
            else echo "Был введен некоректный ID";
            break;
        case $route == "download":
            download();
            break;
        default:
            echo $route;
    }
}

function download() {
    $url = "https://raw.githubusercontent.com/lutangar/cities.json/master/";
    $file = file_get_contents($url.$file_name, true);
    echo "Файл успешно скачан...<br>";
    if($file) put($file_name, $file);
}

function getCities($name) {
    echo json_encode(filterData($name));
}

function filterData($name)
{
    $data = getDataToArray($name);
    $cities = [];
    foreach($data as $key => $city){
        $current_city = [ "id" => $key, "country" => $city->country, "name" => $city->name, "lat" => $city->lat, "lng" => $city->lng ];
        array_push($cities, $current_city);
    }
    return $cities;
}

function getDataToArray($name)
{
    $file = file_get_contents($name, true);
    $data = json_decode($file);
    return $data;
}

function getCityId($name, $id)
{
    $data = filterData($name);
    foreach($data as $key => $value) {
        if($value['id'] == $id) {
            echo json_encode($value);
            break;
        }
    }
}

function put($name, $data)
{  
    $size_data = file_put_contents($name, $data);
    if($size_data) echo "Записано: ".$size_data."<br>";
    else echo "Произошла ошибка записи.<br>";
}