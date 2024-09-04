<!-- container -->
<div class="main-container container-fluid">
<!-- breadcrumb -->
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
<!-- /breadcrumb -->
<!-- row  -->
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card">
            <div class="card-body">
            <form name="newcatForm" action="" method="POST" enctype="multipart/form-data">
            <?=csrf_field();?>
            <?php if(isset($validation)):?>
            <div class="alert alert-danger">
              <?= $validation->listErrors(); ?>
             </div>
            <?php endif; ?>
        <?php echo print_session_msg(); ?>
             <div class="form-group">
                <label class="form-label text-dark">Blog Title</label>
                <input type="text" class="form-control" value="" name="blog_title" required>
            </div>
            <div class="form-group">
                <label class="form-label text-dark">Blog Display Title</label>
                <input type="text" class="form-control" value="" name="blog_display_title" required>
            </div>
            
            <div class="form-group">
                <label class="form-label text-dark">Blog Meta Title</label>
                <input type="text" class="form-control" value="" name="blogmetaTitle" required>
            </div>
            
            <div class="form-group">
                <label class="form-label text-dark">Blog Meta Keyword</label>
                <input type="text" class="form-control" value="" name="blogmetaKeyword" required>
            </div>
             <div class="form-group">
                 <label class="form-label text-dark">Blog Meta Description</label>
                 <textarea class="form-control" name="blogmetaDescription" required></textarea>
             </div>
               <div class="form-group">
                 <label class="form-label text-dark">Blog Short Description</label>
                 <textarea class="form-control editor" rows="5" name="blogshortdesc" required></textarea>
             </div>
            <div class="form-group">
                <label class="form-label text-dark">Blog Full Description</label>
            <textarea class="form-control editor" rows="10" name="blogfulldesc" required></textarea>
                </div>
            <div class="form-group">
            <label class="form-label text-dark">Blog Image</label>
                    <input type="file" class="form-control" name="blogimg" required>
                </div>
                
                <div class="form-group">
                <input type="hidden" class="form-control" name="action" value="save">
                <button class="btn save_btn" type="submit">Save</button>
                <a href="<?=admin_url('manage-blog')?>" class="btn cancel_btn" title="Cancel">Cancel</a>
                </div>
                </form>
           
            </div>
        </div>
    </div>
</div>
<!-- /row closed -->

</div>
<!-- /Container -->
