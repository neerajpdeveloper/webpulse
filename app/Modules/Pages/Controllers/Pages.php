<?php 
namespace App\Modules\Pages\Controllers;
use CodeIgniter\Controller;

class Pages extends Controller{
    public function __construct(){
}

    public function index()
	{
            $data = ['title'=>'PageStatic'.SITENAME,'sitedata'=>'Pages'];
            echo template('\Pages','\view_page',$data);
	}

    public function about()
	{
            $data = ['title'=>'About'.SITENAME,'sitedata'=>'Pages'];
            echo template('\Pages','\view_page',$data);
	}

    public function contact()
	{
            $data = ['title'=>'Contact'.SITENAME,'sitedata'=>'Pages'];
            echo template('\Pages','\view_page',$data);
	}

}
