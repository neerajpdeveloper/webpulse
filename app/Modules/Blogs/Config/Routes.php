<?php

namespace App\Router;


if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}
$db = \Config\Database::connect();

$routes->group('/', ['namespace' => 'App\Modules\Blogs\Controllers'], function($subroutes) use ($db){
    $path = (isset($_SERVER['REDIRECT_SCRIPT_URL'])) ? $_SERVER['REDIRECT_SCRIPT_URL'] : @getenv('REQUEST_URI');
    $whatToRem = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
    $path = str_replace($whatToRem, '', $path);
    $uri_aligs_string = trim($path, '/');
    $routes_array = $db->table('wps_meta_tags')->where('is_fixed','B')->where('page_url', $uri_aligs_string)->get()->getResultArray();
    if($routes_array){
    $subroutes->add($uri_aligs_string, $routes_array[0]['entity_type']);
    }
});