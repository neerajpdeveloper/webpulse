<?php namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\LocationModel;
use App\Modules\Admin\Models\MetaModel;
use CodeIgniter\Controller;

class Location extends Controller
{
    private $locationModel;
    private $metaModel;
    private $db;

    public function __construct()
    {
        $this->locationModel = new LocationModel();
        $this->metaModel = new MetaModel();
        $this->db = db_connect();
    }

    public function index($id='')
	{ 
        $parentID = ( $id > 0 ) ? $id : 0 ;
        $headingTitle  = 'Manage Location';
        $loc_count = $this->locationModel->getrecord($parentID);

       // delete Location and meta info 
       if ($this->request->getPost('status_action') == 'Delete') {
        $prod_id = $this->request->getPost('arr_ids');
        if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
            session()->setFlashdata('error', 'Please Select Location.');
            return redirect()->back();
        }
        foreach ($prod_id as $v) {
          $where = array('entity_type' => 'Home::index', 'entity_id' => $v);
          $this->metaModel->safe_delete($where);
          $this->locationModel->delete($v);
          session()->setFlashdata('success', 'Location Has been deleted Successfully!');
          return redirect()->back();
        }
      }
      // Deactivate location 
      if ($this->request->getPost('status_action') == 'Deactivate') {
          $prod_id = $this->request->getPost('arr_ids');
          if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
            session()->setFlashdata('error', 'Please Select Location.');
            return redirect()->back();
        }
          foreach ($prod_id as $v) {
              $set = ['status'=>'0'];
              $where = array('location_id' => $v);
              safe_update('wps_location',$set, $where, TRUE);
              session()->setFlashdata('success', 'Record Has been Updated Successfully!');
          }
        }
        // Activate location
        if ($this->request->getPost('status_action') == 'Activate') {
          $prod_id = $this->request->getPost('arr_ids');
          if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
            session()->setFlashdata('error', 'Please Select Location.');
            return redirect()->back();
        }
          foreach ($prod_id as $v) {
              $set = ['status'=>'1'];
              $where = array('location_id' => $v);
              safe_update('wps_location',$set, $where);
              session()->setFlashdata('success', 'Record Has been Updated Successfully!');
          }
        }
        $condtion_array = [
            'parent_id'=>$parentID,
        ];
        $data =[
                'title' => 'Manage Location Admin - '.SITENAME,
                'heading' => $headingTitle,  
                'loccount' =>$loc_count,                                                                                                                                                                                                                 
                'location_res' =>$this->locationModel->where($condtion_array)->paginate(10),
                'pager' => $this->locationModel->pager,
            ];
            echo admin_template('\Admin','\location\view_list', $data);
	}

    public function state($id='')
	{ 
        $parentID = ( $id > 0 ) ? $id : 0 ;
        $headingTitle  = 'Manage State List';
        $loc_count = $this->locationModel->getrecord($parentID);
        if($parentID>0){
            $rowdata = $this->locationModel->getlocationbyid($parentID);
            if (!is_object($rowdata)) {
                session()->setFlashdata('error', 'Invalid Record!');
                return redirect()->to(admin_url('manage-location'));
            }
        }
         // delete Location and meta info 
       if ($this->request->getPost('status_action') == 'Delete') {
        $prod_id = $this->request->getPost('arr_ids');
        if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
            session()->setFlashdata('error', 'Please Select Location.');
            return redirect()->back();
        }
        foreach ($prod_id as $v) {
          $where = array('entity_type' => 'Home::index', 'entity_id' => $v);
          $this->metaModel->safe_delete($where);
          $this->locationModel->delete($v);
          session()->setFlashdata('success', 'Location Has been deleted Successfully!');
        }
      }
      // Deactivate location 
      if ($this->request->getPost('status_action') == 'Deactivate') {
          $prod_id = $this->request->getPost('arr_ids');
          if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
            session()->setFlashdata('error', 'Please Select Location.');
            return redirect()->back();
        }
          foreach ($prod_id as $v) {
              $set = ['status'=>'0'];
              $where = array('location_id' => $v);
              safe_update('wps_location',$set, $where, TRUE);
              session()->setFlashdata('success', 'Record Has been Updated Successfully!');
          }
        }
        // Activate location
        if ($this->request->getPost('status_action') == 'Activate') {
          $prod_id = $this->request->getPost('arr_ids');
          if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
            session()->setFlashdata('error', 'Please Select Location.');
            return redirect()->back();
        }
          foreach ($prod_id as $v) {
              $set = ['status'=>'1'];
              $where = array('location_id' => $v);
              safe_update('wps_location',$set, $where);
              session()->setFlashdata('success', 'Record Has been Updated Successfully!');
          }
        }

        $condtion_array = [
            'parent_id'=>$parentID,
        ];
        $data =[
                'title' => 'Manage State Admin - '.SITENAME,
                'heading' => $headingTitle, 
                'parent_id'=> $parentID, 
                'loccount' =>$loc_count,                                                                                                                                                                                                                 
                'location_res' =>$this->locationModel->where($condtion_array)->paginate(10),
                'pager' => $this->locationModel->pager,
            ];
            echo admin_template('\Admin','\location\view_state_list', $data);
	}

    public function city($id='')
	{ 
        $parentID = ( $id > 0 ) ? $id : 0 ;
        $headingTitle  = 'Manage City List';
        $loc_count = $this->locationModel->getrecord($parentID);
        if($parentID>0){
            $rowdata = $this->locationModel->getlocationbyid($parentID);
            if (!is_object($rowdata)) {
                session()->setFlashdata('error', 'Invalid Record!');
                return redirect()->to(admin_url('manage-location'));
            }
        }
         // delete Location and meta info 
       if ($this->request->getPost('status_action') == 'Delete') {
        $prod_id = $this->request->getPost('arr_ids');
        if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
            session()->setFlashdata('error', 'Please Select Location.');
            return redirect()->back();
        }
        foreach ($prod_id as $v) {
          $where = array('entity_type' => 'Home::index', 'entity_id' => $v);
          $this->metaModel->safe_delete($where);
          $this->locationModel->delete($v);
          session()->setFlashdata('success', 'Location Has been deleted Successfully!');
        }
      }
      // Deactivate location 
      if ($this->request->getPost('status_action') == 'Deactivate') {
          $prod_id = $this->request->getPost('arr_ids');
          if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
            session()->setFlashdata('error', 'Please Select Location.');
            return redirect()->back();
        }
          foreach ($prod_id as $v) {
              $set = ['status'=>'0'];
              $where = array('location_id' => $v);
              safe_update('wps_location',$set, $where, TRUE);
              session()->setFlashdata('success', 'Record Has been Updated Successfully!');
          }
        }
        // Activate location
        if ($this->request->getPost('status_action') == 'Activate') {
          $prod_id = $this->request->getPost('arr_ids');
          if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
            session()->setFlashdata('error', 'Please Select Location.');
            return redirect()->back();
        }
          foreach ($prod_id as $v) {
              $set = ['status'=>'1'];
              $where = array('location_id' => $v);
              safe_update('wps_location',$set, $where);
              session()->setFlashdata('success', 'Record Has been Updated Successfully!');
          }
        }
 

        $condtion_array = [
            'parent_id'=> $parentID,
        ];
        $data =[
                'title' => 'Manage City Admin - '.SITENAME,
                'heading' => $headingTitle, 
                'parent_id'=> $parentID, 
                'loccount' =>$loc_count,                                                                                                                                                                                                                 
                'location_res' =>$this->locationModel->where($condtion_array)->paginate(10),
                'pager' => $this->locationModel->pager,
            ];
            echo admin_template('\Admin','\location\view_city_list', $data);
	}
    
    public function add_country()
	{
        $parentID =  0 ;
        $headingTitle  = 'Add Country';
 
        $data =[
            'title' => 'Add New Country - '.SITENAME,
            'heading' => $headingTitle,
        ];
        if($this->request->getPost('action')=='save'){
            $validation  = $this->validate([
                'country_name' => 'trim|required|max_length[100]|is_unique[wps_location.location_name]',
                'country_name_p' => 'trim|required|max_length[100]',
            ],['country_name' => [
                'required' => 'The Country Name field is required.',
                'max_length' => 'The Country Name field must not exceed 100 characters.',
                'is_unique' => 'The Country Name field must be unique.'
            ],
            'country_name_p' => [
                'required' => 'The Country Display Name field is required.',
                'max_length' => 'The Country Display Name field must not exceed 100 characters.'
            ]
            ]
            );
                if(!$validation)
                { 
                    $data['validation'] = $this->validator;
                } else{

                    $url_title = seo_friendly_url($this->request->getPost('country_name')); 
                    $redirect_url = 'Home::index';
                    $post_data = [
                        'location_name'=> $this->request->getPost('country_name'),
                        'location_display'=>$this->request->getPost('country_name_p'),
                        'page_url'=> $url_title,
                        'parent_id' => $parentID,
                    ]; 
                    
                    $this->locationModel->save($post_data);
                    $insertId = $this->locationModel->db->insertID();
                    $meta_data = [
                        'entity_type' => $redirect_url,
                        'entity_id' => $insertId,
                        'is_fixed' => 'L',
                        'page_url' => $url_title,
                        'meta_title' => $this->request->getPost('country_name'),
                        'meta_description' => $this->request->getPost('country_name'),
                        'meta_keyword' => $this->request->getPost('country_name')
                    ];
                    $this->metaModel->save($meta_data);
                    session()->setFlashdata('success', 'Record has been added successfully!');
                }   
        }
            echo admin_template('\Admin','\location\add_country',$data);
	}


    public function edit_country($id='')
        {
        $catID = ( $id > 0 ) ? $id : 0 ;
        $headingTitle  = ($catID != '' && $catID > 0) ? 'Edit Country':'Edit Country';
        if($catID>0){
            $rowdata = $this->locationModel->getlocationbyid($catID);
            if (!is_object($rowdata)) {
                session()->setFlashdata('error', 'Invalid Record!');
                return redirect()->to(admin_url('manage-location'));
            }
        }
        $res_arr  = json_decode(json_encode($rowdata), true);
            $data = [
                'title' => 'Edit Country - '.SITENAME,
                'heading' => $headingTitle,
                'parentID' =>$catID,
                'res_arr' => json_decode(json_encode($rowdata), true),
            ];
            if($this->request->getPost('action')=='edit'){
                $validation  = $this->validate([
                    'country_name' => 'trim|required|max_length[100]',
                    'country_name_p' => 'trim|required|max_length[100]',
                    ],['country_name' => [
                        'required' => 'The Country Name field is required.',
                        'max_length' => 'The Country Name field must not exceed 100 characters.'
                    ],
                    'country_name_p' => [
                        'required' => 'The Country Display Name field is required.',
                        'max_length' => 'The Country Display Name field must not exceed 100 characters.'
                    ]]);
                    if(!$validation)
                    { 
                        $data['validation'] = $this->validator;
                    } else{
    
                        $url_title = seo_friendly_url($this->request->getPost('country_name')); 
                        $redirect_url = 'Home::index';
                        $update_data = [
                            'location_name'=> $this->request->getPost('country_name'),
                            'location_display'=>$this->request->getPost('country_name_p'),
                            'page_url'=> $url_title,
                        ]; 
                        
                        $this->locationModel->updatelocation($update_data,$catID);
                        $meta_data = [
                            'entity_type' => $redirect_url,
                            'page_url' => $url_title,
                            'meta_title' => $this->request->getPost('country_name'),
                            'meta_description' => $this->request->getPost('country_name'),
                            'meta_keyword' => $this->request->getPost('country_name')
                        ];
                        $condition_array = ['is_fixed' => 'L','entity_type'=>$redirect_url,'entity_id' =>$catID];
                        $this->metaModel->updatemeta($meta_data,$condition_array);
                        session()->setFlashdata('success', 'Record has been Updated successfully!');
                        return redirect()->to(admin_url('manage-location'));
                    }   
            }
            echo admin_template('\Admin','\location\edit_country', $data);
        }

        public function add_state($id='')
	{
        $parentID =   ( $id > 0 ) ? $id : 0 ;
        $headingTitle  = 'Add state';
        if($parentID>0){
            $rowdata = $this->locationModel->getlocationbyid($parentID);
            if (!is_object($rowdata)) {
                session()->setFlashdata('error', 'Invalid Record!');
                return redirect()->to(admin_url('manage-location'));
            }
        }
        $data =[
            'title' => 'Add New state - '.SITENAME,
            'heading' => $headingTitle,
            'parent_id' => $parentID,
        ];
        if($this->request->getPost('action')=='save'){
            $validation  = $this->validate([
                'state_name' => 'trim|required|max_length[100]|is_unique[wps_location.location_name]',
                'state_name_p' => 'trim|required|max_length[100]',
                ], [
                    'state_name' => [
                        'required' => 'The State Name field is required.',
                        'max_length' => 'The State Name field must not exceed 100 characters.',
                        'is_unique' => 'The State Name field must be unique.'
                    ],
                    'state_name_p' => [
                        'required' => 'The State Display Name field is required.',
                        'max_length' => 'The State Display Name field must not exceed 100 characters.'
                    ]
                ]);
                if(!$validation)
                { 
                    $data['validation'] = $this->validator;
                } else{

                    $url_title = seo_friendly_url($this->request->getPost('state_name')); 
                    $redirect_url = 'Home::index';
                    $post_data = [
                        'location_name'=> $this->request->getPost('state_name'),
                        'location_display'=>$this->request->getPost('state_name_p'),
                        'page_url'=> $url_title,
                        'parent_id' => $parentID,
                    ]; 
                    
                    $this->locationModel->save($post_data);
                    $insertId = $this->locationModel->db->insertID();
                    $meta_data = [
                        'is_fixed'=> 'L',
                        'entity_type' => $redirect_url,
                        'entity_id' => $insertId,
                        'page_url' => $url_title,
                        'meta_title' => $this->request->getPost('state_name'),
                        'meta_description' => $this->request->getPost('state_name'),
                        'meta_keyword' => $this->request->getPost('state_name')
                    ];
                    $this->metaModel->save($meta_data);
                    session()->setFlashdata('success', 'Record has been added successfully!');
                }   
        }
            echo admin_template('\Admin','\location\add_state',$data);
	}

    public function edit_state($id='')
    {
    $ID = ( $id > 0 ) ? $id : 0 ;
    $headingTitle  = ($ID != '' && $ID > 0) ? 'Edit State':'Edit State';
    if($ID>0){
        $rowdata = $this->locationModel->getlocationbyid($ID);
        if (!is_object($rowdata)) {
            session()->setFlashdata('error', 'Invalid Record!');
            return redirect()->to(admin_url('manage-location'));
        }
    }
    $res_arr  = json_decode(json_encode($rowdata), true);
        $data = [
            'title' => 'Edit State - '.SITENAME,
            'heading' => $headingTitle,
            'parentID' =>$ID,
            'res_arr' => json_decode(json_encode($rowdata), true),
        ];
        if($this->request->getPost('action')=='edit'){
            $validation  = $this->validate([
                'state_name' => 'trim|required|max_length[100]',
                'state_name_p' => 'trim|required|max_length[100]',
                ]);
                if(!$validation)
                { 
                    $data['validation'] = $this->validator;
                } else{

                    $url_title = seo_friendly_url($this->request->getPost('state_name')); 
                    $redirect_url = 'Home::index';
                    $update_data = [
                        'location_name'=> $this->request->getPost('state_name'),
                        'location_display'=>$this->request->getPost('state_name_p'),
                        'page_url'=> $url_title,
                    ]; 
                    
                    $this->locationModel->updatelocation($update_data,$ID);
                    $meta_data = [
                        'entity_type' => $redirect_url,
                        'page_url' => $url_title,
                        'meta_title' => $this->request->getPost('state_name'),
                        'meta_description' => $this->request->getPost('state_name'),
                        'meta_keyword' => $this->request->getPost('state_name')
                    ];
                    $condition_array = ['is_fixed' =>'L','entity_type'=>$redirect_url,'entity_id' =>$ID];
                    $this->metaModel->updatemeta($meta_data,$condition_array);
                    session()->setFlashdata('success', 'Record has been Updated successfully!');
                    return redirect()->to(admin_url('manage-location/state/'.$res_arr['parent_id']));
                }   
        }
        echo admin_template('\Admin','\location\edit_state', $data);
    }
    
    public function add_city($id='')
	{
        $parentID =   ( $id > 0 ) ? $id : 0 ;
        $headingTitle  = 'Add City';
        if($parentID>0){
            $rowdata = $this->locationModel->getlocationbyid($parentID);
            if (!is_object($rowdata)) {
                session()->setFlashdata('error', 'Invalid Record!');
                return redirect()->to(admin_url('manage-location'));
            }
        }
        $data =[
            'title' => 'Add New City - '.SITENAME,
            'heading' => $headingTitle,
            'parent_id' => $parentID,
        ];
        if($this->request->getPost('action')=='save'){
            $validation  = $this->validate([
                'city_name' => 'trim|required|max_length[100]|is_unique[wps_location.location_name]',
                'city_name_p' => 'trim|required|max_length[100]',
                ]);
                if(!$validation)
                { 
                    $data['validation'] = $this->validator;
                } else{

                    $url_title = seo_friendly_url($this->request->getPost('city_name')); 
                    $redirect_url = 'Home::index';
                    $post_data = [
                        'location_name'=> $this->request->getPost('city_name'),
                        'location_display'=>$this->request->getPost('city_name_p'),
                        'page_url'=> $url_title,
                        'parent_id' => $parentID,
                    ]; 
                    
                    $this->locationModel->save($post_data);
                    $insertId = $this->locationModel->db->insertID();
                    $meta_data = [
                        'is_fixed'=> 'L',
                        'entity_type' => $redirect_url,
                        'entity_id' => $insertId,
                        'page_url' => $url_title,
                        'meta_title' => $this->request->getPost('city_name'),
                        'meta_description' => $this->request->getPost('city_name'),
                        'meta_keyword' => $this->request->getPost('city_name')
                    ];
                    $this->metaModel->save($meta_data);
                    session()->setFlashdata('success', 'Record has been added successfully!');
                }   
        }
            echo admin_template('\Admin','\location\add_city',$data);
	}

    public function edit_city($id='')
    {
    $ID = ( $id > 0 ) ? $id : 0 ;
    $headingTitle  = ($ID != '' && $ID > 0) ? 'Edit City':'Edit City';
    if($ID>0){
        $rowdata = $this->locationModel->getlocationbyid($ID);
        if (!is_object($rowdata)) {
            session()->setFlashdata('error', 'Invalid Record!');
            return redirect()->to(admin_url('manage-location'));
        }
    }
    $res_arr  = json_decode(json_encode($rowdata), true);
        $data = [
            'title' => 'Edit City - '.SITENAME,
            'heading' => $headingTitle,
            'parentID' =>$ID,
            'res_arr' => json_decode(json_encode($rowdata), true),
        ];
        if($this->request->getPost('action')=='edit'){
            $validation  = $this->validate([
                'city_name' => 'trim|required|max_length[100]',
                'city_name_p' => 'trim|required|max_length[100]',
                ]);
                if(!$validation)
                { 
                    $data['validation'] = $this->validator;
                } else{

                    $url_title = seo_friendly_url($this->request->getPost('city_name')); 
                    $redirect_url = 'Home::index';
                    $update_data = [
                        'location_name'=> $this->request->getPost('city_name'),
                        'location_display'=>$this->request->getPost('city_name_p'),
                        'page_url'=> $url_title,
                    ]; 
                    
                    $this->locationModel->updatelocation($update_data,$ID);
                    $meta_data = [
                        'entity_type' => $redirect_url,
                        'page_url' => $url_title,
                        'meta_title' => $this->request->getPost('city_name'),
                        'meta_description' => $this->request->getPost('city_name'),
                        'meta_keyword' => $this->request->getPost('city_name')
                    ];
                    $condition_array = ['is_fixed' =>'L','entity_type'=>$redirect_url,'entity_id' =>$ID];
                    $this->metaModel->updatemeta($meta_data,$condition_array);
                    session()->setFlashdata('success', 'Record has been Updated successfully!');
                    return redirect()->to(admin_url('manage-location/city/'.$res_arr['parent_id']));
                }   
        }
        echo admin_template('\Admin','\location\edit_city', $data);
    }
}
