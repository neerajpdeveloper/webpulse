<?php namespace App\Modules\Admin\Models;

use CodeIgniter\Model;

class BlogModel extends Model
{

    protected $table = 'wps_blog'; 
    protected $primaryKey = 'article_id';
    protected $allowedFields = ['article_title', 'display_title','friendly_url','blog_author','short_desc','article_desc','article_image'];

    public function getblogbyid(int $catid)
    {
        $query = $this->where('article_id', $catid)->get();
        return $query->getRow();
    }

    public function getblognum()
    {
        $row_count = $this->countAllResults();
        return $row_count;
    } 

    public function updateblog($post_data, $category_id)
    {
        $this->where('article_id', $category_id);
        $this->set($post_data);
        $this->update();
    }
}