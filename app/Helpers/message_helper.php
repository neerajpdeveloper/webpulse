<?php
if (! function_exists('print_session_msg')) {
     function print_session_msg() {
        $success_msg = session()->getFlashdata('success');
        $error_msg = session()->getFlashdata('error');
    
        if (!empty($success_msg)) {
           echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' . $success_msg . '
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
session()->unmarkFlashdata($success_msg);
        }
        
    
        if (!empty($error_msg)) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $error_msg . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
          session()->unmarkFlashdata($error_msg);
        }
       
        
    }
}

?>