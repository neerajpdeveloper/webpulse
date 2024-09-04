<?php namespace App\Modules\Admin\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'wps_products'; 
    protected $primaryKey = 'products_id';
    protected $allowedFields = ['product_name','product_name_p','product_code','friendly_url','product_price','product_discounted_price','category_id', 'brand_ids', 'size_ids', 'color_ids','youtube_id','product_qty','short_desc','products_description', 'specification','product_img','feature_img','size_chart'];

    public function getproductnum($param)
    {
        if($param!=null){
            $row_count = $this->where($param)->countAllResults();
        }else{
            $row_count = $this->countAllResults();
        }
        return $row_count;
    }                                                                                                                                                                                                                     

    public function getproductbyid(int $id)
    {
        $query = $this->where('products_id',$id)->get();
        return $query->getRow();
    }

    public function updateProduct($post_data, $id)
    {
        $this->where('products_id',$id);
        $this->set($post_data);
        $this->update();
    }
}