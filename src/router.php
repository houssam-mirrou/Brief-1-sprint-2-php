<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$routes = [
    '/' =>  __DIR__ .'/controllers/index.php',
    '/propos' => __DIR__ . '/controllers/propos.php',
    '/contact' => __DIR__ . '/controllers/contact.php',
    '/services' => __DIR__ . '/controllers/services.php'
];

function route_to_controller($uri, $routes)
{
    if (array_key_exists($uri, $routes)) {
        require $routes[$uri];
    } else {
        abort();
    }
}

function abort($code = 404)
{
    http_response_code($code);
    require "views/{$code}.view.php";
    die();
}

route_to_controller($uri, $routes);
