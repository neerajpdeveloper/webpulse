<?php namespace App\Modules\Admin\Models;
use CodeIgniter\Model;
class MetaModel extends Model
{
    protected $db;
    protected $table = 'wps_meta_tags'; 
    protected $primaryKey = 'meta_id';
    protected $allowedFields = ['entity_type', 'is_fixed','entity_id','page_url','parent_id','meta_title','meta_description','meta_keyword'];
    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
    }

    public function getmetabyid(array $param){
            $condition= ['entity_type'=>$param['entity_type'],'entity_id'=>$param['entity_id']];          
            $query = $this->where($condition)->get();
            return $query->getRow();
    }

    public function updatemeta($metadata,$condition)
    {
        $this->where($condition);
        $this->set($metadata);
        $this->update();
    }

    public function safe_delete($condition)
    {
        $this->where($condition);
        // $query = $this->getCompiledDelete();
        // echo $query; // Print the preview of the query
        $this->delete();
    }
}