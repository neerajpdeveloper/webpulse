<?php namespace App\Modules\Admin\Models;

use CodeIgniter\Model;

class LocationModel extends Model
{
    protected $table = 'wps_location'; 
    protected $primaryKey = 'location_id';
    protected $allowedFields = ['location_name', 'location_display', 'page_url', 'parent_id'];

    public function getrecord(int $id)
    {
        $row_count = $this->where(['status'=>'1','parent_id'=>$id])->countAllResults();
        return $row_count;
    }

    public function getlocationbyid(int $catid)
    {
        $query = $this->where('location_id', $catid)->get();
        return $query->getRow();
    }

    public function updatelocation($post_data, $id)
    {
        $this->where('location_id', $id);
        $this->set($post_data);
        $this->update();
    }
}