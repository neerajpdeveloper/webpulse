<?php namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\ColorModel;
use CodeIgniter\Controller;

class Color extends Controller
{
    private $ColorModel;
    public function __construct()
    {
        $this->ColorModel = new ColorModel();
    }

    public function index()
	{ 
        $headingTitle  = 'Manage Color';
        $Colorcount = $this->ColorModel->getColornum();
        // delete category and meta info 
            if ($this->request->getPost('status_action') == 'Delete') {
              $prod_id = $this->request->getPost('arr_ids');
              if(!empty($prod_id)){
              foreach ($prod_id as $v) {
                $this->ColorModel->delete($v);
                session()->setFlashdata('success', 'Color Has been deleted Successfully!');
              }
            } else{ 
                session()->setFlashdata('error', 'No Color IDs provided to delete!');  
            }
        }
            // Deactivate category
            if ($this->request->getPost('status_action') == 'Deactivate') {
                $prod_id = $this->request->getPost('arr_ids');
                if(!empty($prod_id)){
                foreach ($prod_id as $v) {
                    $set = ['status'=>'0'];
                    $where = array('color_id' => $v);
                    safe_update('wps_colors',$set, $where, TRUE);
                    session()->setFlashdata('success', 'Record Has been Updated Successfully!');
                }
            } else{ 
                session()->setFlashdata('error', 'No Color IDs provided to Deactivate!');  
            }
              }
              // Activate category
              if ($this->request->getPost('status_action') == 'Activate') {
                $prod_id = $this->request->getPost('arr_ids');
                if(!empty($prod_id)){
                foreach ($prod_id as $v) {
                    $set = ['status'=>'1'];
                    $where = array('color_id' => $v);
                    safe_update('wps_colors',$set, $where);
                    session()->setFlashdata('success', 'Record Has been Updated Successfully!');
                }
            } else{ 
                session()->setFlashdata('error', 'No Color IDs provided to Activate!');  
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
                    $where = "color_id=$key";
                    update_displayOrder('wps_colors', $data, $where, TRUE);
                  }
              }
              session()->setFlashdata('success', 'Record Has been Updated Successfully!');
            }
        $data =[
                'title' => 'Manage Color Admin - '.SITENAME,
                'heading' => $headingTitle,   
                'Colorcount' => $Colorcount,                                                                                                                                                                                                                
                'ColorRes' =>$this->ColorModel->paginate(10),
                'pager' => $this->ColorModel->pager,
            ];
            echo admin_template('\Admin','\color\view_color_list', $data);
	}
    
    public function add_Color()
	{
        $headingTitle  = 'Add New Color';
        $category_name = $this->request->getPost('categoryName');
        $data =[
            'title' => 'Add New Color - Admin '.SITENAME,
            'heading' => $headingTitle,
        ];
        if($this->request->getPost('action')=='save'){
            $validation  = $this->validate([
                'color_name' => [
                    'label' => 'Color Title',
                    'rules' => 'trim|required|max_length[150]|is_unique[wps_colors.color_name]',
                    'errors' => [
                        'required' => 'The {field} field is required.',
                        'max_length' => 'The {field} field must not exceed {param} characters.',
                        'is_unique' => 'The {field} already exists. Please choose a different title.'
                    ]
                ],
                'color_code' => [
                    'label' => 'Display Title',
                    'rules' => 'trim|required|max_length[150]|is_unique[wps_colors.color_code]',
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

                    $uploadfile_name = '';
                    if ($this->request->getFile('Colorimg') != '') {
                        if (!is_dir(ROOTPATH.UPLOAD_DIR.'colorimage')) { mkdir(ROOTPATH.UPLOAD_DIR.'colorimage');}
                        $fileColorImage = $this->request->getFile('Colorimg');
                        $extension = $fileColorImage->getExtension();
                        $uploadfile_name = str_replace(' ','_',strtolower($this->request->getPost('color_name'))).'.'.$extension;
                        $fileColorImage->move(UPLOAD_DIR.'colorimage',$uploadfile_name);
                      }

                    $post_data = [
                        'color_name'=> $this->request->getPost('color_name'),
                        'color_code'=>$this->request->getPost('color_code'),
                        'image'=> $uploadfile_name
                    ]; 
                    $this->ColorModel->save($post_data);
                    session()->setFlashdata('success', 'Record has been added successfully!');
                }   
        }
            echo admin_template('\Admin','\color\add_color', $data);
	}


    public function edit_color($id='')
        {
        $catID =( $id > 0 ) ? $id : 0 ;
        $headingTitle  = 'Edit Color';
        if($catID>0){
            $rowdata = $this->ColorModel->getcolorbyid($catID);
            if (!is_object($rowdata)) {
                session()->setFlashdata('error', 'Invalid Record!');
                return redirect()->to(admin_url('manage-Color'));
            }
        }
        $Colorarr  = json_decode(json_encode($rowdata), true);
            $data = [
                'title' => 'Edit Color - '.SITENAME,
                'heading' => $headingTitle,
                'ColorRes' => $Colorarr
            ];
            if($this->request->getPost('action')=='edit'){
                $validation  = $this->validate([
                    'color_name' => [
                        'label' => 'Color Title',
                        'rules' => 'trim|required|max_length[150]',
                        'errors' => [
                            'required' => 'The {field} field is required.',
                            'max_length' => 'The {field} field must not exceed {param} characters.',
                            'is_unique' => 'The {field} already exists. Please choose a different title.'
                        ]
                    ],
                    'color_code' => [
                        'label' => 'Display Title',
                        'rules' => 'trim|required|max_length[150]',
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
                        $uploadfile_name = $Colorarr['image'];
                        if ($this->request->getFile('Colorimg') != '') {
                            $fileColorImage = $this->request->getFile('Colorimg');
                            $extension = $fileColorImage->getExtension();
                            $uploadfile_name = str_replace(' ','_',strtolower($this->request->getPost('color_name'))).'.'.$extension;
                            $fileColorImage->move(UPLOAD_DIR.'colorimage',$uploadfile_name);
                          }
    
                        $update_data = [
                            'color_name'=> $this->request->getPost('color_name'),
                            'color_code'=>$this->request->getPost('color_code'),
                            'image'=> $uploadfile_name
                        ]; 
                        $this->ColorModel->updateColor($update_data,$catID);
                        session()->setFlashdata('success', 'Record has been Updated successfully!');
                        return redirect()->to(admin_url('manage-color'));
                    }   
            }
            echo admin_template('\Admin','\color\edit_color', $data);
        }
}
