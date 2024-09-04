<?php namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\TestimonialModel;
use CodeIgniter\Controller;

class Testimonial extends Controller
{
    private $TestimonialModel;
    public function __construct()
    {
        $this->TestimonialModel = new TestimonialModel();
    }

    public function index($id='')
	{ 
        $catID = ( $id > 0 ) ? $id : 0 ;
        $headingTitle  = ($catID != '' && $catID > 0) ? 'Manage Testimonial':'Manage Testimonial';
        $cat_count = $this->TestimonialModel->getTestimonialnum();

        // delete Testimonial and meta info 
            if ($this->request->getPost('status_action') == 'Delete') {
              $prod_id = $this->request->getPost('arr_ids');
              if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
                session()->setFlashdata('error', 'Please Select Testimonial.');
                return redirect()->back();
            }
              session()->setFlashdata('success', 'Testimonial Has been deleted Successfully!');
              foreach ($prod_id as $v) {
                $this->TestimonialModel->delete($v);
              }
            }
            // Deactivate Testimonial
            if ($this->request->getPost('status_action') == 'Deactivate') {
                $prod_id = $this->request->getPost('arr_ids');
                if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
                    session()->setFlashdata('error', 'Please Select Testimonial.');
                    return redirect()->back();
                }
                session()->setFlashdata('success', 'Record Has been Updated Successfully!');
                foreach ($prod_id as $v) {
                    $set = ['status'=>'0'];
                    $where = array('testimonial_id' => $v);
                    safe_update('wps_testimonial',$set, $where, TRUE);
                }
              }
              // Activate Testimonial
              if ($this->request->getPost('status_action') == 'Activate') {
                $prod_id = $this->request->getPost('arr_ids');
                if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
                    session()->setFlashdata('error', 'Please Select Testimonial.');
                    return redirect()->back();
                }
                session()->setFlashdata('success', 'Record Has been Updated Successfully!');
                foreach ($prod_id as $v) {
                    $set = ['status'=>'1'];
                    $where = array('testimonial_id' => $v);
                    safe_update('wps_testimonial',$set, $where);
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
                    $where = "testimonial_id=$key";
                    update_displayOrder('wps_testimonial', $data, $where, TRUE);
                  }
              }
              session()->setFlashdata('success', 'Record Has been Updated Successfully!');
            }
        $data =[
                'title' => 'Manage Testimonial Admin - '.SITENAME,
                'heading' => $headingTitle,                                                                              
                'catnum' => $cat_count,                                                                                                                                         
                'testimonialRes' =>$this->TestimonialModel->paginate(10),
                'parentID' => $catID,
                'pager' => $this->TestimonialModel->pager,
            ];
            echo admin_template('\Admin','\Testimonial\view_Testimonial_list', $data);
	}
    
    public function add_testimonial()
	{
        $headingTitle  = 'Add Testimonial';
        $Testimonial_name = $this->request->getPost('TestimonialName');
        $data =[
            'title' => 'Add New Testimonial - '.SITENAME,
            'heading' => $headingTitle,
        ];
        if($this->request->getPost('action')=='save'){
            $validation  = $this->validate([
                'testimonial_title' => 'trim|required|max_length[500]',
                'designation' => 'trim|required|max_length[100]',
                'testimonial_shortdesc' => 'trim|required|max_length[250]',
                'testimonial_description' => 'trim|required|max_length[500]',
                ]);
                if(!$validation)
                { 
                    $data['validation'] = $this->validator;
                } else{
                    $uploadfile_name = '';
                    if ($this->request->getFile('testimonialimg') != '') {
                        if (!is_dir(ROOTPATH . 'public/upload/testimonial')) { mkdir(ROOTPATH . 'public/upload/testimonial');}
                        $fileImage = $this->request->getFile('testimonialimg');
                        $extension = $fileImage->getExtension();
                        $uploadfile_name = str_replace(' ','_',strtolower($this->request->getPost('testimonial_title'))).'.'.$extension;
                        $fileImage->move('public/upload/testimonial',$uploadfile_name);
                      }
                    $post_data = [
                        'testimonial_title'=> $this->request->getPost('testimonial_title'),
                        'designation'=>$this->request->getPost('designation'),
                        'location'=>$this->request->getPost('location'),
                        'testimonial_shortdesc'=>$this->request->getPost('testimonial_shortdesc'),
                        'testimonial_description'=>$this->request->getPost('testimonial_description'),
                        'testimonial_image' => $uploadfile_name
                    ]; 
                    $this->TestimonialModel->save($post_data);
                    session()->setFlashdata('success', 'Record has been added successfully!');
                }   
        }
            echo admin_template('\Admin','\Testimonial\add_Testimonial', $data);
	}


    public function edit_testimonial($id='')
        {
        $catID =( $id > 0 ) ? $id : 0 ;
        $headingTitle  = 'Edit Testimonial';
        if($catID>0){
            $rowdata = $this->TestimonialModel->getTestimonialbyid($catID);
            if (!is_object($rowdata)) {
                session()->setFlashdata('error', 'Invalid Record!');
                return redirect()->to(admin_url('manage-testimonial'));
            }
        }
        $testimonialres = json_decode(json_encode($rowdata), true);
            $data = [
                'title' => 'Edit Testimonial - '.SITENAME,
                'heading' => $headingTitle,
                'parentID' =>$catID,
                'testimonialres' => json_decode(json_encode($rowdata), true),
            ];
            if($this->request->getPost('action')=='edit'){
                $validation  = $this->validate([
                    'testimonial_title' => 'trim|required|max_length[500]',
                    'designation' => 'trim|required|max_length[100]',
                    'testimonial_shortdesc' => 'trim|required|max_length[250]',
                    'testimonial_description' => 'trim|required|max_length[500]',
                    ]);
                    if(!$validation)
                    { 
                        $data['validation'] = $this->validator;
                    } else{
                        $uploadfile_name =  $testimonialres['testimonial_image'];
                        if ($this->request->getFile('testimonialimg') != '') {
                            if (!is_dir(ROOTPATH . 'public/upload/testimonial')) { mkdir(ROOTPATH . 'public/upload/testimonial');}
                            $fileImage = $this->request->getFile('testimonialimg');
                            $extension = $fileImage->getExtension();
                            $uploadfile_name = str_replace(' ','_',strtolower($this->request->getPost('testimonial_title'))).'.'.$extension;
                            $fileImage->move('public/upload/testimonial',$uploadfile_name);
                          }
                        $update_data = [
                            'testimonial_title'=> $this->request->getPost('testimonial_title'),
                            'designation'=>$this->request->getPost('designation'),
                            'location'=>$this->request->getPost('location'),
                            'testimonial_shortdesc'=>$this->request->getPost('testimonial_shortdesc'),
                            'testimonial_description'=>$this->request->getPost('testimonial_description'),
                            'testimonial_image' => $uploadfile_name
                        ]; 
                        $this->TestimonialModel->updateTestimonial($update_data,$catID);
                        session()->setFlashdata('success', 'Record has been Updated successfully!');
                        return redirect()->to(admin_url('manage-testimonial'));
                    }   
            }
            echo admin_template('\Admin','\Testimonial\edit_Testimonial', $data);
        }
}
