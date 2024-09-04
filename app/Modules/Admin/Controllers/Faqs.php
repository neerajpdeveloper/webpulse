<?php namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\FaqsModel;
use App\Modules\Admin\Models\MetaModel;
use CodeIgniter\Controller;

class Faqs extends Controller
{
    private $faqsModel;
    private $metaModel;


    public function __construct()
    {
        $this->faqsModel = new FaqsModel();
        $this->metaModel = new MetaModel();
    }

    public function index($id='')
	{ 
        $catID = ( $id > 0 ) ? $id : 0 ;
        $headingTitle  = ($catID != '' && $catID > 0) ? 'Manage Faqs':'Manage Faqs';
        $condtion_array = [
            'category_id'=>$catID,
        ];
        $cat_count = $this->faqsModel->getfaqsnum($catID);

        // delete Faqs and meta info 
            if ($this->request->getPost('status_action') == 'Delete') {
              $prod_id = $this->request->getPost('arr_ids');
              if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
                session()->setFlashdata('error', 'Please Select Faqs.');
                return redirect()->back();
            }
              session()->setFlashdata('success', 'Faqs Has been deleted Successfully!');
              foreach ($prod_id as $v) {
                $this->faqsModel->delete($v);
              }
            }
            // Deactivate Faqs
            if ($this->request->getPost('status_action') == 'Deactivate') {
                $prod_id = $this->request->getPost('arr_ids');
                if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
                    session()->setFlashdata('error', 'Please Select Faqs.');
                    return redirect()->back();
                }
                session()->setFlashdata('success', 'Record Has been Updated Successfully!');
                foreach ($prod_id as $v) {
                    $set = ['status'=>'0'];
                    $where = array('faq_id' => $v);
                    safe_update('wps_faq',$set, $where, TRUE);
                }
              }
              // Activate Faqs
              if ($this->request->getPost('status_action') == 'Activate') {
                $prod_id = $this->request->getPost('arr_ids');
                if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
                    session()->setFlashdata('error', 'Please Select Faqs.');
                    return redirect()->back();
                }
                session()->setFlashdata('success', 'Record Has been Updated Successfully!');
                foreach ($prod_id as $v) {
                    $set = ['status'=>'1'];
                    $where = array('faq_id' => $v);
                    safe_update('wps_faq',$set, $where);
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
                    $where = "faq_id=$key";
                    update_displayOrder('wps_faq', $data, $where, TRUE);
                  }
              }
              session()->setFlashdata('success', 'Record Has been Updated Successfully!');
            }
        $data =[
                'title' => 'Manage Faqs Admin - '.SITENAME,
                'heading' => $headingTitle,                                                                              
                'catnum' => $cat_count,                                                                                                                                         
                'faqRes' =>$this->faqsModel->where($condtion_array)->paginate(10),
                'parentID' => $catID,
                'pager' => $this->faqsModel->pager,
            ];
            echo admin_template('\Admin','\faqs\view_faqs_list', $data);
	}
    
    public function add_faqs($id='')
	{
        $catID = ( $id > 0 ) ? $id : 0 ;
        $headingTitle  = 'Add Faqs';
        $Faqs_name = $this->request->getPost('FaqsName');
        $data =[
            'title' => 'Add New Faqs - '.SITENAME,
            'heading' => $headingTitle,
            'catid'=> $catID
        ];
        if($this->request->getPost('action')=='save'){
            $validation  = $this->validate([
                'faq_question' => 'trim|required|max_length[500]|is_unique[wps_faq.faq_question]',
                'faq_answer' => 'trim|required|max_length[1000]',
                ]);
                if(!$validation)
                { 
                    $data['validation'] = $this->validator;
                } else{
                    $post_data = [
                        'faq_question'=> $this->request->getPost('faq_question'),
                        'faq_answer'=>$this->request->getPost('faq_answer'),
                        'category_id'=>$catID
                    ]; 
                    $this->faqsModel->save($post_data);
                    session()->setFlashdata('success', 'Record has been added successfully!');
                }   
        }
            echo admin_template('\Admin','\Faqs\add_Faqs', $data);
	}


    public function edit_faqs($id='')
        {
        $catID =( $id > 0 ) ? $id : 0 ;
        $headingTitle  = 'Edit Faqs';
        if($catID>0){
            $rowdata = $this->faqsModel->getFaqsbyid($catID);
            if (!is_object($rowdata)) {
                session()->setFlashdata('error', 'Invalid Record!');
                return redirect()->to(admin_url('manage-faqs'));
            }
        }
        $faqres = json_decode(json_encode($rowdata), true);
            $data = [
                'title' => 'Edit Faqs - '.SITENAME,
                'heading' => $headingTitle,
                'parentID' =>$catID,
                'faqres' => json_decode(json_encode($rowdata), true),
            ];
            if($this->request->getPost('action')=='edit'){
                $validation  = $this->validate([
                    'faq_question' => 'trim|required|max_length[500]',
                    'faq_answer' => 'trim|required|max_length[1000]',
                    ]);
                    if(!$validation)
                    { 
                        $data['validation'] = $this->validator;
                    } else{
                        $update_data = [
                            'faq_question'=> $this->request->getPost('faq_question'),
                            'faq_answer'=>$this->request->getPost('faq_answer'),
                            'category_id'=>$faqres['category_id']
                        ]; 
                        $this->faqsModel->updateFaqs($update_data,$catID);
                        session()->setFlashdata('success', 'Record has been Updated successfully!');
                        return redirect()->to(admin_url('manage-faqs'));
                    }   
            }
            echo admin_template('\Admin','\faqs\edit_faqs', $data);
        }
}
