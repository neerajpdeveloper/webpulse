<?php namespace App\Modules\Admin\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'wps_categories'; 
    protected $primaryKey = 'category_id';
    protected $allowedFields = ['category_name', 'category_name_p', 'friendly_url', 'parent_id', 'category_shortdescription', 'category_description', 'category_image'];

    public function getcategorynum(array $param)
    {
        $row_count = $this->where('parent_id', $param['parent_id'])->countAllResults();
        return $row_count;
    }

    public function getcategorybyid(int $catid)
    {
        $query = $this->where('category_id', $catid)->get();
        return $query->getRow();
    }

    public function updateCategory($post_data, $category_id)
    {
        $this->where('category_id', $category_id);
        $this->set($post_data);
        $this->update();
    }
}