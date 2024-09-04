<?php namespace App\Modules\Admin\Models;
use CodeIgniter\Model;

class SizeModel extends Model
{

    protected $table = 'wps_sizes'; 
    protected $primaryKey = 'size_id';
    protected $allowedFields = ['size_name', 'size_date_added','size_date_updated','sort_order'];

    public function getsizebyid(int $catid)
    {
        $query = $this->where('size_id', $catid)->get();
        return $query->getRow();
    }

    public function getsizenum()
    {
        $row_count = $this->countAllResults();
        return $row_count;
    } 

    public function updatesize($post_data, $id)
    {
        $this->where('size_id', $id);
        $this->set($post_data);
        $this->update();
    }
}