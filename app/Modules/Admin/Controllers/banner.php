<?php namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\BannerModel;
use CodeIgniter\Controller;

class Banner extends Controller
{
    private $bannerModel;

    public function __construct()
    {
        $this->bannerModel = new BannerModel();
    }

    public function index($id = '')
    {
        $headingTitle = 'Manage Banners';

         // delete category and meta info 
         if ($this->request->getPost('status_action') == 'Delete') {
            $banners_id = $this->request->getPost('arr_ids');
               if (!empty($banners_id)) {
            foreach ($banners_id as $v) {
              $this->bannerModel->delete($v);
               session()->setFlashdata('success', 'Category Has been deleted Successfully!');
            }
          } else{
            session()->setFlashdata('error', 'No banner IDs provided to delete!');  
          }
        }
          // Deactivate category
          if ($this->request->getPost('status_action') == 'Deactivate') {
              $banners_id = $this->request->getPost('arr_ids');
              if (!empty($banners_id)) {
              foreach ($banners_id as $v) {
                  $set = ['status'=>'0'];
                  $where = array('banner_id' => $v);
                  safe_update('wps_banners',$set, $where, TRUE);
                  session()->setFlashdata('success', 'Record Has been Updated Successfully!');
              }
            } else{
                session()->setFlashdata('error', 'No banner IDs provided to Deactivate!');  
            }
            }
            // Activate category
            if ($this->request->getPost('status_action') == 'Activate') {
              $banners_id = $this->request->getPost('arr_ids');
              if (!empty($banners_id)) {
              foreach ($banners_id as $v) {
                  $set = ['status'=>'1'];
                  $where = array('banner_id' => $v);
                  safe_update('wps_banners',$set, $where);
                  session()->setFlashdata('success', 'Record Has been Updated Successfully!');
                }
            } else{
                session()->setFlashdata('error', 'No banner IDs provided to Activate!');  
            }
            }

        // Handle banner display order update
        if ($this->request->getPost('update_order') != '') {
            $posted_order_data = $this->request->getPost('ord');
            while (list ($key, $val) = each($posted_order_data)) {
              if ($val != '') {
                $val = (int) $val;
                $data = array(
                    'sort_order' => $val
                );
                $where = "banner_id=$key";
                update_displayOrder('wps_banners', $data, $where, TRUE);
              }
              session()->setFlashdata('success', 'Record Has been Updated Successfully!');
          }
    }

        $condtionArray = [];
        $data = [
            'title' => 'Manage Banners - Admin ' . SITENAME,
            'heading' => $headingTitle,
            'bannerRes' => $this->bannerModel->where($condtionArray)->paginate(10),
            'pager' => $this->bannerModel->pager,
        ];
        echo admin_template('\Admin', '\banner\view_banner_list', $data);
    }


       
    public function add_banner()
	{
        $headingTitle  = 'Add New Banner';
        $data =[
            'title' => 'Add New Banner - '.SITENAME,
            'heading' => $headingTitle,
        ];
        if($this->request->getPost('action')=='save'){
            $validation  = $this->validate([
                'banner_title' => 'trim|required|max_length[500]|is_unique[wps_banners.banner_title]',
                'banner_url' => 'trim|required|max_length[500]|',
                ]);
                if(!$validation)
                { $data['validation'] = $this->validator;
                } else{
                      $upload_file_name = '';
                    if ($this->request->getFile('banner_image') != '') {
                        if (!is_dir(ROOTPATH . 'public/upload/banner')) { mkdir(ROOTPATH . 'public/upload/banner');}
                        $file_banner_image = $this->request->getFile('banner_image');
                        $extension = $file_banner_image->getExtension();
                        $upload_file_name = str_replace(' ','_',strtolower($this->request->getPost('banner_title'))).'.'.$extension;
                        $file_banner_image->move('public/upload/banner',$upload_file_name);
                      }
                       $upload_file_name1 = '';
                      if ($this->request->getFile('mobile_banner_image') != '') {
                        if (!is_dir(ROOTPATH . 'public/upload/banner')) { mkdir(ROOTPATH . 'public/upload/banner');}
                                $file_mobile_banner_image = $this->request->getFile('mobile_banner_image');
                                $extension = $file_mobile_banner_image->getExtension();
                                $upload_file_name1 = str_replace(' ','_',strtolower($this->request->getPost('banner_title'))).'-mobile'.'.'.$extension;
                                $file_mobile_banner_image->move('public/upload/banner',$upload_file_name1);
                       }
                    $post_data = [
                        'banner_title'=> $this->request->getPost('banner_title'),
                        'banner_url'=> $this->request->getPost('banner_url'),
                        'banner_image'=> $upload_file_name,
                        'mobile_banner_image'=>$upload_file_name1,
                    ]; 
                    $this->bannerModel->save($post_data);
                    session()->setFlashdata('success', 'Banner has been added successfully!');
                }   
        }
            echo admin_template('\Admin','\banner\add_banner', $data);
	}


