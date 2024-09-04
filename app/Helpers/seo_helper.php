<?php
if (!function_exists('create_meta')) {
  function create_meta() { 
    $db = db_connect();
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
    $starray = $db->table('wps_meta_tags')->where('is_fixed','L')->where('page_url', $st)->get()->getResultArray();
    $routes_array = $db->table('wps_meta_tags')->where('page_url', $uri_cat_string)->get()->getResultArray();
      if($starray){
        $string_st = $routes_array[0]['page_url'];
        $page_meta = [
            'title' => $routes_array[0]['meta_title'],
            'keyword' => $routes_array[0]['meta_keyword'],
            'desc' => $routes_array[0]['meta_description']
        ];
        return $page_meta;
      } else {  
        if($routes_array){
            $string_st = $routes_array[0]['page_url'];
            $page_meta = [
                'title' => $routes_array[0]['meta_title'],
                'keyword' => $routes_array[0]['meta_keyword'],
                'desc' => $routes_array[0]['meta_description']
            ];
            return $page_meta;
        }
        else {
          if($uri_cat_string=='404'){
            $page_meta = [
              'title' => 'Error',
              'keyword' => 'Error',
              'desc' => 'Error'
            ];
          } else {
            $routes_array1 = $db->table('wps_meta_tags')->where('page_url','/')->get()->getResultArray();
            $page_meta = [
              'title' => $routes_array1[0]['meta_title'],
              'keyword' => $routes_array1[0]['meta_keyword'],
              'desc' => $routes_array1[0]['meta_description']
            ];
          }
            return $page_meta;
        }
    }
  }
}



?>