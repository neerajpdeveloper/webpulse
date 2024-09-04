<?php namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\StaticpagesModel;
use App\Modules\Admin\Models\MetaModel;
use CodeIgniter\Controller;

class Staticpages extends Controller
{
    private $PageModel;
    private $metaModel;


    public function __construct()
    {
        $this->PageModel = new StaticpagesModel();
        $this->metaModel = new MetaModel();
    }

    public function index()
	{ 
        $headingTitle  = 'Manage Pages';

        $Pagecount = $this->PageModel->getPagenum();

        // delete category and meta info 
            if ($this->request->getPost('status_action') == 'Delete') {
              $prod_id = $this->request->getPost('arr_ids');
              if(!empty($prod_id)){
              foreach ($prod_id as $v) {
                $where = array('entity_type' => 'Page::index', 'entity_id' => $v);
                $this->metaModel->safe_delete($where);
                $set = ['status'=>'2'];
                $where = array('page_id' => $v);
                 safe_update('wps_cms_pages',$set, $where);
                session()->setFlashdata('success', 'Page Has been deleted Successfully!');
              }
            } else{ 
                session()->setFlashdata('error', 'No Page IDs provided to delete!');  
            }
        }
            // Deactivate category
            if ($this->request->getPost('status_action') == 'Deactivate') {
                $prod_id = $this->request->getPost('arr_ids');
                if(!empty($prod_id)){
                foreach ($prod_id as $v) {
                    $set = ['status'=>'0'];
                    $where = array('page_id' => $v);
                    safe_update('wps_cms_pages',$set, $where, TRUE);
                    session()->setFlashdata('success', 'Record Has been Updated Successfully!');
                }
            } else{ 
                session()->setFlashdata('error', 'No Page IDs provided to Deactivate!');  
            }
              }
              // Activate category
              if ($this->request->getPost('status_action') == 'Activate') {
                $prod_id = $this->request->getPost('arr_ids');
                if(!empty($prod_id)){
                foreach ($prod_id as $v) {
                    $set = ['status'=>'1'];
                    $where = array('page_id' => $v);
                    safe_update('wps_cms_pages',$set, $where);
                    session()->setFlashdata('success', 'Record Has been Updated Successfully!');
                }
            } else{ 
                session()->setFlashdata('error', 'No Page IDs provided to Activate!');  
            }
              }
        $data =[
                'title' => 'Manage Page Admin - '.SITENAME,
                'heading' => $headingTitle,   
                'Pagecount' => $Pagecount,                                                                                                                                                                                                                
                'PageRes' =>$this->PageModel->paginate(10),
                'pager' => $this->PageModel->pager,
            ];
            echo admin_template('\Admin','\staticpage\view_staticpage_list', $data);
	}
    
