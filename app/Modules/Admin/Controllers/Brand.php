<?php namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\BrandModel;
use CodeIgniter\Controller;

class Brand extends Controller
{
    private $BrandModel;
    public function __construct()
    {
        $this->BrandModel = new BrandModel();
    }

    public function index()
	{ 
        $headingTitle  = 'Manage Brand';
        $Brandcount = $this->BrandModel->getBrandnum();
        
        // delete category and meta info 
            if ($this->request->getPost('status_action') == 'Delete') {
              $prod_id = $this->request->getPost('arr_ids');
              if(!empty($prod_id)){
              foreach ($prod_id as $v) {
                $this->BrandModel->delete($v);
                session()->setFlashdata('success', 'Brand Has been deleted Successfully!');
              }
            } else{ 
                session()->setFlashdata('error', 'No Brand IDs provided to delete!');  
            }
        }
            // Deactivate category
            if ($this->request->getPost('status_action') == 'Deactivate') {
                $prod_id = $this->request->getPost('arr_ids');
                if(!empty($prod_id)){
                foreach ($prod_id as $v) {
                    $set = ['status'=>'0'];
                    $where = array('brand_id' => $v);
                    safe_update('wps_brands',$set, $where, TRUE);
                    session()->setFlashdata('success', 'Record Has been Updated Successfully!');
                }
            } else{ 
                session()->setFlashdata('error', 'No Brand IDs provided to Deactivate!');  
            }
              }
              // Activate category
              if ($this->request->getPost('status_action') == 'Activate') {
                $prod_id = $this->request->getPost('arr_ids');
                if(!empty($prod_id)){
                foreach ($prod_id as $v) {
                    $set = ['status'=>'1'];
                    $where = array('brand_id' => $v);
                    safe_update('wps_brands',$set, $where);
                    session()->setFlashdata('success', 'Record Has been Updated Successfully!');
                }
            } else{ 
                session()->setFlashdata('error', 'No Brand IDs provided to Activate!');  
            }
              }
                // updateorder
              if ($this->request->getPost('update_order') != '') {
                $posted_order_data = $this->request->getPost('ord');
                while (list ($key, $val) = each($posted_order_data)) {
                  if ($val != '') {
                    $val = (int) $val;
                    $data = array(
                        'sort_order' => $val
                    );
                    $where = "brand_id=$key";
                    update_displayOrder('wps_brands', $data, $where, TRUE);
                  }
              }
              session()->setFlashdata('success', 'Record Has been Updated Successfully!');
            }
        $data =[
                'title' => 'Manage Brand Admin - '.SITENAME,
                'heading' => $headingTitle,   
                'Brandcount' => $Brandcount,                                                                                                                                                                                                                
                'BrandRes' =>$this->BrandModel->paginate(10),
                'pager' => $this->BrandModel->pager,
            ];
            echo admin_template('\Admin','\brand\view_brand_list', $data);
	}
    
    public function add_brand()
	{
        $headingTitle  = 'Add New Brand';
        $data =[
            'title' => 'Add New Brand - Admin '.SITENAME,
            'heading' => $headingTitle,
        ];
        if($this->request->getPost('action')=='save'){
            $validation  = $this->validate([
                'brand_name' => [
                    'label' => 'Brand Name',
                    'rules' => 'trim|required|max_length[100]|is_unique[wps_brands.brand_name]',
                    'errors' => [
                        'required' => 'The {field} field is required.',
                        'max_length' => 'The {field} field must not exceed {param} characters.',
                        'is_unique' => 'The {field} already exists. Please choose a different title.'
                    ]
                ],
            ]);
                if(!$validation)
                { 
                    $data['validation'] = $this->validator;
                } else{
                    $uploadfile_name = '';
                    if ($this->request->getFile('brandimg') != '') {
                        if (!is_dir(ROOTPATH.UPLOAD_DIR.'brand')) { mkdir(ROOTPATH.UPLOAD_DIR.'brand');}
                        $fileBrandImage = $this->request->getFile('brandimg');
                        $extension = $fileBrandImage->getExtension();
                        $uploadfile_name = str_replace(' ','_',strtolower($this->request->getPost('brand_name'))).'.'.$extension;
                        $fileBrandImage->move(UPLOAD_DIR.'brand',$uploadfile_name);
                      }

                    $post_data = [
                        'brand_name'=> $this->request->getPost('brand_name'),
                        'brand_img'=> $uploadfile_name
                    ]; 
                    $this->BrandModel->save($post_data);
                    session()->setFlashdata('success', 'Record has been added successfully!');
                }   
        }
            echo admin_template('\Admin','\brand\add_brand', $data);
	}


    public function edit_brand($id='')
        {
        $BID = $id;
        $headingTitle  = 'Edit Brand';
        if($BID>0){
            $rowdata = $this->BrandModel->getbrandbyid($BID);
            if (!is_object($rowdata)) {
                session()->setFlashdata('error', 'Invalid Record!');
                return redirect()->to(admin_url('manage-Brand'));
            }
        }
        $Brandarr  = json_decode(json_encode($rowdata), true);
            $data = [
                'title' => 'Edit Brand - '.SITENAME,
                'heading' => $headingTitle,
                'BrandRes' => $Brandarr,
            ];
            if($this->request->getPost('action')=='edit'){
                $validation  = $this->validate([
                    'brand_name' => [
                        'label' => 'Brand Name',
                        'rules' => 'trim|required|max_length[100]',
                        'errors' => [
                            'required' => 'The {field} field is required.',
                            'max_length' => 'The {field} field must not exceed {param} characters.',
                            'is_unique' => 'The {field} already exists. Please choose a different title.'
                        ]
                    ],
                ]);
                    if(!$validation)
                    { 
                        $data['validation'] = $this->validator;
                    } else{
                        $uploadfile_name = $Brandarr['brand_img'];
                        $unlink_file = array('source_dir' => "brand", 'source_file' => $Brandarr['brand_img']);
                        if ($this->request->getFile('brandimg') != '') {
                            $filecateImage = $this->request->getFile('brandimg');
                            $extension = $filecateImage->getExtension();
                            $uploadfile_name = seo_friendly_url($this->request->getPost('brand_name')).'.'.$extension;
                            $filecateImage->move(UPLOAD_DIR.'brand',$uploadfile_name);
                            removeImage($unlink_file);
                          }
                        
                        $update_data = [
                            'brand_name'=> $this->request->getPost('brand_name'),
                            'brand_img'=> $uploadfile_name
                        ]; 

                        $this->BrandModel->updatebrand($update_data,$BID);
                        session()->setFlashdata('success', 'Record has been Updated successfully!');
                        return redirect()->to(admin_url('manage-brand'));
                    }   
            }
            echo admin_template('\Admin','\brand\edit_brand', $data);
        }
}
