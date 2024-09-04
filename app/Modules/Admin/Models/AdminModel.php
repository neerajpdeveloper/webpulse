<?php namespace App\Modules\Admin\Models;
use CodeIgniter\Model;
class AdminModel extends Model
{
    protected $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
    }

    public function verify(array $auth_data)
    {
        $builder = $this->db->table('wps_admin');
        $username = $auth_data['admin_email'];
        $row_count = $builder->select('admin_key')->where(['admin_email' => $username])->countAllResults();
        if ($row_count === 0) {
            return 0; //user does not exsist
        } else {
            return 1; //Admin exsist
    }
}

    public function check_admin_login(array $auth_data) {
        $builder = $this->db->table('wps_admin');
        $username = $auth_data['admin_email'];
        $password = $auth_data['admin_pass'];
        $query = $builder->select()->where(['admin_email' => $username,'admin_password'=>$password])->get();
        $row = $query->getRowArray();
        if($row){
            $sess_arr = array(
                'admin_user' => $row['admin_username'],
                'admin_key' => $row['admin_key'],
                'admin_type' => $row['admin_type'],
                'admin_id' => $row['admin_id'],
                'admin_logged_in' => TRUE
            );
        }else{
            $sess_arr = array(
                'admin_user' => '',
                'admin_key' => '',
                'admin_type' => '',
                'admin_id' => '',
                'admin_logged_in' => false
            );
        }
        return $sess_arr;
        $db->close();
    }

}