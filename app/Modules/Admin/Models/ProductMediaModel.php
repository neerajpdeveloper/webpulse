<?php namespace App\Modules\Admin\Models;

use CodeIgniter\Model;

class ProductMediaModel extends Model
{
    protected $table = 'wps_products_media'; 
    protected $primaryKey = 'id';
    protected $allowedFields = ['products_id','media_type','media'];

    public function getmedianum(string $param)
    {
        $row_count = $this->where($param)->countAllResults();
        return $row_count;
    }                                                                                                                                                                                                                     

    // public function getproductbyid(int $id)
    // {
    //     $query = $this->where('product_id',$id)->get();
    //     return $query->getRow();
    // }

    // public function updateproduct($post_data, $id)
    // {
    //     $this->where('product_id',$id);
    //     $this->set($post_data);
    //     $this->update();
    // }
}