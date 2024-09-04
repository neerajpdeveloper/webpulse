
<link rel="stylesheet" type="text/css" href="<?=base_url('public/sitepanel/assets/css/date-picker.css');?>">
    <!-- container -->
    <div class="main-container container-fluid">



        <!-- breadcrumb -->

        <div class="breadcrumb-header justify-content-between">

            <div class="left-content">

                <span class="main-content-title mg-b-0 mg-b-lg-1">DASHBOARD</span>

            </div>

            <div class="justify-content-center mt-2">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Admin</a></li>

                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>

                </ol>

            </div>

        </div>

        <!-- /breadcrumb -->



        <!-- row -->

        <div class="row">

            <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12 col-sm-12">

                <div class="row">

                    <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12">

                        <div class="card">

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-xl-9 col-lg-7 col-md-6 col-sm-12">

                                        <div class="text-justified align-items-center">

                                            <h3 class="text-dark font-weight-semibold mb-2 mt-0">Hi, Welcome Back <span class="text-primary"><?php

                               $sess = session();

                               $sess->start();

        if (isset($_SESSION['admin_loged_in']) and $_SESSION['admin_loged_in'] != NULL) {

           echo $_SESSION['admin_loged_in']['admin_user'];

        }else { echo "Admin";}

                               

                               ?>!</span></h3>

                                            <p class="text-dark tx-14 mb-3 lh-3"> You have used the 95% of free plan storage. Please upgrade your plan to get unlimited storage.</p>

                                        </div>

                                    </div>

                                    <div class="col-xl-3 col-lg-5 col-md-6 col-sm-12 d-flex align-items-center justify-content-center">

                                        <div class="chart-circle float-md-end mt-4 mt-md-0" data-value="0.85" data-thickness="8" data-color=""><canvas width="100" height="100"></canvas>

                                            <div class="chart-circle-value circle-style">

                                                <div class="tx-18 font-weight-semibold">95%</div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-xl-6 col-lg-12 col-md-12 col-xs-12">

                        <div class="card sales-card">

                            <div class="row">

                                <div class="col-8">

                                    <div class="ps-4 pt-4 pe-3 pb-4">

                                        <div class="">

                                            <h6 class="mb-2 tx-12 ">Total Category</h6>

                                        </div>

                                        <div class="pb-0 mt-0">

                                            <div class="d-flex">

                                                <h4 class="tx-20 font-weight-semibold mb-2"><?php echo ($catnum>0) ? $catnum:0; ?></h4>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-4">

                                    <div class="circle-icon bg-primary-transparent text-center align-self-center overflow-hidden">

                                        <svg class="tx-16 text-primary" fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M10 3H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM9 9H5V5h4v4zm11-6h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 6h-4V5h4v4zm-9 4H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1zm-1 6H5v-4h4v4zm8-6c-2.206 0-4 1.794-4 4s1.794 4 4 4 4-1.794 4-4-1.794-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2z"></path></svg>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-xl-6 col-lg-12 col-md-12 col-xs-12">

                        <div class="card sales-card">

                            <div class="row">

                                <div class="col-8">

                                    <div class="ps-4 pt-4 pe-3 pb-4">

                                        <div class="">

                                            <h6 class="mb-2 tx-12">Total Products</h6>

                                        </div>

                                        <div class="pb-0 mt-0">

                                            <div class="d-flex">

                                                <h4 class="tx-20 font-weight-semibold mb-2"><?php echo ($productnum>0) ? $productnum:0; ?></h4>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-4">

                                    <div class="circle-icon bg-info-transparent text-center align-self-center overflow-hidden">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="tx-16 text-info" width="24" height="24" viewBox="0 0 24 24"><path d="M20 7h-1.209A4.92 4.92 0 0 0 19 5.5C19 3.57 17.43 2 15.5 2c-1.622 0-2.705 1.482-3.404 3.085C11.407 3.57 10.269 2 8.5 2 6.57 2 5 3.57 5 5.5c0 .596.079 1.089.209 1.5H4c-1.103 0-2 .897-2 2v2c0 1.103.897 2 2 2v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7c1.103 0 2-.897 2-2V9c0-1.103-.897-2-2-2zm-4.5-3c.827 0 1.5.673 1.5 1.5C17 7 16.374 7 16 7h-2.478c.511-1.576 1.253-3 1.978-3zM7 5.5C7 4.673 7.673 4 8.5 4c.888 0 1.714 1.525 2.198 3H8c-.374 0-1 0-1-1.5zM4 9h7v2H4V9zm2 11v-7h5v7H6zm12 0h-5v-7h5v7zm-5-9V9.085L13.017 9H20l.001 2H13z"></path></svg>

                                        

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-xl-6 col-lg-12 col-md-12 col-xs-12">

                        <div class="card sales-card">

                            <div class="row">

                                <div class="col-8">

                                    <div class="ps-4 pt-4 pe-3 pb-4">

                                        <div class="">

                                            <h6 class="mb-2 tx-12">Total Enquiry</h6>

                                        </div>

                                        <div class="pb-0 mt-0">

                                            <div class="d-flex">

                                                <h4 class="tx-20 font-weight-semibold mb-2"><?php echo ($enquirynum>0) ? $enquirynum:0; ?></h4>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-4">

                                    <div class="circle-icon bg-secondary-transparent text-center align-self-center overflow-hidden">

                                        <svg class="tx-16 text-secondary" fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M20 4H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zm0 2v.511l-8 6.223-8-6.222V6h16zM4 18V9.044l7.386 5.745a.994.994 0 0 0 1.228 0L20 9.044 20.002 18H4z"></path></svg>

                                        

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-xl-6 col-lg-12 col-md-12 col-xs-12">

                        <div class="card sales-card">

                            <div class="row">

                                <div class="col-8">

                                    <div class="ps-4 pt-4 pe-3 pb-4">

                                        <div class="">

                                            <h6 class="mb-2 tx-12">Total Review</h6>

                                        </div>

                                        <div class="pb-0 mt-0">

                                            <div class="d-flex">

                                                <h4 class="tx-22 font-weight-semibold mb-2"><?php echo ($reviewnum>0) ? $reviewnum:0;?></h4>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-4">

                                    <div class="circle-icon bg-warning-transparent text-center align-self-center overflow-hidden">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="tx-16 text-warning" viewBox="0 0 16 16"><path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/><path d="M7.066 4.76A1.665 1.665 0 0 0 4 5.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 1 0 .6.58c1.486-1.54 1.293-3.214.682-4.112zm4 0A1.665 1.665 0 0 0 8 5.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 1 0 .6.58c1.486-1.54 1.293-3.214.682-4.112z"/></svg>

                                   

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12">

                <div class="card custom-card overflow-hidden">

                        <div class="datepicker-here date-picker-university" data-language="en"></div>

                    </div>

            </div>

            <!-- </div> -->

        </div>

        <!-- row closed -->



        <!-- row  -->

        <div class="row">

            <div class="col-12 col-sm-12">

                <div class="card">

                    <div class="card-header">

                        <h4 class="card-title">Latest Enquiry</h4>

                    </div>

                    <div class="card-body pt-0 example1-table">

                        <div class="table-responsive">

                            <table class="table  table-bordered text-nowrap mb-0" id="example1">

                                <thead>

                                    <tr>

                                        <th class="text-center">SN</th>

                                        <th>Name</th>

                                        <th>Email</th>

                                        <th>Phone</th>

                                        <th>Product Details</th>

                                        <th>Action</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php 

                                    $i=1;

                                    foreach($enqquery as $key =>  $val){ ?>

                                    <tr>

                                        <td class="text-center">#<?=$i;?></td>

                                        <td><?php echo $val['name'];?></td>

                                        <td><a href="mailto:<?php echo $val['email'];?>"><?php echo $val['email'];?></a></td>

                                        <td><a href="tel:<?php echo $val['mobile_number'];?>"><?php echo $val['mobile_number'];?></a></td>

                                        <td>

                                        <div class="msg">

                                        <strong>Product </strong>

                                        <span><?php echo $val['message'];?></span></div>

                                        </td>

                                        <td>

                                    <a href="mailto:<?php echo $val['email'];?>" class="reply_btn" data-bs-toggle="tooltip" data-bs-original-title="Reply"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.499.499 0 0 0 .042-.028l3.984-2.933zM7.8 10.386c.068 0 .143.003.223.006.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96v-.667z"></path></svg></a>

                                    <!-- <a href="" class="remove_btn" data-bs-toggle="tooltip" data-bs-original-title="Delete"><svg class="table-delete" xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 24 24" width="16"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9zm7.5-5l-1-1h-5l-1 1H5v2h14V4h-3.5z"></path></svg></a> -->

                                    </td>

                                    

                                    </tr>

                                    <?php $i++; } ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- /row closed -->



    </div>

    <!-- /Container -->

<script src="<?=base_url('public/sitepanel/assets/js/datepicker/datepicker.js');?>"></script>

<script src="<?=base_url('public/sitepanel/assets/js/datepicker/datepicker.en.js');?>"></script>

<script src="<?=base_url('public/sitepanel/assets/js/datepicker/datepicker.custom.js');?>"></script>


