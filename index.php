<?php

use Engine\Application;
use App\Kernel;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "./vendor/autoload.php";

$kernel = new Kernel();

$application = new Application(
    $kernel->build()
);

$application->run();
