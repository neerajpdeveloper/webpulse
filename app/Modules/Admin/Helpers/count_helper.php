<?php
 $this->db = db_connect();
if (!function_exists('cat_count')) {
  function cat_count($catid = '') {
    $this->db->table('wps_categories')->where('parent_id',$catid); $cat_count = $builder->countAllResults(); // Category Count
    return $cat_count; 
  }

}


?>