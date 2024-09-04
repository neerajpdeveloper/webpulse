<?php 
$data = ['seen_status'=>'N'];
$result = getData('wps_enquiry',$data);
?>
<div class="main-header side-header sticky nav nav-item">

    <div class=" main-container container-fluid">

        <div class="main-header-left ">

            <div class="responsive-logo">

                <a href="<?=admin_url('dashboard');?>" class="header-logo">

                    <img src="<?=base_url('public/sitepanel/assets/images/logo1.png');?>" class="mobile-logo logo-1" alt="logo">

                    <img src="<?=base_url('public/sitepanel/assets/images/logo.png');?>" class="mobile-logo dark-logo-1" alt="logo">

                </a>

            </div>

            <div class="app-sidebar__toggle" data-bs-toggle="sidebar">

                <a class="open-toggle" href="javascript:void(0);">

                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="header-icon" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/></svg></a>

                <a class="close-toggle" href="javascript:void(0);">

                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="header-icon" viewBox="0 0 16 16"><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg></a>

            </div>

            <div class="logo-horizontal">

                <a href="<?=admin_url('dashboard');?>" class="header-logo">

                    <img src="<?=base_url('public/sitepanel/assets/images/logo1.png');?>" class="mobile-logo logo-1" alt="logo">

                    <img src="<?=base_url('public/sitepanel/assets/images/logo1.png');?>designer" class="mobile-logo dark-logo-1" alt="logo">

                </a>

            </div>

            <div class="main-header-center ms-4 d-sm-none d-md-none d-lg-block form-group">

               <form>

                <input class="form-control" placeholder="Search..." type="search" name="search" required>

                <button class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg></button>

                </form>

            </div>

        </div>

        <div class="main-header-right">

            <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon fe fe-more-vertical "></span>

            </button>

            <div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0">

                <div class="collapse navbar-collapse" id="navbarSupportedContent-4">

                    <ul class="nav nav-item header-icons navbar-nav-right ms-auto">

                        <li class="dropdown nav-item  main-header-message">

                            <a class="new nav-link" data-bs-toggle="dropdown" href="javascript:void(0);">

                                <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24">

                                    <path d="M20 4H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zm0 2v.511l-8 6.223-8-6.222V6h16zM4 18V9.044l7.386 5.745a.994.994 0 0 0 1.228 0L20 9.044 20.002 18H4z" />

                                </svg>

                                <?php if($result){ ?>
    <span class="badge bg-secondary header-badge"><?=count($result)?></span>
<?php } ?>

                            </a>

                        </li>

                        <li class="dropdown nav-item main-header-notification d-flex">

                            <a class="new nav-link" data-bs-toggle="dropdown" href="javascript:void(0);">

                                <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24">

                                    <path d="M19 13.586V10c0-3.217-2.185-5.927-5.145-6.742C13.562 2.52 12.846 2 12 2s-1.562.52-1.855 1.258C7.185 4.074 5 6.783 5 10v3.586l-1.707 1.707A.996.996 0 0 0 3 16v2a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-2a.996.996 0 0 0-.293-.707L19 13.586zM19 17H5v-.586l1.707-1.707A.996.996 0 0 0 7 14v-4c0-2.757 2.243-5 5-5s5 2.243 5 5v4c0 .266.105.52.293.707L19 16.414V17zm-7 5a2.98 2.98 0 0 0 2.818-2H9.182A2.98 2.98 0 0 0 12 22z" />

                                </svg><span class=" pulse"></span>

                            </a>

                        </li>

                        <li class="nav-link search-icon d-lg-none d-block">

                            <form class="navbar-form" role="search">

                                <div class="input-group">

                                    <input type="text" class="form-control" placeholder="Search">

                                    <span class="input-group-btn">

                                        <button type="reset" class="btn btn-default">

                                            <i class="fas fa-times"></i>

                                        </button>

                                        <button type="submit" class="btn btn-default nav-link resp-btn">

                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" class="header-icon-svgs" viewBox="0 0 24 24" width="24px" fill="#000000">

                                                <path d="M0 0h24v24H0V0z" fill="none" />

                                                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />

                                            </svg>

                                        </button>

                                    </span>

                                </div>

                            </form>

                        </li>

                        <li class="dropdown main-profile-menu nav nav-item nav-link ps-lg-2">

                            <a class="new nav-link profile-user d-flex" href="#" data-bs-toggle="dropdown"><img alt="" src="<?=base_url('public/sitepanel/assets/images/avtar-2.png');?>" class=""> 

                            <span class="name">Hello 

                               <?php

                               $sess = session();

                               $sess->start();

        if (isset($_SESSION['admin_loged_in']) and $_SESSION['admin_loged_in'] != NULL) {

           echo  $_SESSION['admin_loged_in']['admin_user'];

        }else { echo "Admin";}

                               

                               ?>

                            </span>

                        </a>

                            <div class="dropdown-menu">

                                <div class="menu-header-content p-3 border-bottom">

                                    <div class="d-flex wd-100p">

                                        <div class="main-img-user"><img alt="" src="<?=base_url('public/sitepanel/assets/images/avtar-2.png');?>" class=""> </div>

                                        <div class="ms-3 my-auto">

                                            <h6 class="tx-15 font-weight-semibold mb-0">Admin Owner</h6><span class="dropdown-title-text subtext op-6  tx-12">Premium Member</span>

                                        </div>

                                    </div>

                                </div>

                                <a class="dropdown-item" href="<?=base_url('wpsadmin/wps-setting');?>">Settings</a>

                                <a class="dropdown-item" href="<?=base_url('wpsadmin/logout');?>">Sign Out</a>

                            </div>

                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

</div>