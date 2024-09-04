<?php namespace App\Modules\Admin\Models;

use CodeIgniter\Model;

class SubdomainHomeModel extends Model
{

    protected $table = 'wps_subloccontent'; 
    protected $primaryKey = 'subcontentid';
    protected $allowedFields = ['location_id', 'page_heading','description','description2','description3','short_description','short_description','meta_title','meta_keyword','meta_description'];

    public function gethomebyid(int $catid)
    {
        $query = $this->where('subcontentid', $catid)->get();
        return $query->getRow();
    }

    public function updatehome($post_data, $category_id)
    {
        $this->where('subcontentid', $category_id);
        $this->set($post_data);
        $this->update();
    }
}