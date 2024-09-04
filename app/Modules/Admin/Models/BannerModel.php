<?php namespace App\Modules\Admin\Models;

use CodeIgniter\Model;

class BannerModel extends Model
{
    protected $table = 'wps_banners'; 
    protected $primaryKey = 'banner_id';
    protected $allowedFields = ['banner_title', 'banner_image','mobile_banner_image','banner_url'];
 
    public function getbannerbyid(int $catid)
    {
        $query = $this->where('banner_id', $catid)->get();
        return $query->getRow();
    }

    public function updatebanner($post_data, $category_id)
    {
        $this->where('banner_id', $category_id);
        $this->set($post_data);
        $this->update();
    }
}