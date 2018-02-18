<?php

//Load all class
require_once (__DIR__ . '/config.php');

$connectionToDB = new DBmysql();

try {
    User::setDb($connectionToDB);
} catch (PDOException $exception) {
    $response = ['error' => 'DB Connection error: '.$exception->getMessage()];
}

$uriPathInfo = $_SERVER['PATH_INFO'];
//explode path info
$path = explode('/', $uriPathInfo);
$requestClass = $path[1];

//load class file
$requestClass = preg_replace('#[^0-9a-zA-Z]#', '', $requestClass);
$className = ucfirst(strtolower($requestClass));

require_once __DIR__.'/class/'.$className.'.php';

$pathId = isset($path[2]) ? $path[2] : null;

if(!isset($response['error'])) {
    include_once __DIR__.'/restEndPoints/'.$className.'.php';
}

header('Content-Type: application/json');

if(isset($response['error'])) {
    header("HTTP/1.0 400 Bad Request");
}

echo json_encode($response);