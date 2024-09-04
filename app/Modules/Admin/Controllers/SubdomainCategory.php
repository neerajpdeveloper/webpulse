<?php namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\SubdomainCategoryModel;
use CodeIgniter\Controller;

class SubdomainCategory extends Controller
{
    private $CategoryModel;
    public function __construct()
    {
        $this->CategoryModel = new SubdomainCategoryModel();
    }

    public function index()
	{ 
        $headingTitle  = 'Manage Sub Domain Category';
        $data =[
                'title' => 'Manage Sub Domain Category | Admin - '.SITENAME,
                'heading' => $headingTitle,                                                                                                                                                                                                              
                'PageRes' =>$this->CategoryModel->paginate(10),
                'pager' => $this->CategoryModel->pager,
            ];
            echo admin_template('\Admin','\subCategory\view_subCategory', $data);
	}
    

    
    public function add_new(){
        $headingTitle  = 'Add New Sub Domain Category Content';
        $data =[
                'title' => 'Add New Sub Domain Category Content | Admin - '.SITENAME,
                'heading' => $headingTitle,                                                                                                                                                                                                              
                'PageRes' =>$this->CategoryModel->paginate(10),
                'pager' => $this->CategoryModel->pager,
            ];
            echo admin_template('\Admin','\subCategory\view_subCategory', $data);
    }
    public function edit_loccate($id='')
        {
        $catID =  $id;
        $headingTitle  = 'Edit Sub Domain Category';
        $where = ['is_fixed'=>'L'];
        $locationRes = getData('wps_meta_tags',$where);
        if($catID>0){
            $rowdata = $this->CategoryModel->getCategorybyid($catID);
            if (!is_object($rowdata)) {
                session()->setFlashdata('error', 'Invalid Record!');
                return redirect()->to(admin_url('subcontent'));
            }
        }
        
            $data = [
                'title' => 'Edit Sub Domain Category - '.SITENAME,
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
                        $this->CategoryModel->updateCategory($update_data,$catID);
                        session()->setFlashdata('success', 'Record has been Updated successfully!');
                        return redirect()->to(admin_url('subcontent'));
                    }   
            }
            echo admin_template('\Admin','\subCategory\edit_subCategory', $data);
        }
}
