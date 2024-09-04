<?php 
namespace App\Modules\Admin\Controllers;
use App\Modules\Admin\Models\AdminModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
    private $adminModel;
    public function __construct(){
         $this->adminModel = new AdminModel();
}

    public function index()
	{
        $sess = session();
        $sess->start();
        if (isset($_SESSION['admin_loged_in']) and $_SESSION['admin_loged_in'] != NULL) {
            return redirect()->to(admin_url('dashboard'));
        } else {
            $data =['title'=>'Admin Login '.SITENAME];
            return view('App\Modules\Admin\Views\login\login', $data);
        }
	}


    public function auth()
	{
            if($this->request->getPost('action')=='login'){
                $session = session();
                $validation  = $this->validate([
                'username' => 'trim|required',
                'password' => 'trim|required',
                ]);
                if(!$validation)
                { 
                  return view('App\Modules\Admin\Views\login\login',['validation'=>$this->validator]);
                } else{
                    $username = $this->request->getPost('username');
                    $password = $this->request->getPost('password');
                    $auth_data = array(
                        'admin_email' => $username,
                        'admin_pass' => $password
                    );
                    $val = $this->adminModel->verify($auth_data);
                    if($val == 1){
                        $session->start();
                        $session->setFlashdata('auth', '1');
                        $admin_result = $this->adminModel->check_admin_login($auth_data);
                        if($admin_result['admin_key'])
                        {
                            $session->start();
                            $session->setFlashdata('auth', '1');
                            $session->set('admin_loged_in', $admin_result);
                            return redirect()->to(admin_url('dashboard'));
                        } else {
                            $session->start();
                            $session->setFlashdata('auth', '0');
                            $session->setFlashdata('error', 'Password Not Match!');
                            return redirect()->to(admin_url());
                        }
                        $cookie = create_jwt($user_id);
                        $session->set('session-id', $cookie);
                    }
                    else {
                        $session->start();
                        $session->setFlashdata('auth', '0');
                        $session->setFlashdata('error', 'Admin Not Exist !');
                        return redirect()->to(admin_url());
                    }
                }
            } else {
                return redirect()->to(admin_url());
            }

	}

    public function logout()
    {
        $sess = session();
        $sess->destroy();
        return redirect()->to(admin_url());
    }
}

