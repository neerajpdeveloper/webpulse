<?php namespace App\Modules\Admin\Models;

use CodeIgniter\Model;

class StaticpagesModel extends Model
{

    protected $table = 'wps_cms_pages'; 
    protected $primaryKey = 'page_id';
    protected $allowedFields = ['parent_id', 'page_name','friendly_url','page_description','page_description2','page_description3','page_short_description','video','image'];

    public function getPagebyid(int $catid)
    {
        $query = $this->where('page_id', $catid)->get();
        return $query->getRow();
    }

    public function getPagenum()
    {
        $row_count = $this->countAllResults();
        return $row_count;
    } 

    public function updatePage($post_data, $category_id)
    {
        $this->where('page_id', $category_id);
        $this->set($post_data);
        $this->update();
    }
}