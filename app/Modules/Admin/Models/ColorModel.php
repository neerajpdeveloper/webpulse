<?php namespace App\Modules\Admin\Models;
use CodeIgniter\Model;

class ColorModel extends Model
{

    protected $table = 'wps_colors'; 
    protected $primaryKey = 'color_id';
    protected $allowedFields = ['color_name','color_code','image','color_date_added','color_date_updated','sort_order'];

    public function getcolorbyid(int $id)
    {
        $query = $this->where('color_id', $id)->get();
        return $query->getRow();
    }

    public function getColornum()
    {
        $row_count = $this->countAllResults();
        return $row_count;
    } 

    public function updateColor($post_data, $id)
    {
        $this->where('color_id', $id);
        $this->set($post_data);
        $this->update();
    }
}