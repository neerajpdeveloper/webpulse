<?php namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\SizeModel;
use CodeIgniter\Controller;

class size extends Controller
{
    private $SizeModel;
    public function __construct()
    {
        $this->SizeModel = new SizeModel();
    }

    public function index()
	{ 
        $headingTitle  = 'Manage size';
        $sizecount = $this->SizeModel->getsizenum();
        
        // delete category and meta info 
            if ($this->request->getPost('status_action') == 'Delete') {
              $prod_id = $this->request->getPost('arr_ids');
              if(!empty($prod_id)){
              foreach ($prod_id as $v) {
                $this->SizeModel->delete($v);
                session()->setFlashdata('success', 'size Has been deleted Successfully!');
              }
            } else{ 
                session()->setFlashdata('error', 'No size IDs provided to delete!');  
            }
        }
            // Deactivate category
            if ($this->request->getPost('status_action') == 'Deactivate') {
                $prod_id = $this->request->getPost('arr_ids');
                if(!empty($prod_id)){
                foreach ($prod_id as $v) {
                    $set = ['status'=>'0'];
                    $where = array('size_id' => $v);
                    safe_update('wps_sizes',$set, $where, TRUE);
                    session()->setFlashdata('success', 'Record Has been Updated Successfully!');
                }
            } else{ 
                session()->setFlashdata('error', 'No size IDs provided to Deactivate!');  
            }
              }
              // Activate category
              if ($this->request->getPost('status_action') == 'Activate') {
                $prod_id = $this->request->getPost('arr_ids');
                if(!empty($prod_id)){
                foreach ($prod_id as $v) {
                    $set = ['status'=>'1'];
                    $where = array('size_id' => $v);
                    safe_update('wps_sizes',$set, $where);
                    session()->setFlashdata('success', 'Record Has been Updated Successfully!');
                }
            } else{ 
                session()->setFlashdata('error', 'No size IDs provided to Activate!');  
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
                    $where = "size_id=$key";
                    update_displayOrder('wps_sizes', $data, $where, TRUE);
                  }
              }
              session()->setFlashdata('success', 'Record Has been Updated Successfully!');
            }
        $data =[
                'title' => 'Manage size Admin - '.SITENAME,
                'heading' => $headingTitle,   
                'sizecount' => $sizecount,                                                                                                                                                                                                                
                'sizeRes' =>$this->SizeModel->paginate(10),
                'pager' => $this->SizeModel->pager,
            ];
            echo admin_template('\Admin','\size\view_size_list', $data);
	}
    
    public function add_size()
	{
        $headingTitle  = 'Add New size';
        $data =[
            'title' => 'Add New size - Admin '.SITENAME,
            'heading' => $headingTitle,
        ];
        if($this->request->getPost('action')=='save'){
            $validation  = $this->validate([
                'size_name' => [
                    'label' => 'size Name',
                    'rules' => 'trim|required|max_length[100]|is_unique[wps_sizes.size_name]',
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
                    $post_data = [
                        'size_name'=> $this->request->getPost('size_name'),
                    ]; 
                    $this->SizeModel->save($post_data);
                    session()->setFlashdata('success', 'Record has been added successfully!');
                }   
        }
            echo admin_template('\Admin','\size\add_size', $data);
	}


    public function edit_size($id='')
        {
        $BID = $id;
        $headingTitle  = 'Edit size';
        if($BID>0){
            $rowdata = $this->SizeModel->getsizebyid($BID);
            if (!is_object($rowdata)) {
                session()->setFlashdata('error', 'Invalid Record!');
                return redirect()->to(admin_url('manage-size'));
            }
        }
        $sizearr  = json_decode(json_encode($rowdata), true);
            $data = [
                'title' => 'Edit size - '.SITENAME,
                'heading' => $headingTitle,
                'sizeRes' => $sizearr,
            ];
            if($this->request->getPost('action')=='edit'){
                $validation  = $this->validate([
                    'size_name' => [
                        'label' => 'size Name',
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
                       
                        $update_data = [
                            'size_name'=> $this->request->getPost('size_name')
                        ]; 

                        $this->SizeModel->updatesize($update_data,$BID);
                        session()->setFlashdata('success', 'Record has been Updated successfully!');
                        return redirect()->to(admin_url('manage-size'));
                    }   
            }
            echo admin_template('\Admin','\size\edit_size', $data);
        }
}
