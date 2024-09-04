<?php namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\SubdomainHomeModel;
use App\Modules\Admin\Models\MetaModel;
use CodeIgniter\Controller;
use App\Libraries\EmailLibrary;

class SubdomainHome extends Controller
{
    private $HomeModel;
    private $metaModel;
    private $email;


    public function __construct()
    {
        $this->email = new EmailLibrary();
        $this->HomeModel = new SubdomainHomeModel();
        $this->metaModel = new MetaModel();
    }

    public function index()
	{ 
        $headingTitle  = 'Manage Sub Domain Home';

        $data =[
                'title' => 'Manage Sub Domain Home | Admin - '.SITENAME,
                'heading' => $headingTitle,                                                                                                                                                                                                              
                'PageRes' =>$this->HomeModel->paginate(10),
                'pager' => $this->HomeModel->pager,
            ];

            // $config = [
            //     'from'         => 'neerajprajapati0909@gmail.com',
            //     'fromName'     => 'neeraj',
            //     'replyTo'      => 'phpdeveloperdelhi01@gmail.com',
            //     'replyToName'  => 'Prajapati',
            //     'to'           => 'phpdeveloperdelhi01@gmail.com',
            //     'subject'      => 'test',
            //     'message'      => 'test email'
            //  ];
             
            //  if ($this->email->sendEmail($config)) {
            //      echo "Email sent successfully"; die();
            //  } else {
            //     // Email sending failed
            //     echo "Email sending failed"; 
            //     echo $this->email->printDebugger(['headers']);
            //     die();
            //  }

            echo admin_template('\Admin','\subhome\view_subhome', $data);
	}
    

    public function edit_lochome($id='')
        {
        $catID =( $id > 0 ) ? $id : 0 ;
        $headingTitle  = 'Edit Sub Domain Home';
        $where = ['is_fixed'=>'L'];
        $locationRes = getData('wps_meta_tags',$where);
        if($catID>0){
            $rowdata = $this->HomeModel->gethomebyid($catID);
            if (!is_object($rowdata)) {
                session()->setFlashdata('error', 'Invalid Record!');
                return redirect()->to(admin_url('subhomecontent'));
            }
        }
        
            $data = [
                'title' => 'Edit Sub Domain Home - '.SITENAME,
                'heading' => $headingTitle,
                'PageRes' => json_decode(json_encode($rowdata), true), 
                'locationRes' =>json_decode(json_encode($locationRes), true),  
            ];
            if($this->request->getPost('action')=='edit'){
                    $validation  = $this->validate([
                        'page_heading' => [
                            'label' => 'page_heading',
                            'rules' => 'trim|required|max_length[50]',
                            'errors' => [
                                'required' => 'The {field} field is required.',
                                'max_length' => 'The {field} field must not exceed {param} characters.',
                                'is_unique' => 'The {field} already exists. Please choose a different title.'
                            ]
                        ]
                    ]);
                    if(!$validation)
                    { 
                        $data['validation'] = $this->validator;
                    } else{

                        $posted_size_id = $this->request->getPost('locations');
                        $posted_size_id = !is_array($posted_size_id) ? array() : $posted_size_id;
                        $size_ids = implode(",", $posted_size_id);
                        $update_data = [
                            'page_heading'=> $this->request->getPost('page_heading'),
                            'location_id' => $size_ids,
                            'short_description'=>$this->request->getPost('short_description'),
                            'description'=>$this->request->getPost('description'),
                            'description2'=>$this->request->getPost('description2'),
                            'description3'=>$this->request->getPost('description3'),
                            'meta_title'=>$this->request->getPost('metaTitle'),
                            'meta_description'=>$this->request->getPost('metaDescription'),
                            'meta_keyword'=>$this->request->getPost('metaKeyword'),
                        ];  
                        $this->HomeModel->updatehome($update_data,$catID);
                        session()->setFlashdata('success', 'Record has been Updated successfully!');
                        return redirect()->to(admin_url('subhomecontent'));
                    }   
            }
            echo admin_template('\Admin','\subhome\edit_subhome', $data);
        }
}
