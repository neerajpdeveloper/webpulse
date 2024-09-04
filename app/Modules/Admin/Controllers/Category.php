<?php namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\CategoryModel;
use App\Modules\Admin\Models\MetaModel;
use CodeIgniter\Controller;

class Category extends Controller
{
    private $categoryModel;
    private $metaModel;


    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->metaModel = new MetaModel();
    }

    public function index($id='')
	{ 
        $parentID = ( $id > 0 ) ? $id : 0 ;
        $headingTitle  = ($parentID != '' && $parentID > 0) ? 'Manage Subcategory':'Manage Category';
        $condtion_array = [
            'parent_id'=>$parentID,
        ];
        $cat_count = $this->categoryModel->getcategorynum($condtion_array);

        // delete category and meta info 
            if ($this->request->getPost('status_action') == 'Delete') {
              $prod_id = $this->request->getPost('arr_ids');
              if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
                session()->setFlashdata('error', 'Please Select Category.');
                return redirect()->back();
            }
              session()->setFlashdata('success', 'Category Has been deleted Successfully!');
              foreach ($prod_id as $v) {
                $where = array('entity_type' => 'Category::index', 'entity_id' => $v);
                $this->metaModel->safe_delete($where);
                $set = ['status'=>'2'];
                $this->categoryModel->delete($v);
              }
            }
            // Deactivate category
            if ($this->request->getPost('status_action') == 'Deactivate') {
                $prod_id = $this->request->getPost('arr_ids');
                if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
                    session()->setFlashdata('error', 'Please Select Category.');
                    return redirect()->back();
                }
                session()->setFlashdata('success', 'Record Has been Updated Successfully!');
                foreach ($prod_id as $v) {
                    $set = ['status'=>'0'];
                    $where = array('category_id' => $v);
                    safe_update('wps_categories',$set, $where, TRUE);
                }
              }
              // Activate category
              if ($this->request->getPost('status_action') == 'Activate') {
                $prod_id = $this->request->getPost('arr_ids');
                if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
                    session()->setFlashdata('error', 'Please Select Category.');
                    return redirect()->back();
                }
                session()->setFlashdata('success', 'Record Has been Updated Successfully!');
                foreach ($prod_id as $v) {
                    $set = ['status'=>'1'];
                    $where = array('category_id' => $v);
                    safe_update('wps_categories',$set, $where);
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
                    $where = "category_id=$key";
                    update_displayOrder('wps_categories', $data, $where, TRUE);
                  }
              }
              session()->setFlashdata('success', 'Record Has been Updated Successfully!');
            }
        $data =[
                'title' => 'Manage Category Admin - '.SITENAME,
                'heading' => $headingTitle,                                                                              
                'catnum' => $cat_count,                                                                                                                                         
                'cat_res' =>$this->categoryModel->where($condtion_array)->paginate(10),
                'parentID' => $parentID,
                'pager' => $this->categoryModel->pager,
            ];
            echo admin_template('\Admin','\category\view_category_list', $data);
	}
    
    public function add_category($id='')
	{
        $parentID = ( $id > 0 ) ? $id : 0 ;
        $headingTitle  = ($parentID != '' && $parentID > 0) ? 'Add Subcategory':'Add category';
        if($parentID>0){
        $parentdata = $this->categoryModel->getcategorybyid($parentID);
        if (!is_object($parentdata)) {
            session()->setFlashdata('error', 'Invalid Record!');
            return redirect()->to(admin_url('manage-category'));
        }
    }
        $category_name = $this->request->getPost('categoryName');
        $data =[
            'title' => 'Add New Category - '.SITENAME,
            'heading' => $headingTitle,
            'parentID' => $parentID
        ];
        if($this->request->getPost('action')=='save'){
            $validation  = $this->validate([
                'categoryName' => 'trim|required|max_length[1000]|is_unique[wps_categories.category_name]',
                'category_name_p' => 'trim|required|max_length[1000]',
                'categoryshortdesc' => 'trim|required|max_length[500]',
                'categoryfulldesc' => 'trim|required|max_length[2000]',
                'metaTitle' => 'trim|required|max_length[100]',
                'metaKeyword' => 'trim|required|max_length[500]',
                'metaDescription' => 'trim|required|max_length[500]'
                ]);
                if(!$validation)
                { 
                    $data['validation'] = $this->validator;
                } else{

                    $newname = '';
                    if ($this->request->getFile('catimg') != '') {
                        if (!is_dir(ROOTPATH . 'public/upload/category')) { mkdir(ROOTPATH . 'public/upload/category');}
                        $filecateImage = $this->request->getFile('catimg');
                        $extension = $filecateImage->getExtension();
                        $newname = str_replace(' ','_',strtolower($this->request->getPost('categoryName'))).'.'.$extension;
                        $filecateImage->move('public/upload/category',$newname);
                      }
                      $newname1 = '';
                      if ($this->request->getFile('featureimg') != '') {
                        if (!is_dir(ROOTPATH . 'public/upload/category/feature')) { mkdir(ROOTPATH . 'public/upload/category/feature');}
                                $filecateImage = $this->request->getFile('featureimg');
                                $extension = $filecateImage->getExtension();
                                $newname1 = str_replace(' ','_',strtolower($this->request->getPost('categoryName'))).'feature'.'.'.$extension;
                                $filecateImage->move('public/upload/category/',$newname);
                       }
                       $newname2 = '';
                       if ($this->request->getFile('bannerimg') != '') {
                        if (!is_dir(ROOTPATH . 'public/upload/category/banner')) { mkdir(ROOTPATH . 'public/upload/category/banner');}
                                $filecateImage = $this->request->getFile('bannerimg');
                                $extension = $filecateImage->getExtension();
                                $newname = str_replace(' ','_',strtolower($this->request->getPost('categoryName'))).'banner'.'.'.$extension;
                                $filecateImage->move('public/upload/category/banner',$newname);
                       }

                    $url_title = seo_friendly_url($this->request->getPost('categoryName')); 
                    $redirect_url = 'Category::index';
                    $post_data = [
                        'category_name'=> $this->request->getPost('categoryName'),
                        'category_name_p'=>$this->request->getPost('category_name_p'),
                        'friendly_url'=> $url_title,
                        'parent_id' => $parentID,
                        'category_shortdescription'=>$this->request->getPost('categoryshortdesc'),
                        'category_description'=>$this->request->getPost('categoryfulldesc'),
                        'category_image'=> $newname,
                        'category_featureimg'=> $newname1,
                        'category_bannerimg'=> $newname2
                    ]; 
                    
                    $this->categoryModel->save($post_data);
                    $insertId = $this->categoryModel->db->insertID();
                    $meta_data = [
                        'entity_type' => $redirect_url,
                        'entity_id' => $insertId,
                        'page_url' => $url_title,
                        'meta_title' => $this->request->getPost('metaTitle'),
                        'meta_description' => $this->request->getPost('metaDescription'),
                        'meta_keyword' => $this->request->getPost('metaKeyword')
                    ];
                    $this->metaModel->save($meta_data);
                    session()->setFlashdata('success', 'Record has been added successfully!');
                }   
        }
            echo admin_template('\Admin','\category\add_category', $data);
	}


    public function edit_category($id='')
        {
        $catID =( $id > 0 ) ? $id : 0 ;
        $headingTitle  = ($catID != '' && $catID > 0) ? 'Edit Subcategory':'Edit category';
        if($catID>0){
            $rowdata = $this->categoryModel->getcategorybyid($catID);
            $condition = ['entity_type'=>'Category::index','entity_id'=>$catID];
            $metadata = $this->metaModel->getmetabyid($condition);
            if (!is_object($rowdata)) {
                session()->setFlashdata('error', 'Invalid Record!');
                return redirect()->to(admin_url('manage-category'));
            }
        }
        $catarr  = json_decode(json_encode($rowdata), true);
            $data = [
                'title' => 'Edit Category - '.SITENAME,
                'heading' => $headingTitle,
                'parentID' =>$catID,
                'catres' => json_decode(json_encode($rowdata), true),
                'metares' => json_decode(json_encode($metadata), true) 
            ];
            if($this->request->getPost('action')=='edit'){
                $validation  = $this->validate([
                    'categoryName' => 'trim|required|max_length[1000]',
                    'category_name_p' => 'trim|required|max_length[1000]',
                    'categoryshortdesc' => 'trim|required|max_length[500]',
                    'categoryfulldesc' => 'trim|required|max_length[2000]',
                    'metaTitle' => 'trim|required|max_length[100]',
                    'metaKeyword' => 'trim|required|max_length[500]',
                    'metaDescription' => 'trim|required|max_length[500]'
                    ]);
                    if(!$validation)
                    { 
                        $data['validation'] = $this->validator;
                    } else{
    
                        $newname = $catarr['category_image'];
                        if ($this->request->getFile('catimg') != '') {
                            if (!is_dir(ROOTPATH . 'public/upload/category')) { mkdir(ROOTPATH . 'public/upload/category');}
                            $filecateImage = $this->request->getFile('catimg');
                            $extension = $filecateImage->getExtension();
                            $newname = str_replace(' ','_',strtolower($this->request->getPost('categoryName'))).'.'.$extension;
                            $filecateImage->move('public/upload/category',$newname);
                          }
                          $newname1 = $catarr['category_featureimg'];
                          if ($this->request->getFile('featureimg') != '') {
                            if (!is_dir(ROOTPATH . 'public/upload/category/feature')) { mkdir(ROOTPATH . 'public/upload/category/feature');}
                                    $filecateImage = $this->request->getFile('featureimg');
                                    $extension = $filecateImage->getExtension();
                                    $newname = str_replace(' ','_',strtolower($this->request->getPost('categoryName'))).'feature'.'.'.$extension;
                                    $filecateImage->move('public/upload/category/',$newname);
                           }
                           $newname2 = $catarr['category_bannerimg'];
                           if ($this->request->getFile('bannerimg') != '') {
                            if (!is_dir(ROOTPATH . 'public/upload/category/banner')) { mkdir(ROOTPATH . 'public/upload/category/banner');}
                                    $filecateImage = $this->request->getFile('bannerimg');
                                    $extension = $filecateImage->getExtension();
                                    $newname = str_replace(' ','_',strtolower($this->request->getPost('categoryName'))).'banner'.'.'.$extension;
                                    $filecateImage->move('public/upload/category/banner',$newname);
                           }
    
                        $url_title = seo_friendly_url($this->request->getPost('categoryName')); 
                        $redirect_url = 'Category::index';
                        $update_data = [
                            'category_name'=> $this->request->getPost('categoryName'),
                            'category_name_p'=>$this->request->getPost('category_name_p'),
                            'friendly_url'=> $url_title,
                            'category_shortdescription'=>$this->request->getPost('categoryshortdesc'),
                            'category_description'=>$this->request->getPost('categoryfulldesc'),
                            'category_image'=> $newname,
                            'category_featureimg'=> $newname1,
                            'category_bannerimg'=> $newname2
                        ]; 
                        
                        $this->categoryModel->updateCategory($update_data,$catID);
                        $meta_data = [
                            'entity_type' => $redirect_url,
                            'page_url' => $url_title,
                            'meta_title' => $this->request->getPost('metaTitle'),
                            'meta_description' => $this->request->getPost('metaDescription'),
                            'meta_keyword' => $this->request->getPost('metaKeyword')
                        ];
                        $condition_array = ['entity_type'=>$redirect_url,'entity_id' =>$catID];
                        $this->metaModel->updatemeta($meta_data,$condition_array);
                        session()->setFlashdata('success', 'Record has been Updated successfully!');
                        return redirect()->to(admin_url('manage-category'));
                    }   
            }
            echo admin_template('\Admin','\category\edit_category', $data);
        }
}
