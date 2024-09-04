<?php namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\AdminModel;
use CodeIgniter\Controller;

class Dashboard extends Controller

{
    public function index()
	{
        $db = db_connect();

        $builder = $db->table('wps_categories'); $cat_count = $builder->countAllResults(); // Category Count

        $builder1 = $db->table('wps_products'); $pro_count = $builder1->countAllResults(); // Product Count

        $builder2 = $db->table('wps_enquiry'); $enq_coumt = $builder2->countAllResults(); // Enquiry Count

        $builder3 = $db->table('wps_review'); $review_count = $builder3->countAllResults(); // Review Count

        $enqquery = $db->table('wps_enquiry')->where('type', 4)->get('5')->getResultArray(); // Enquiry Result

            $data =[

                'title' => 'Admin Dashnoard '.SITENAME,

                'catnum' => $cat_count,

                'productnum' => $pro_count,

                'enquirynum' => $enq_coumt,

                'reviewnum' => $review_count,

                'enqquery' => $enqquery

            ];
            echo admin_template('\Admin','\dashboard\dashboard', $data);
	}

}

