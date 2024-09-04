<div class="main-container container-fluid">
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1"><?=$heading?></span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?=$heading?></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form name="newcatForm" action="" method="POST">
                        <?=csrf_field();?>
                        <?php if(isset($validation)):?>
                            <div class="alert alert-danger">
                               <?= $validation->listErrors(); ?>
                            </div>
                        <?php endif;?>
                        <?php echo print_session_msg(); ?>
                        <div class="form-group">
                            <label class="form-label text-dark">City Name</label>
                            <input type="text" class="form-control" value="<?=$res_arr['location_name']?>" name="city_name" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label text-dark">City Display Name</label>
                            <input type="text" class="form-control" value="<?=$res_arr['location_display']?>" name="city_name_p" required>
                        </div>
                     <div class="form-group">
                         <input type="hidden" class="form-control" name="action" value="edit">
                        <button class="btn save_btn" type="submit">Save</button>
                         <a href="<?=admin_url('manage-location/state/'.$parentID)?>" class="btn cancel_btn" title="Cancel">Cancel</a>
                    </div>
                </form>
             </div>
        </div>
    </div>
</div>
<!-- /row closed -->
</div>
<!-- /Container -->