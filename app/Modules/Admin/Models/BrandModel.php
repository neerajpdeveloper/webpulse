<?php namespace App\Modules\Admin\Models;
use CodeIgniter\Model;

class BrandModel extends Model
{

    protected $table = 'wps_brands'; 
    protected $primaryKey = 'brand_id';
    protected $allowedFields = ['brand_name','brand_img','brand_date_added','brand_date_updated','sort_order'];

    public function getbrandbyid(int $catid)
    {
        $query = $this->where('brand_id', $catid)->get();
        return $query->getRow();
    }

    public function getbrandnum()
    {
        $row_count = $this->countAllResults();
        return $row_count;
    } 

    public function updatebrand($post_data, $id)
    {
        $this->where('brand_id', $id);
        $this->set($post_data);
        $this->update();
    }
}