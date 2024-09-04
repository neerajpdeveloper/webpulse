<?php namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\ProductModel;
use App\Modules\Admin\Models\ProductMediaModel;
use App\Modules\Admin\Models\MetaModel;
use CodeIgniter\Controller;

class Product extends Controller
{
    private $ProductModel;
    private $ProductMediaModel;
    private $metaModel;


    public function __construct()
    {
        $this->ProductModel = new ProductModel();
        $this->ProductMediaModel = new ProductMediaModel();
        $this->metaModel = new MetaModel();
        helper('Product/cat');
    }

    public function index($id='')
	{ 
        $parentID = ( $id > 0 ) ? $id : '';
        $headingTitle  = 'Manage Product';
        if($parentID!=''){
            $condtion_array = "FIND_IN_SET('" . $parentID . "',category_id) AND category_id!=''";
            $prores = $this->ProductModel->where($condtion_array)->paginate(10);
            $procount = $this->ProductModel->getproductnum($condtion_array);
        }
        else{
            $condtion_array = null;
            $prores = $this->ProductModel->paginate(10);
            $procount = $this->ProductModel->getproductnum($condtion_array);
        }
        
        // delete Product and meta info 
            if ($this->request->getPost('status_action') == 'Delete') {
              $prod_id = $this->request->getPost('arr_ids');
              if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
                session()->setFlashdata('error', 'Please Select Product.');
                return redirect()->back();
            }
              session()->setFlashdata('success', 'Product Has been deleted Successfully!');
              foreach ($prod_id as $v) {
                $where = array('entity_type' => 'Products::details', 'entity_id' => $v);
                $this->metaModel->safe_delete($where);
                $this->ProductModel->delete($v);
              }
            }
            // Deactivate Product
            if ($this->request->getPost('status_action') == 'Deactivate') {
                $prod_id = $this->request->getPost('arr_ids');
                if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
                    session()->setFlashdata('error', 'Please Select Product.');
                    return redirect()->back();
                }
                session()->setFlashdata('success', 'Record Has been Updated Successfully!');
                foreach ($prod_id as $v) {
                    $set = ['status'=>'0'];
                    $where = array('products_id' => $v);
                    safe_update('wps_products',$set, $where, TRUE);
                }
              }
              // Activate Product
              if ($this->request->getPost('status_action') == 'Activate') {
                $prod_id = $this->request->getPost('arr_ids');
                if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
                    session()->setFlashdata('error', 'Please Select Product.');
                    return redirect()->back();
                }
                session()->setFlashdata('success', 'Record Has been Updated Successfully!');
                foreach ($prod_id as $v) {
                    $set = ['status'=>'1'];
                    $where = array('products_id' => $v);
                    safe_update('wps_products',$set, $where);
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
                    $where = "products_id=$key";
                    update_displayOrder('wps_products', $data, $where, TRUE);
                  }
              }
              session()->setFlashdata('success', 'Record Has been Updated Successfully!');
            }
        $data =[
                'title' => 'Manage Product Admin - '.SITENAME,
                'heading' => $headingTitle,                                                                              
                'pronum' => $procount,                                                                                                                                         
                'productRes' => $prores,
                'pager' => $this->ProductModel->pager,
            ];
            echo admin_template('\Admin','\product\view_product_list', $data);
	}
    
    public function add_product($id='')
	{ 
        $parentID = ( $id > 0 ) ? $id : 0 ;
        $size = $color = $brand = [];
        $headingTitle  = 'Add New Product';
        $color = getDatabaseData('wps_colors');
        $size = getDatabaseData('wps_sizes');
        $brand = getDatabaseData('wps_brands');
        if($parentID>0){
        $parentdata = $this->ProductModel->getproductbyid($parentID);
        if (!is_object($parentdata)) {
            session()->setFlashdata('error', 'Invalid Record!');
            return redirect()->to(admin_url('manage-product'));
        }
    }
        $data =[
            'title' => 'Add New Product - '.SITENAME,
            'heading' => $headingTitle,
            'parentID' => $parentID,
            'colorRes' => $color,
            'sizeRes' => $size,
            'brandRes' => $brand
        ];
        if($this->request->getPost('action')=='save'){
            $validation  = $this->validate([
                'product_name' => 'trim|required|max_length[1000]|is_unique[wps_products.product_name]',
                'product_name_p' => 'trim|required|max_length[1000]',
                'category_id'  => 'required',
                'product_code' => 'trim|required|max_length[20]|is_unique[wps_products.product_code]',
                'product_qty' => 'trim|required|max_length[20]|numeric',
                'product_price' => 'trim|required|max_length[20]|numeric',
                'product_discountprice' => 'trim|required|max_length[20]|numeric',
                'productshortdesc' => 'trim|required|max_length[500]',
                'productfulldesc' => 'trim|required|max_length[2000]',
                'productspecification' => 'trim|required|max_length[2000]',
                'productmetatitle' => 'trim|required|max_length[100]',
                'productmetakeyword' => 'trim|required|max_length[500]',
                'productmetadescription' => 'trim|required|max_length[500]'
                ]);
                if(!$validation)
                { 
                    $data['validation'] = $this->validator;
                } else{
                    
                    $newname = '';
                    if ($this->request->getFile('proimg') != '') {
                        if (!is_dir(ROOTPATH.UPLOAD_DIR.'product')) {mkdir(ROOTPATH.UPLOAD_DIR.'product');}
                        $filecateImage = $this->request->getFile('proimg');
                        $extension = $filecateImage->getExtension();
                        $newname = str_replace(' ','_',strtolower($this->request->getPost('product_name'))).'.'.$extension;
                        $filecateImage->move(UPLOAD_DIR.'product',$newname);
                      }
                      $newname1 = '';
                      if ($this->request->getFile('featureimg') != '') {
                        if (!is_dir(ROOTPATH.UPLOAD_DIR.'product/feature')) { mkdir(ROOTPATH.UPLOAD_DIR.'product/feature');}
                                $filecateImage = $this->request->getFile('featureimg');
                                $extension = $filecateImage->getExtension();
                                $newname1 = str_replace(' ','_',strtolower($this->request->getPost('product_name'))).'feature'.'.'.$extension;
                                $filecateImage->move(UPLOAD_DIR.'product/feature',$newname1);
                       }
                       $newname2 = '';
                       if ($this->request->getFile('sizechartimg') != '') {
                        if (!is_dir(ROOTPATH.UPLOAD_DIR.'product/sizechart')) { mkdir(ROOTPATH.UPLOAD_DIR.'product/sizechart');}
                                $filecateImage = $this->request->getFile('sizechartimg');
                                $extension = $filecateImage->getExtension();
                                $newname2 = str_replace(' ','_',strtolower($this->request->getPost('product_name'))).'sizechart'.'.'.$extension;
                                $filecateImage->move(UPLOAD_DIR.'product/sizechart',$newname2);
                       }

                             //size
      $posted_size_id = $this->request->getPost('size');
      $posted_size_id = !is_array($posted_size_id) ? array() : $posted_size_id;
      $size_ids = implode(",", $posted_size_id);
      //color
      $posted_color_id = $this->request->getPost('color');
      $posted_color_id = !is_array($posted_color_id) ? array() : $posted_color_id;
      $color_ids = implode(",", $posted_color_id);
      //brand
      $posted_brand_id = $this->request->getPost('brand');
      $posted_brand_id = !is_array($posted_brand_id) ? array() : $posted_brand_id;
      $brand_ids = implode(",", $posted_brand_id);

                    $url_title = seo_friendly_url($this->request->getPost('product_name')); 
                    $redirect_url = 'Product::details';
                    $post_data = [
                        'product_name'=> $this->request->getPost('product_name'),
                        'product_name_p' => $this->request->getPost('product_name_p'),
                        'category_id'  => implode(',' , $this->request->getPost('category_id')),
                        'friendly_url' => $url_title,
                        'youtube_id' => $this->request->getPost('youtube_id'),
                        'product_code' => $this->request->getPost('product_code'),
                        'product_qty' => $this->request->getPost('product_qty'),
                        'product_price' => $this->request->getPost('product_price'),
                        'product_discounted_price' => $this->request->getPost('product_discountprice'),
                        'short_desc' =>$this->request->getPost('productshortdesc'),
                        'products_description' => $this->request->getPost('productfulldesc'),
                        'specification' => $this->request->getPost('productspecification'),
                        'brand_ids' => $brand_ids,
                        'color_ids' => $color_ids,
                        'size_ids' => $size_ids,
                        'product_img' => $newname,
                        'feature_img' => $newname1,
                        'size_chart' => $newname2
                    ]; 
                    $this->ProductModel->save($post_data);
                    $insertId = $this->ProductModel->db->insertID();
                    $meta_data = [
                        'entity_type' => $redirect_url,
                        'entity_id' => $insertId,
                        'page_url' => $url_title,
                        'meta_title' => $this->request->getPost('productmetatitle'),
                        'meta_description' => $this->request->getPost('productmetadescription'),
                        'meta_keyword' => $this->request->getPost('productmetakeyword')
                    ];
                    $this->metaModel->save($meta_data);

                    $multi_img_name = '';
                    if ($this->request->getFiles()['multipimg']) {
                     if (!is_dir(ROOTPATH.UPLOAD_DIR.'product/multi_img')) { mkdir(ROOTPATH.UPLOAD_DIR.'product/multi_img');}
                     $multiimg = $this->request->getFiles()['multipimg'];
                     foreach($multiimg as $image) {
                         $multi_img_name =$image->getRandomName();
                         $image->move(UPLOAD_DIR.'product/multi_img',$multi_img_name);
                         $media_data =[
                             'products_id' => $insertId,
                             'media' => $multi_img_name
                         ];
                         $this->ProductMediaModel->save($media_data);
                     }      
                    } 
                    session()->setFlashdata('success', 'Record has been added successfully!');
                }   
        }
            echo admin_template('\Admin','\product\add_product', $data);
	}


    public function edit_Product($id='')
        {
        $catID =( $id > 0 ) ? $id : 0 ;
        $headingTitle  = ($catID != '' && $catID > 0) ? 'Edit SubProduct':'Edit Product';
        $color = getDatabaseData('wps_colors');
        $size = getDatabaseData('wps_sizes');
        $brand = getDatabaseData('wps_brands');
        if($catID>0){
            $rowdata = $this->ProductModel->getProductbyid($catID);
            $condition = ['entity_type'=>'Product::details','entity_id'=>$catID];
            $metadata = $this->metaModel->getmetabyid($condition);
            if (!is_object($rowdata)) {
                session()->setFlashdata('error', 'Invalid Record!');
                return redirect()->to(admin_url('manage-Product'));
            }
        }
        $proarr  = json_decode(json_encode($rowdata), true);
            $data = [
                'title' => 'Edit Product - '.SITENAME,
                'heading' => $headingTitle,
                'parentID' =>$catID,
                'proRes' => $proarr,
                'metares' => json_decode(json_encode($metadata), true) ,
                'colorRes' => $color,
                'sizeRes' => $size,
                'brandRes' => $brand
            ];
            if($this->request->getPost('action')=='edit'){
                $validation  = $this->validate([
                    'product_name' => 'trim|required|max_length[1000]',
                    'product_name_p' => 'trim|required|max_length[1000]',
                    'category_id'  => 'required',
                    'product_code' => 'trim|required|max_length[20]',
                    'product_qty' => 'trim|required|max_length[20]|numeric',
                    'product_price' => 'trim|required|max_length[20]|numeric',
                    'product_discountprice' => 'trim|required|max_length[20]|numeric',
                    'productshortdesc' => 'trim|required|max_length[500]',
                    'productfulldesc' => 'trim|required|max_length[2000]',
                    'productspecification' => 'trim|required|max_length[2000]',
                    'productmetatitle' => 'trim|required|max_length[100]',
                    'productmetakeyword' => 'trim|required|max_length[500]',
                    'productmetadescription' => 'trim|required|max_length[500]'
                    ]);
                    if(!$validation)
                    { 
                        $data['validation'] = $this->validator;
                    } else{
    
                        $newname = $proarr['product_img'];
                        if ($this->request->getFile('proimg') != '') {
                            $filecateImage = $this->request->getFile('proimg');
                            $extension = $filecateImage->getExtension();
                            $newname = str_replace(' ','_',strtolower($this->request->getPost('product_name'))).'.'.$extension;
                            $filecateImage->move(UPLOAD_DIR.'product',$newname);
                          }
                          $newname1 = $proarr['feature_img'];
                          if ($this->request->getFile('featureimg') != '') {
                                    $filecateImage = $this->request->getFile('featureimg');
                                    $extension = $filecateImage->getExtension();
                                    $newname1 = str_replace(' ','_',strtolower($this->request->getPost('product_name'))).'feature'.'.'.$extension;
                                    $filecateImage->move(UPLOAD_DIR.'product/feature',$newname1);
                           }
                           $newname2 = $proarr['size_chart'];
                           if ($this->request->getFile('sizechartimg') != '') {
                                    $filecateImage = $this->request->getFile('sizechartimg');
                                    $extension = $filecateImage->getExtension();
                                    $newname2 = str_replace(' ','_',strtolower($this->request->getPost('product_name'))).'sizechart'.'.'.$extension;
                                    $filecateImage->move(UPLOAD_DIR.'product/sizechart',$newname2);
                           }
                            //size
                            $posted_size_id = $this->request->getPost('size');
                            $posted_size_id = !is_array($posted_size_id) ? array() : $posted_size_id;
                            $size_ids = implode(",", $posted_size_id);
                            //color
                            $posted_color_id = $this->request->getPost('color');
                            $posted_color_id = !is_array($posted_color_id) ? array() : $posted_color_id;
                            $color_ids = implode(",", $posted_color_id);
                            //brand
                            $posted_brand_id = $this->request->getPost('brand');
                            $posted_brand_id = !is_array($posted_brand_id) ? array() : $posted_brand_id;
                            $brand_ids = implode(",", $posted_brand_id);
                      
                        $url_title = seo_friendly_url($this->request->getPost('product_name')); 
                        $redirect_url = 'Product::details';
                        $update_data = [
                            'product_name'=> $this->request->getPost('product_name'),
                            'product_name_p' => $this->request->getPost('product_name_p'),
                            'category_id'  => implode(',' , $this->request->getPost('category_id')),
                            'friendly_url' => $url_title,
                            'youtube_id' => $this->request->getPost('youtube_id'),
                            'product_code' => $this->request->getPost('product_code'),
                            'product_qty' => $this->request->getPost('product_qty'),
                            'product_price' => $this->request->getPost('product_price'),
                            'product_discounted_price' => $this->request->getPost('product_discountprice'),
                            'short_desc' =>$this->request->getPost('productshortdesc'),
                            'products_description' => $this->request->getPost('productfulldesc'),
                            'specification' => $this->request->getPost('productspecification'),
                            'brand_ids' => $brand_ids,
                            'color_ids' => $color_ids,
                            'size_ids' => $size_ids,
                            'product_img' => $newname,
                            'feature_img' => $newname1,
                            'size_chart' => $newname2
                        ]; 
                        
                        $this->ProductModel->updateProduct($update_data,$catID);
                        $meta_data = [
                            'entity_type' => $redirect_url,
                            'page_url' => $url_title,
                            'meta_title' => $this->request->getPost('productmetatitle'),
                            'meta_description' => $this->request->getPost('productmetadescription'),
                            'meta_keyword' => $this->request->getPost('productmetakeyword')
                        ];
                        $condition_array = ['entity_type'=>$redirect_url,'entity_id' =>$catID];
                        $this->metaModel->updatemeta($meta_data,$condition_array);
            
                        session()->setFlashdata('success', 'Record has been Updated successfully!');
                        return redirect()->to(admin_url('manage-product'));
                    }   
            }
            echo admin_template('\Admin','\Product\edit_Product', $data);
        }
}