    public function add_page()
	{
        $headingTitle  = 'Add New Page';
        $category_name = $this->request->getPost('categoryName');
        $data =[
            'title' => 'Add New Page - Admin '.SITENAME,
            'heading' => $headingTitle,
        ];
        if($this->request->getPost('action')=='save'){
            $validation  = $this->validate([
                'page_name' => [
                    'label' => 'Page Name',
                    'rules' => 'trim|required|max_length[50]|is_unique[wps_cms_pages.page_name]',
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
                    if ($this->request->getFile('img') != '') {
                        if (!is_dir(ROOTPATH.UPLOAD_DIR.'page')) { mkdir(ROOTPATH.UPLOAD_DIR.'page');}
                        $filePageImage = $this->request->getFile('img');
                        $extension = $filePageImage->getExtension();
                        $uploadfile_name = str_replace(' ','_',strtolower($this->request->getPost('page_name'))).'.'.$extension;
                        $filePageImage->move(UPLOAD_DIR.'page',$uploadfile_name);
                      }

                    $url_title = seo_friendly_url($this->request->getPost('page_name')); 
                    $redirect_url = $this->request->getPost('method');
                    $post_data = [
                        'page_name'=> $this->request->getPost('page_name'),
                        'method' => $redirect_url,
                        'friendly_url'=> $url_title,
                        'video'=> $this->request->getPost('page_video_id'),
                        'page_short_description'=>$this->request->getPost('page_short_description'),
                        'page_description'=>$this->request->getPost('page_description'),
                        'page_description3'=>$this->request->getPost('page_description2'),
                        'page_description3'=>$this->request->getPost('page_description3'),
                        'image'=> $uploadfile_name
                    ]; 
                    $this->PageModel->save($post_data);
                    $insertId = $this->PageModel->db->insertID();
                    $meta_data = [
                        'entity_type' => $redirect_url,
                        'entity_id' => $insertId,
                        'page_url' => $url_title,
                        'is_fixed' => 'Y',
                        'meta_title' => $this->request->getPost('metaTitle'),
                        'meta_description' => $this->request->getPost('metaDescription'),
                        'meta_keyword' => $this->request->getPost('metaKeyword')
                    ];
                    $this->metaModel->save($meta_data);
                    session()->setFlashdata('success', 'Record has been added successfully!');
                }   
        }
            echo admin_template('\Admin','\staticpage\add_new_page', $data);
	}


    public function edit_page($id='')
        {
        $catID =( $id > 0 ) ? $id : 0 ;
        $headingTitle  = 'Edit Page';
        if($catID>0){
            $rowdata = $this->PageModel->getPagebyid($catID);
            $Pagearr  = json_decode(json_encode($rowdata), true);
            $condition = ['entity_type'=>$Pagearr['method'],'entity_id'=>$catID];
            $metadata = $this->metaModel->getmetabyid($condition);
            if (!is_object($rowdata)) {
                session()->setFlashdata('error', 'Invalid Record!');
                return redirect()->to(admin_url('manage-pages'));
            }
        }
        
            $data = [
                'title' => 'Edit Page - '.SITENAME,
                'heading' => $headingTitle,
                'PageRes' => json_decode(json_encode($rowdata), true),
                'metares' => json_decode(json_encode($metadata), true) 
            ];
            if($this->request->getPost('action')=='edit'){
                    $validation  = $this->validate([
                        'page_name' => [
                            'label' => 'Page Name',
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
                        $uploadfile_name = $Pagearr['image'];
                        $unlink_file = array('source_dir' => "page", 'source_file' => $Pagearr['image']);
                        if ($this->request->getFile('img') != '') {
                            $filecateImage = $this->request->getFile('img');
                            $extension = $filecateImage->getExtension();
                            $uploadfile_name = seo_friendly_url($this->request->getPost('page_name')).'.'.$extension;
                            $filecateImage->move(UPLOAD_DIR.'Page',$uploadfile_name);
                            removeImage($unlink_file);
                          }
                        
                        $url_title = seo_friendly_url($this->request->getPost('page_name')); 
                        $redirect_url = $Pagearr['method'];
                        $update_data = [
                            'page_name'=> $this->request->getPost('page_name'),
                            'friendly_url'=> $url_title,
                            'video'=> $this->request->getPost('page_video_id'),
                            'page_short_description'=>$this->request->getPost('page_short_description'),
                            'page_description'=>$this->request->getPost('page_description'),
                            'page_description3'=>$this->request->getPost('page_description2'),
                            'page_description3'=>$this->request->getPost('page_description3'),
                            'image'=> $uploadfile_name
                        ]; 

                        $this->PageModel->updatePage($update_data,$catID);
                        $meta_data = [
                            'entity_type' => $redirect_url,
                            'page_url' => $url_title,
                            'meta_title' => $this->request->getPost('metaTitle'),
                            'meta_description' => $this->request->getPost('metaDescription'),
                            'meta_keyword' => $this->request->getPost('metaKeyword')
                        ];
                        $condition_array = ['is_fixed'=>'Y','entity_type'=>$redirect_url,'entity_id' =>$catID];
                        $this->metaModel->updatemeta($meta_data,$condition_array);
                        session()->setFlashdata('success', 'Record has been Updated successfully!');
                        return redirect()->to(admin_url('manage-pages'));
                    }   
            }
            echo admin_template('\Admin','\staticpage\edit_page', $data);
        }
}
