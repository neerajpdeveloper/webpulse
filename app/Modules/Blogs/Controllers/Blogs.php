<?php 
namespace App\Modules\Blogs\Controllers;
use CodeIgniter\Controller;

class Blogs extends Controller{
    public function __construct(){
}

    public function index()
	{
            $data = ['title'=>'Blog Index'.SITENAME,'sitedata'=>'Blog'];
            echo template('\Blogs','\view_blog',$data);
	}

    
    public function details()
	{
            $data = ['title'=>'PageStatic'.SITENAME,'sitedata'=>'Pages'];
            echo template('\Blogs','\view_blog_details',$data);
	}


}
