<?php
namespace App\Libraries;
use CodeIgniter\Email\Email;

class EmailLibrary extends Email {
   public function sendEmail($config) {
      $this->initialize($config);

      return $this->send();
   }
}
?>