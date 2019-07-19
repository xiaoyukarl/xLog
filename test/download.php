<?php

require_once '../vendor/autoload.php';
$controller = new \Xlog\Http\LogController();
$date = isset($_GET['date']) ? $_GET['date'] : '2019-07-17' ;
$controller->download($date);