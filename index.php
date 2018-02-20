<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

//system files
session_start();
//session_destroy();
include_once 'autoload/autoloadClasses.php';

$CoreExceptionHandler = new CoreExceptionHandler();
set_exception_handler([$CoreExceptionHandler, 'handle']);

//call Router;
$router = new CoreRouter();
$router->start();