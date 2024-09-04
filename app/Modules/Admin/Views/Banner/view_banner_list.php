<!-- container -->
<div class="main-container container-fluid">
<style>
    input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>
<?php helper('thumbnail');
?>
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

<!-- row  -->
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?=$heading?> <a href="<?=admin_url('add-banner');?>">Add New Banner</a></h4>
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
                    <table class="table  table-bordered text-nowrap mb-0" id="example1">
                        <thead>
                            <tr>
                                <th class="text-center">SN</th>
                                <th>Banner Title</th>
                                <th>Banner Thumb</th>
                                <th>Display Order</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                           if ($bannerRes) {
                $i=1;
                            foreach($bannerRes as $key =>  $pageVal){ 
                                $displayorder = ($pageVal['sort_order'] != '') ? $pageVal['sort_order'] : "0";
                              ?>
                            <tr>
                                <td class="text-center">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="arr_ids[]" value="<?php echo $pageVal['banner_id']; ?>" >
                                        <span class="custom-control-label custom-control-label-md  tx-17"></span>
                                    </label>
                                    </td>
                                <td>
                                <?php 
                            echo $pageVal['banner_title'];
                           ?>
                                </td>
                                
                                <td class="text-center">
                                <img src="<?=base_url('public/upload/banner/'.$pageVal['banner_image']);?>" title="<?=$pageVal['banner_title']?>" alt="<?=$pageVal['banner_title']?>" class="imagethumb">
                                </td>
                                <td><input type="tel" class="form-control order_input" name="ord[<?php echo $pageVal['banner_id']; ?>]" value="<?=$displayorder;?>"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="2"></td>
                             
                                <td>
                                <?php
                            if ($pageVal['status'] == '1') {
                              ?>
                              <span class="badge badge-success">Active</span>
                              <?php
                            } else {
                              ?>
                              <span class="badge badge-success">In active</span>
                              <?php
                            }
                            ?>                 
                                </td>
                                <td>
                            <a href="<?=admin_url('edit-banner')."/".$pageVal['banner_id'];?>" class="reply_btn" data-bs-toggle="tooltip" data-bs-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/></svg></a>
                            <!-- <a href="" class="remove_btn" data-bs-toggle="tooltip" data-bs-original-title="Delete"><svg class="table-delete" xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 24 24" width="16"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9zm7.5-5l-1-1h-5l-1 1H5v2h14V4h-3.5z"></path></svg></a> -->
                            </td>                                            
                            </tr>
                            <?php } } else{ ?>
<tr class="text-center">
    <td colspan='6'>No Banner Found</td>
</tr>
                          <?php  } ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-9 col-12">
                        <ul class="pagination float_left">
                            <li class="page-item">
                            <input name="status_action" type="submit"  value="Activate" class="page-link" id="Activate" onClick="return validcheckstatus('arr_ids[]', 'Activate', 'Record', 'data_form');">
                            </li>
                            <li class="page-item">
                            <input name="status_action" type="submit" class="page-link" value="Deactivate" id="Deactivate"  onClick="return validcheckstatus('arr_ids[]', 'Deactivate', 'Record', 'data_form');"/>
                            </li>
                            <li class="page-item">
                            <input name="status_action" type="submit" class="page-link" id="Delete" value="Delete"  onClick="return validcheckstatus('arr_ids[]', 'Delete', 'Record', 'data_form');">
                            </li>
                            <li class="page-item active">
                            <input name="update_order" type="submit"  value="Update Order" class="page-link">
                            </li>
                        </ul>
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
