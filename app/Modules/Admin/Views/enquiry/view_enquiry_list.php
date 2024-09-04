<!-- container -->
<div class="main-container container-fluid">
<style>
    input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <span class="main-content-title mg-b-0 mg-b-lg-1"><?=$heading?>(<?=$enqcount?>)</span>
    </div>
    <div class="justify-content-center mt-2">
        <ol class="breadcrumb">
            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$heading?></li>
        </ol>
    </div>
</div>
<!-- /breadcrumb -->
<!-- row  -->
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?=$heading?> </h4>
            </div>
            <div class="card-body pt-0 example1_table_2">
                <div class="table-responsive">
                <form action="" id="data_form" method="Post">
                        <?=csrf_field();?>
                        <?php if(isset($validation)):?>
                            <div class="alert alert-danger">
                               <?= $validation->listErrors(); ?>
                            </div>
                        <?php endif;?>
                        <?php echo print_session_msg(); ?>
                        <?php   if ($enquiry_res) { $i=1;
                            foreach($enquiry_res as $key =>  $pageVal){ ?>
                            <div class="main-mail-item <?=($pageVal['seen_status'] == 'N') ? 'bold_line' : '';?>">
                                   <a href="<?=admin_url('enquiries');?>/<?=$pageVal['id']?>">
                                    <div class="main-mail-checkbox">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="arr_ids[]" value="<?php echo $pageVal['id']; ?>" >
                                        <span class="custom-control-label custom-control-label-md  tx-17"></span>
                                    </label>
                                    </div>
                                    <div class="main-avatar bg-gray-800">
                                        <?php  echo substr($pageVal['name'],0,1);
                                        ?>
                                    </div>
                                    <div class="main-mail-body">
                                        <div class="main-mail-subject">
                                            <strong><?php  echo $pageVal['name']; ?></strong> <span>
                                            Email: <?php  echo $pageVal['email']; ?>, Mobile: <?php  echo $pageVal['mobile_number']; ?> Enquiry for your website service or product <?=$pageVal['post_url']?></span>
                                        </div>
                                    </div>
                                    <div class="main-mail-date">
                                    <?php echo getLeaddateStatus($pageVal['receive_date']);?>
                                    </div>
                                    </a>
                                </div>
                            <?php } } else{ ?>
<tr class="text-center">
    <td colspan='6'>No Location Found</td>
</tr>
                          <?php  } ?>
                </div>
                <div class="row">
                    <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-9 col-12">
                        <ul class="pagination float_left">
                            <li class="page-item">
                            <input name="status_action" type="submit" class="page-link" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]', 'Delete', 'Record', 'data_form');">
                            </li>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                    <?= $pager->links() ?>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
<!-- /row closed -->

</div>
<!-- /Container -->
