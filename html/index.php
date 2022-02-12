<?php
include '../vendor/autoload.php';
error_reporting(E_ALL & ~E_WARNING);
use Kav\Blog\Application\Application;

$app = new Application();
$app->run();
