<?php 

require 'Slim/Slim.php'; 
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get('/demo/:name', function ($name) { 
    echo "Hello, $name"; 
});

$app->run();