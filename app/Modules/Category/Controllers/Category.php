<?php 
namespace App\Modules\Category\Controllers;
use App\Modules\Category\Models\CategoryModel;
use CodeIgniter\Controller;

class Category extends Controller{

    private $categoryModel;
    private $db;
    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->db = db_connect();
    }

    public function index()
	{
    $st = '';
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
    $st_array = $this->db->table('wps_meta_tags')->where('is_fixed','L')->where('page_url', $st)->get()->getResultArray();
    if($st_array){
        $cat_array = $this->db->table('wps_categories')->where('friendly_url',$uri_cat_string)->get()->getResultArray();
        $category_id = $cat_array[0]['category_id'];
        // $content = $this->db->table('wps_subcontent')->where('category_id',$category_id)->get()->getResultArray();
        $content ="{location} for ".$cat_array[0]['category_name'];
        // print_r($cat_array); die();
        $desc =  $content;
        $desc = str_replace('{location}',$st,$desc);
    } else{
        $content = $this->db->table('wps_categories')->where('friendly_url',$uri_cat_string)->get()->getResultArray();
       $desc =  $content[0]['category_description'];
        $desc = str_replace('{location}',$st,$desc);
}
            $data = ['title'=>'Category'.SITENAME,'sitedata'=> $desc];
            echo template('\Category','\view_category',$data);
	}

}
