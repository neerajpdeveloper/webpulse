<?php namespace App\Modules\Admin\Models;

use CodeIgniter\Model;

class FaqsModel extends Model
{
    protected $table = 'wps_faq'; 
    protected $primaryKey = 'faq_id';
    protected $allowedFields = ['faq_question','category_id','faq_answer'];

    public function getfaqsnum(int $id)
    {
        $row_count = $this->where(['status'=>'1','category_id'=>$id])->countAllResults();
        return $row_count;
    }

    public function getfaqsbyid(int $catid)
    {
        $query = $this->where('faq_id', $catid)->get();
        return $query->getRow();
    }

    public function updateFaqs($post_data, $id)
    {
        $this->where('faq_id', $id);
        $this->set($post_data);
        $this->update();
    }
}