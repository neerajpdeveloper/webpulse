<?php namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\EnquiryModel;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Enquiry extends Controller
{
    private $enquiryModel;
    private $db;

    public function __construct()
    {
        $this->enquiryModel = new EnquiryModel();
        $this->db = db_connect();
    }

    public function index($id='')
	{ 
        $parentID = ( $id > 0 ) ? $id : 0 ;
        $enq_count = $this->enquiryModel->getrecord($parentID);
        $condtion_array = [
            'type'=>$parentID,
        ];
        if($parentID==0){
            session()->setFlashdata('error', 'Invalid Url!');
            return redirect()->back();
        }
       // delete Enquiry and meta info 
       if ($this->request->getPost('status_action') == 'Delete') {
        $prod_id = $this->request->getPost('arr_ids');
        if (!is_array($prod_id) || empty($prod_id) || !ctype_digit(implode('', $prod_id))) {
            session()->setFlashdata('error', 'Please Select Enquiry.');
            return redirect()->back();
        }
        foreach ($prod_id as $v) {
          $this->enquiryModel->delete($v);
          session()->setFlashdata('success', 'Enquiry Has been deleted Successfully!');
          return redirect()->back();
        }
      }
   if($parentID==2){
    $headingTitle = "Manage Email Subscription Enquiry";
    $data =[
        'title' => 'Manage Enquiry Admin - '.SITENAME,
        'heading' => $headingTitle,  
        'enqcount' => $enq_count,                                                                                                                                                                                                                 
        'enquiry_res' =>$this->enquiryModel->where($condtion_array)->paginate(10),
        'pager' => $this->enquiryModel->pager,
    ];
    echo admin_template('\Admin','\enquiry\view_subscription_list', $data);
   } else if($parentID==3){ 
    $headingTitle = "Manage Whatsapp Enquiry";
    $data =[
        'title' => 'Manage Enquiry Admin - '.SITENAME,
        'heading' => $headingTitle,  
        'enqcount' => $enq_count,                                                                                                                                                                                                                 
        'enquiry_res' =>$this->enquiryModel->where($condtion_array)->paginate(10),
        'pager' => $this->enquiryModel->pager,
    ];
    echo admin_template('\Admin','\enquiry\view_whatsapp_list', $data);
   } else{
    $headingTitle = "Manage Enquiry";
    $data =[
        'title' => 'Manage Enquiry Admin - '.SITENAME,
        'heading' => $headingTitle,  
        'enqcount' =>$enq_count,                                                                                                                                                                                                                 
        'enquiry_res' =>$this->enquiryModel->where($condtion_array)->paginate(10),
        'pager' => $this->enquiryModel->pager,
    ];
    echo admin_template('\Admin','enquiry\view_enquiry_list', $data);
   }
	}

    
    public function details($id='')
	{

        $backurl = $_SERVER['HTTP_REFERER'];
        $single_enq = get_object_vars(get_single_row('wps_enquiry',$id,'id'));
        $data =[
            'title' => 'Admin - '.SITENAME,
            'heading' => 'Read Enquiry' ,
            'enq' => $single_enq,
            'back_url' => $backurl
        ];
        $update_data = [
            'seen_status'=> 'Y',
        ]; 
        $this->enquiryModel->updateenq($update_data,$id);
        echo admin_template('\Admin','\enquiry\view_productenq_details', $data);
    }

    // Controller method for downloading leads in Excel format
public function downloadLeads($leadId = null)
{
    // Load the leads model
    $this->load->model('leads_model');

    // Retrieve the leads data from the database
    if ($leadId) {
        // If a lead ID is provided, download only that lead
        $leads = $this->leads_model->getLeadById($leadId);
    } else {
        // If no lead ID is provided, download all leads
        $leads = $this->leads_model->getAllLeads();
    }

    // Load the PHPExcel library (assuming it has been installed via Composer)
    require_once(APPPATH.'vendor/autoload.php');

    // Create a new Excel workbook
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add the leads data to the worksheet
    $sheet->setCellValue('A1', 'Lead ID');
    $sheet->setCellValue('B1', 'Lead Name');
    $sheet->setCellValue('C1', 'Lead Email');
    $row = 2;
    foreach ($leads as $lead) {
        $sheet->setCellValue('A'.$row, $lead->id);
        $sheet->setCellValue('B'.$row, $lead->name);
        $sheet->setCellValue('C'.$row, $lead->email);
        $row++;
    }

    // Set the filename and headers for the download
    $filename = 'leads.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    // Output the Excel file to the browser
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
}


}