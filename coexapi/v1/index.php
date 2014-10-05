<?php 

require 'Slim/Slim.php'; 
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get('/demo/:name', function ($name) { 
    echo json_encode( "Hello, " . $name );
});

$app->run();