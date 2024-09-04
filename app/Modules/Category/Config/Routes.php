<?php
if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}
$db = \Config\Database::connect();

$routes->group('/', ['namespace' => 'App\Modules\Category\Controllers'], function($subroutes) use ($db){
    $path = (isset($_SERVER['REDIRECT_SCRIPT_URL'])) ? $_SERVER['REDIRECT_SCRIPT_URL'] : @getenv('REQUEST_URI');
    $whatToRem = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
    $path = str_replace($whatToRem, '', $path);
    $uri_aligs_string = trim($path, '/'); 
    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri_segments = explode('/', $uri_path);
    $st = $uri_segments[2];
    if (strstr($st, '.html')) {
      $st = substr($st, 0, -5);
    }
    $uri_cat_string = array_pop($uri_segments);
    $st_array = $db->table('wps_meta_tags')->where('is_fixed','L')->where('page_url', $st)->get()->getResultArray();
    $routes_array = $db->table('wps_meta_tags')->where('is_fixed','N')->where('page_url', $uri_cat_string)->get()->getResultArray();
    if($routes_array){
        $subroutes->add($routes_array[0]['page_url'],$routes_array[0]['entity_type']);
        
    }
    if($st_array && $routes_array){
$subroutes->add($uri_aligs_string,$routes_array[0]['entity_type']);
    }
});