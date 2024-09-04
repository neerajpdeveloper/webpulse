<?php
if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}
$db = \Config\Database::connect();

$routes->group('/', ['namespace' => 'App\Modules\Home\Controllers'], function($subroutes) use ($db){
    $path = (isset($_SERVER['REDIRECT_SCRIPT_URL'])) ? $_SERVER['REDIRECT_SCRIPT_URL'] : @getenv('REQUEST_URI');
    $whatToRem = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
    $path = str_replace($whatToRem, '', $path);
    $uri_aligs_string = trim($path, '/'); 
    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri_segments = explode('/', $uri_path);
    $uri_cat_string = array_pop($uri_segments); 
    $routes_array = $db->table('wps_meta_tags')->where('is_fixed','L')->where('page_url', $uri_cat_string)->get()->getResultArray();
    if($routes_array){
    $subroutes->add($uri_aligs_string, $routes_array[0]['entity_type']);
    $subroutes->add('/404', 'Home::error_404');
    } else{
        $subroutes->add('/', 'Home::index');
        $subroutes->add('/404', 'Home::error_404');
}
});