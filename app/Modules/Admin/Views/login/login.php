<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
      <title><?=$title;?></title>
      <meta name="description" content="" />
      <meta name="keywords" content="" />
      <link rel="icon" href="<?=base_url("public/sitepanel/assets/images/favicon.ico")?>" type="image/x-icon" />
      <link href="<?=base_url("public/sitepanel/assets/css/icons.css")?>" rel="stylesheet" type="text/css">
      <link href="<?=base_url("public/sitepanel/assets/css/bootstrap.min.css")?>" rel="stylesheet" type="text/css" />
      <link href="<?=base_url("public/sitepanel/assets/css/date-picker.css")?>" rel="stylesheet" type="text/css">
      <link href="<?=base_url("public/sitepanel/assets/css/style.css")?>" rel="stylesheet" type="text/css">
      <script src="<?=base_url("public/sitepanel/assets/js/jquery.min.js")?>"></script>
   </head>
   <body>
      <div class="admin_login">
         <div class="admin_login_header">
            <div class="shape">
               <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                  <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
               </svg>
            </div>
         </div>
         <div class="container-fluid">
            <div class="login_logo">
               <a href="javascript:void();">
               <img src="<?=base_url("public/sitepanel/assets/images/logo.png")?>">
               </a>
            </div>
            <div class="row justify-content-center">
               <div class="webpulse_container col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                  <div class="admin_login_panel">
                     <div class="webpulse_heading">
                        <h3 class="auth-title">Welcome Back !</h3>
                        <p>Sign in to continue to <?=SITENAME?>.</p>
                     </div>
                     <form name="loginForm" action="<?=base_url('wpsadmin/auth')?>" method="POST">
                        <?=csrf_field();?>
                        <?php if(isset($validation)):?>
                        <div class="alert alert-danger">
                           <?= $validation->listErrors() ?>
                        </div>
                        <?php endif;?>
                        <?php $sess = session();?>
                        <?php if(isset($_SESSION['auth']) and $sess->get('auth') == 0):?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                           <div><?=$sess->get('error');?></div>
                           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <?php endif; ?>
                        <div class="form-group">
                           <label class="input_label">
                           <input type="text" name="username" class="form_input" placeholder="Email *" required>
                           </label>
                        </div>
                        <div class="form-group">
                           <label class="input_label">
                           <input id="password" type="password" name="password" class="form_input" placeholder="Password *" value="" required>
                           <span toggle="#password" class="password_visable"></span>
                           </label>
                        </div>
                        <input type="hidden" name="action" class="form_input" value="login">
                        <div class="form-group">
                           <button class="login_btn" type="submit">Sign In</button>
                        </div>
                        <!-- <div class="forgotPwd">
                           <a href="crm-forgot-password.php">Trouble to <span>Log in</span>?</a>
                           
                           </div> -->
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <footer class="main-footer">
         <div class="col-md-12 col-sm-12 text-center">
            <div class="container-fluid pt-0 ht-100p">
               Copyright ©  2011-<?=date('Y');?> Webpulse Solution Pvt. Ltd. All rights reserved
               <br>
Designed with love by Webpulse Team - Web Designing Company Delhi
            </div>
         </div>
      </footer>
      <script src="<?=base_url("public/sitepanel/assets/js/popper.min.js")?>"></script>
      <script src="<?=base_url("public/sitepanel/assets/js/bootstrap.min.js")?>"></script>
      <script src="<?=base_url("public/sitepanel/assets/js/perfect-scrollbar/perfect-scrollbar.min.js")?>"></script>
      <script src="<?=base_url("public/sitepanel/assets/js/sidemenu.js")?>"></script>
      <script src="<?=base_url("public/sitepanel/assets/js/custom.js")?>"></script>
   </body>
</html>