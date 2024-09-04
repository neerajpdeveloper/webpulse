<?php namespace App\Modules\Admin\Models;

use CodeIgniter\Model;

class SubdomainCategoryModel extends Model
{

    protected $table = 'wps_subcontent'; 
    protected $primaryKey = 'subcontentid';
    protected $allowedFields = ['location_id', 'page_heading','description','description2','description3','short_description','short_description','meta_title','meta_keyword','meta_description'];

    public function getCategorybyid(int $catid)
    {
        $query = $this->where('subcontentid', $catid)->get();
        return $query->getRow();
    }

    public function getcatnum()
    {
        $row_count = $this->countAllResults();
        return $row_count;
    }
 
    public function updatecate($post_data, $category_id)
    {
        $this->where('subcontentid', $category_id);
        $this->set($post_data);
        $this->update();
    }
}