<!-- container -->
<div class="main-container container-fluid">

<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <span class="main-content-title mg-b-0 mg-b-lg-1">Add Banner</span>
    </div>
    <div class="justify-content-center mt-2">
        <ol class="breadcrumb">
            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Banner</li>
        </ol>
    </div>
</div>
<!-- /breadcrumb -->

<!-- row  -->
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card">
            <div class="card-body">
               <form method="POST" action="" enctype="multipart/form-data">
               <?=csrf_field();?>
            <?php if(isset($validation)):?>
                <div class="alert alert-danger">
                   <?= $validation->listErrors(); ?>
                </div>
                <?php endif;?>
                <?php echo print_session_msg(); ?>
                <!-- <div class="form-group">
                    <label class="form-label text-dark">Select Banner for</label>
                    <select class="form-control form-select">
                        <option value="1" selected>Home Banner Size 1920px x 700px</option>
                         <option value="2">Inner Banner Size 1920px x 400px</option>
                    </select>
                </div> -->
                <div class="form-group">
                    <label class="form-label text-dark">Banner Title</label>
                        <input type="text" class="form-control" name="banner_title" placeholder="Banner Title" required="">
                </div>
                <div class="form-group">
                    <label class="form-label text-dark">Banner URL</label>
                        <input type="text" class="form-control" name="banner_url" placeholder="Banner url" required="">
                </div>
                <div class="form-group">
                    <label class="form-label text-dark">*Banner For Desktop</label>
                        <input type="file" class="form-control" name="banner_image" required="">
                </div>
                
                <div class="form-group">
                    <label class="form-label text-dark">*Banner For Mobile</label>
                        <input type="file" class="form-control" name="mobile_banner_image" required="">
                </div>
                <div class="form-group">
                <input type="hidden" class="form-control" name="action" value="save">
                <button class="btn save_btn" type="submit">Save</button>
                <a href="<?=admin_url('manage-banner')?>" class="btn cancel_btn" title="Cancel">Cancel</a>
                </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- /row closed -->

</div>
<!-- /Container -->