    public function edit_banner($id='')
        {
        $catID =( $id > 0 ) ? $id : 0 ;
        $headingTitle  = 'Edit Banner';
        if($catID>0){
            $rowdata = $this->bannerModel->getbannerbyid($catID);
            if (!is_object($rowdata)) {
                session()->setFlashdata('error', 'Invalid Record!');
                return redirect()->to(admin_url('manage-banner'));
            }
        }
        $bannerArr  = json_decode(json_encode($rowdata), true);
            $data = [
                'title' => 'Edit Banner - '.SITENAME,
                'heading' => $headingTitle,
                'bannerRes' => json_decode(json_encode($rowdata), true),
            ];
            if($this->request->getPost('action')=='edit'){
                $validation  = $this->validate([
                    'banner_title' => 'trim|required|max_length[500]',
                    'banner_url' => 'trim|required|max_length[500]|',
                    ]);
                    if(!$validation)
                    { 
                        $data['validation'] = $this->validator;
                    } else{
    
                        $upload_file_name =  $bannerArr['banner_image'];
                        if ($this->request->getFile('banner_image') != '') {
                            if (!is_dir(ROOTPATH . 'public/upload/banner')) { mkdir(ROOTPATH . 'public/upload/banner');}
                            $file_banner_image = $this->request->getFile('banner_image');
                            $extension = $file_banner_image->getExtension();
                            $upload_file_name = str_replace(' ','_',strtolower($this->request->getPost('banner_title'))).'.'.$extension;
                            $file_banner_image->move('public/upload/banner',$upload_file_name);
                          }
                           $upload_file_name1 = $bannerArr['mobile_banner_image'];
                          if ($this->request->getFile('mobile_banner_image') != '') {
                            if (!is_dir(ROOTPATH . 'public/upload/banner')) { mkdir(ROOTPATH . 'public/upload/banner');}
                                    $file_mobile_banner_image = $this->request->getFile('mobile_banner_image');
                                    $extension = $file_mobile_banner_image->getExtension();
                                    $upload_file_name1 = str_replace(' ','_',strtolower($this->request->getPost('banner_title'))).'-mobile'.'.'.$extension;
                                    $file_mobile_banner_image->move('public/upload/banner',$upload_file_name1);
                           }
                        $update_data = [
                            'banner_title'=> $this->request->getPost('banner_title'),
                            'banner_url'=> $this->request->getPost('banner_url'),
                            'banner_image'=> $upload_file_name,
                            'mobile_banner_image'=>$upload_file_name1,
                        ]; 
                        
                        $this->bannerModel->updatebanner($update_data,$catID);
                        session()->setFlashdata('success', 'Record has been Updated successfully!');
                        return redirect()->to(admin_url('manage-banner'));
                    }   
            }
            echo admin_template('\Admin','\banner\edit_banner', $data);
        }
}
