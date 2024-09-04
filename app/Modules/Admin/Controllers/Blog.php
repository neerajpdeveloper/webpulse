<?php namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\BlogModel;
use App\Modules\Admin\Models\MetaModel;
use CodeIgniter\Controller;

class Blog extends Controller
{
    private $BlogModel;
    private $metaModel;


    public function __construct()
    {
        $this->BlogModel = new BlogModel();
        $this->metaModel = new MetaModel();
    }

    public function index()
	{ 
        $headingTitle  = 'Manage Blog';

        $blogcount = $this->BlogModel->getblognum();

        // delete category and meta info 
            if ($this->request->getPost('status_action') == 'Delete') {
              $prod_id = $this->request->getPost('arr_ids');
              if(!empty($prod_id)){
              foreach ($prod_id as $v) {
                $where = array('entity_type' => 'Blog::index', 'entity_id' => $v);
                $this->metaModel->safe_delete($where);
                $set = ['status'=>'2'];
                $this->BlogModel->delete($v);
                session()->setFlashdata('success', 'Blog Has been deleted Successfully!');
              }
            } else{ 
                session()->setFlashdata('error', 'No Blog IDs provided to delete!');  
            }
        }
            // Deactivate category
            if ($this->request->getPost('status_action') == 'Deactivate') {
                $prod_id = $this->request->getPost('arr_ids');
                if(!empty($prod_id)){
                foreach ($prod_id as $v) {
                    $set = ['status'=>'0'];
                    $where = array('article_id' => $v);
                    safe_update('wps_blog',$set, $where, TRUE);
                    session()->setFlashdata('success', 'Record Has been Updated Successfully!');
                }
            } else{ 
                session()->setFlashdata('error', 'No Blog IDs provided to Deactivate!');  
            }
              }
              // Activate category
              if ($this->request->getPost('status_action') == 'Activate') {
                $prod_id = $this->request->getPost('arr_ids');
                if(!empty($prod_id)){
                foreach ($prod_id as $v) {
                    $set = ['status'=>'1'];
                    $where = array('article_id' => $v);
                    safe_update('wps_blog',$set, $where);
                    session()->setFlashdata('success', 'Record Has been Updated Successfully!');
                }
            } else{ 
                session()->setFlashdata('error', 'No Blog IDs provided to Activate!');  
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
                    $where = "article_id=$key";
                    update_displayOrder('wps_blog', $data, $where, TRUE);
                  }
              }
              session()->setFlashdata('success', 'Record Has been Updated Successfully!');
            }
        $data =[
                'title' => 'Manage Blog Admin - '.SITENAME,
                'heading' => $headingTitle,   
                'blogcount' => $blogcount,                                                                                                                                                                                                                
                'BlogRes' =>$this->BlogModel->paginate(10),
                'pager' => $this->BlogModel->pager,
            ];
            echo admin_template('\Admin','\blog\view_blog_list', $data);
	}
    
    public function add_blog()
	{
        $headingTitle  = 'Add New Blog';
        $category_name = $this->request->getPost('categoryName');
        $data =[
            'title' => 'Add New Blog - Admin '.SITENAME,
            'heading' => $headingTitle,
        ];
        if($this->request->getPost('action')=='save'){
            $validation  = $this->validate([
                'blog_title' => [
                    'label' => 'Blog Title',
                    'rules' => 'trim|required|max_length[150]|is_unique[wps_blog.article_title]',
                    'errors' => [
                        'required' => 'The {field} field is required.',
                        'max_length' => 'The {field} field must not exceed {param} characters.',
                        'is_unique' => 'The {field} already exists. Please choose a different title.'
                    ]
                ],
                'blog_display_title' => [
                    'label' => 'Display Title',
                    'rules' => 'trim|required|max_length[150]',
                    'errors' => [
                        'required' => 'The {field} field is required.',
                        'max_length' => 'The {field} field must not exceed {param} characters.'
                    ]
                ],
                'blogshortdesc' => [
                    'label' => 'Short Description',
                    'rules' => 'trim|required|max_length[250]',
                    'errors' => [
                        'required' => 'The {field} field is required.',
                        'max_length' => 'The {field} field must not exceed {param} characters.'
                    ]
                ],
                'blogfulldesc' => [
                    'label' => 'Full Description',
                    'rules' => 'trim|required|max_length[4000]',
                    'errors' => [
                        'required' => 'The {field} field is required.',
                        'max_length' => 'The {field} field must not exceed {param} characters.'
                    ]
                ],
                'blogmetaTitle' => [
                    'label' => 'Meta Title',
                    'rules' => 'trim|required|max_length[100]',
                    'errors' => [
                        'required' => 'The {field} field is required.',
                        'max_length' => 'The {field} field must not exceed {param} characters.'
                    ]
                ],
                'blogmetaKeyword' => [
                    'label' => 'Meta Keywords',
                    'rules' => 'trim|required|max_length[500]',
                    'errors' => [
                        'required' => 'The {field} field is required.',
                        'max_length' => 'The {field} field must not exceed {param} characters.'
                    ]
                ],
                'blogmetaDescription' => [
                    'label' => 'Meta Description',
                    'rules' => 'trim|required|max_length[500]',
                    'errors' => [
                        'required' => 'The {field} field is required.',
                        'max_length' => 'The {field} field must not exceed {param} characters.'
                    ]
                ]
            ]);
                if(!$validation)
                { 
                    $data['validation'] = $this->validator;
                } else{

                    $uploadfile_name = '';
                    if ($this->request->getFile('blogimg') != '') {
                        if (!is_dir(ROOTPATH.UPLOAD_DIR.'blog')) { mkdir(ROOTPATH.UPLOAD_DIR.'blog');}
                        $fileblogImage = $this->request->getFile('blogimg');
                        $extension = $fileblogImage->getExtension();
                        $uploadfile_name = str_replace(' ','_',strtolower($this->request->getPost('blog_title'))).'.'.$extension;
                        $fileblogImage->move(UPLOAD_DIR.'blog',$uploadfile_name);
                      }

                    $url_title = seo_friendly_url($this->request->getPost('blog_title')); 
                    $redirect_url = 'Blogs::details';
                    $post_data = [
                        'article_title'=> $this->request->getPost('blog_title'),
                        'display_title'=>$this->request->getPost('blog_display_title'),
                        'friendly_url'=> $url_title,
                        'blog_author' => 'Admin',
                        'short_desc'=>$this->request->getPost('blogshortdesc'),
                        'article_desc'=>$this->request->getPost('blogfulldesc'),
                        'article_image'=> $uploadfile_name
                    ]; 
                    // print_r($post_data); die();
                    $this->BlogModel->save($post_data);
                    $insertId = $this->BlogModel->db->insertID();
                    $meta_data = [
                        'entity_type' => $redirect_url,
                        'entity_id' => $insertId,
                        'page_url' => $url_title,
                        'is_fixed' => 'B',
                        'meta_title' => $this->request->getPost('blogmetaTitle'),
                        'meta_description' => $this->request->getPost('blogmetaDescription'),
                        'meta_keyword' => $this->request->getPost('blogmetaKeyword')
                    ];
                    $this->metaModel->save($meta_data);
                    session()->setFlashdata('success', 'Record has been added successfully!');
                }   
        }
            echo admin_template('\Admin','\blog\add_blog', $data);
	}


    public function edit_blog($id='')
        {
        $catID =( $id > 0 ) ? $id : 0 ;
        $headingTitle  = 'Edit Blog';
        if($catID>0){
            $rowdata = $this->BlogModel->getblogbyid($catID);
            $condition = ['entity_type'=>'Blogs::details','entity_id'=>$catID];
            $metadata = $this->metaModel->getmetabyid($condition);
            if (!is_object($rowdata)) {
                session()->setFlashdata('error', 'Invalid Record!');
                return redirect()->to(admin_url('manage-blog'));
            }
        }
        $blogarr  = json_decode(json_encode($rowdata), true);
            $data = [
                'title' => 'Edit Blog - '.SITENAME,
                'heading' => $headingTitle,
                'blogRes' => json_decode(json_encode($rowdata), true),
                'metares' => json_decode(json_encode($metadata), true) 
            ];
            if($this->request->getPost('action')=='edit'){
                $validation  = $this->validate([
                    'blog_title' => [
                        'label' => 'Blog Title',
                        'rules' => 'trim|required|max_length[150]',
                        'errors' => [
                            'required' => 'The {field} field is required.',
                            'max_length' => 'The {field} field must not exceed {param} characters.'
                        ]
                    ],
                    'blog_display_title' => [
                        'label' => 'Display Title',
                        'rules' => 'trim|required|max_length[150]',
                        'errors' => [
                            'required' => 'The {field} field is required.',
                            'max_length' => 'The {field} field must not exceed {param} characters.'
                        ]
                    ],
                    'blogshortdesc' => [
                        'label' => 'Short Description',
                        'rules' => 'trim|required|max_length[250]',
                        'errors' => [
                            'required' => 'The {field} field is required.',
                            'max_length' => 'The {field} field must not exceed {param} characters.'
                        ]
                    ],
                    'blogfulldesc' => [
                        'label' => 'Full Description',
                        'rules' => 'trim|required|max_length[4000]',
                        'errors' => [
                            'required' => 'The {field} field is required.',
                            'max_length' => 'The {field} field must not exceed {param} characters.'
                        ]
                    ],
                    'blogmetaTitle' => [
                        'label' => 'Meta Title',
                        'rules' => 'trim|required|max_length[100]',
                        'errors' => [
                            'required' => 'The {field} field is required.',
                            'max_length' => 'The {field} field must not exceed {param} characters.'
                        ]
                    ],
                    'blogmetaKeyword' => [
                        'label' => 'Meta Keywords',
                        'rules' => 'trim|required|max_length[500]',
                        'errors' => [
                            'required' => 'The {field} field is required.',
                            'max_length' => 'The {field} field must not exceed {param} characters.'
                        ]
                    ],
                    'blogmetaDescription' => [
                        'label' => 'Meta Description',
                        'rules' => 'trim|required|max_length[500]',
                        'errors' => [
                            'required' => 'The {field} field is required.',
                            'max_length' => 'The {field} field must not exceed {param} characters.'
                        ]
                    ]
                ]);
                    if(!$validation)
                    { 
                        $data['validation'] = $this->validator;
                    } else{
                        $uploadfile_name = $blogarr['article_image'];
                        $unlink_file = array('source_dir' => "blog", 'source_file' => $blogarr['article_image']);
                        if ($this->request->getFile('blogimg') != '') {
                            $filecateImage = $this->request->getFile('blogimg');
                            $extension = $filecateImage->getExtension();
                            $uploadfile_name = seo_friendly_url($this->request->getPost('blog_title')).'.'.$extension;
                            $filecateImage->move(UPLOAD_DIR.'blog',$uploadfile_name);
                            removeImage($unlink_file);
                          }
                        
                        $url_title = seo_friendly_url($this->request->getPost('blog_title')); 
                        $redirect_url = 'Blog::details';
                        $update_data = [
                            'article_title'=> $this->request->getPost('blog_title'),
                            'display_title'=>$this->request->getPost('blog_display_title'),
                            'friendly_url'=> $url_title,
                            'blog_author' => 'Admin',
                            'short_desc'=>$this->request->getPost('blogshortdesc'),
                            'article_desc'=>$this->request->getPost('blogfulldesc'),
                            'article_image'=> $uploadfile_name
                        ]; 

                        $this->BlogModel->updateblog($update_data,$catID);
                        $meta_data = [
                            'entity_type' => $redirect_url,
                            'page_url' => $url_title,
                            'meta_title' => $this->request->getPost('blogmetaTitle'),
                            'meta_description' => $this->request->getPost('blogmetaDescription'),
                            'meta_keyword' => $this->request->getPost('blogmetaKeyword')
                        ];
                        $condition_array = ['is_fixed'=>'B','entity_type'=>$redirect_url,'entity_id' =>$catID];
                        $this->metaModel->updatemeta($meta_data,$condition_array);
                        session()->setFlashdata('success', 'Record has been Updated successfully!');
                        return redirect()->to(admin_url('manage-blog'));
                    }   
            }
            echo admin_template('\Admin','\blog\edit_blog', $data);
        }
}
