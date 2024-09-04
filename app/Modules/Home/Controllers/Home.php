<?php 
namespace App\Modules\Home\Controllers;
use App\Modules\Home\Models\HomeModel;
use CodeIgniter\Controller;

class Home extends Controller{
    private $HomeModel;
    private $db;
    public function __construct()
    {
        $this->HomeModel = new HomeModel();
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
            $st_array = $this->db->table('wps_meta_tags')->where('is_fixed','L')->where('page_url',$st)->get()->getResultArray();
           if($st_array){
            $content = $this->db->table('wps_subloccontent')->where('subcontentid','1')->get()->getResultArray();
            $desc =  $content[0]['description'];
            $desc = str_replace('{location}',$st,$desc);
        } else{
            $content = $this->db->table('wps_cms_pages')->where('friendly_url','home')->get()->getResultArray();
           $desc =  $content[0]['page_description'];
        }
            $data = ['title'=>'Home'.SITENAME,'sitedata'=>$desc];
            echo template('\Home','\view_home',$data);
	}
            public function show404()
	{
            return redirect()->to(base_url('404'));
	}

    public function error_404()
	{
         echo template('\Home','\view_error',[]);
	}
}
