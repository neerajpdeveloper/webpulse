<?php namespace App\Modules\Admin\Models;

use CodeIgniter\Model;

class TestimonialModel extends Model
{
    protected $table = 'wps_testimonial'; 
    protected $primaryKey = 'testimonial_id';
    protected $allowedFields = ['testimonial_title','testimonial_image','testimonial_description','testimonial_shortdesc','designation','location'];

    public function gettestimonialnum()
    {
        $row_count = $this->where(['status'=>'1'])->countAllResults();
        return $row_count;
    }

    public function gettestimonialbyid(int $catid)
    {
        $query = $this->where('testimonial_id', $catid)->get();
        return $query->getRow();
    }

    public function updatetestimonial($post_data, $id)
    {
        $this->where('testimonial_id', $id);
        $this->set($post_data);
        $this->update();
    }
}