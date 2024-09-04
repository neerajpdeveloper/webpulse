 <!-- container -->
 <div class="main-container container-fluid">
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <span class="main-content-title mg-b-0 mg-b-lg-1"><?=$heading?></span>
    </div>
    <div class="justify-content-center mt-2">
        <ol class="breadcrumb">
            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$heading?></li>
        </ol>
    </div>
</div>
<!-- /breadcrumb -->
<!-- row -->
<div class="row row-sm main-content-mail">
    <div class="col-lg-12 col-xl-12 col-md-12">
        <div class="card">
                <div class="card-body">
                    <div class="email-media">
                        <div class="mt-0 d-sm-flex nameline">
                            <div class="main-avatar bg-gray-800" style="margin-right: 10px;"><?=substr($enq['name'],0,1);?></div>
                            <div class="media-body">
                            <div class="float-end d-none d-md-flex">
                                    <a href="<?=$back_url;?>" class="me-2  border br-5 p-2">Back</a>
                                </div>
                                
                                <div class="media-title font-weight-bold mt-3"><?=$enq['name']?> <span class="tx-13 font-weight-semibold">( <?=$enq['email']?> )</span></div>
                                <p class="mb-0"><?=date('d M,Y h:i',strtotime($enq['receive_date']))?> </p>
                                
                            </div>
                        </div>
                    </div>
                    <div class="eamil-body mt-5">
                        <h6>Hi Sir/Madam</h6>
                        <div class="table-responsive">
                    <table class="table  table-bordered text-nowrap mb-0" id="example1">
                        <thead>
                            <tr>
                               <th>Date</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                               <td><?=date('M d,Y',strtotime($enq['receive_date']))?></td>
                                <td><?=$enq['name']?></td>
                                <td><?=$enq['email']?></td>
                                <td><?=$enq['mobile_number']?></td>
                                <td><div class="title_lenth"><?=$enq['location']?></div></td> 
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
                <br>
                <p><strong>Product Name : <?=$enq['product_name']?></strong><br>
                                <span><?=$enq['message']?></span><br>
                                <strong>Url : <?=$enq['post_url']?></strong>
                                </p>
                                
                <p class="mb-0">Thanking you Sir/Madam</p>
                    </div>
                </div>
                <div class="card-footer">
                    <a class="btn btn-primary mt-1 mb-1" href="mailto:<?=$enq['email']?>"><i class="fa fa-reply"></i> Reply</a>
                    <a class="btn btn-info mt-1 mb-1" href="<?=$back_url;?>"><i class="fa fa-share"></i> Back</a>
                </div>
            </div>
        </div>
</div>

<!-- /row closed -->

</div>
<!-- /Container -->