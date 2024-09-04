<?php namespace App\Modules\Admin\Models;
use CodeIgniter\Model;

class EnquiryModel extends Model
{
    protected $table = 'wps_enquiry'; 
    protected $primaryKey = 'id';
    protected $allowedFields = ['products_id', 'product_name', 'type', 'email','name','mobile_number','ip','seen_status','message','quantity','post_url','location','status','reply_status','is_verified','receive_date'];

    public function getrecord(int $id)
    {
        $row_count = $this->where(['status'=>'1','type'=>$id])->countAllResults();
        return $row_count;
    }

    public function getlocationbyid(int $catid)
    {
        $query = $this->where('id', $catid)->get();
        return $query->getRow();
    }

    public function updateenq($post_data, $id)
    {
        $this->where('id', $id);
        $this->set($post_data);
        $this->update();
    }
}