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
                    <form name="newcatForm" action="" method="POST" enctype="multipart/form-data">
                        <?=csrf_field();?>
                        <?php if(isset($validation)):?>
                            <div class="alert alert-danger">
                               <?= $validation->listErrors(); ?>
                            </div>
                        <?php endif;?>
                        <?php echo print_session_msg(); ?>
                        <div class="form-group">
                            <label class="form-label text-dark">Page Name</label>
                            <input type="text" class="form-control" value="<?=$PageRes['page_name']?>" name="page_name" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label text-dark">Page video</label>
                            <input type="text" class="form-control" value="<?=$PageRes['video']?>" name="page_video_id" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label text-dark">Meta Title</label>
                            <input type="text" class="form-control" value="<?=@$metares['meta_title']?>" name="metaTitle">
                        </div>
                        <div class="form-group">
                            <label class="form-label text-dark">Meta Keyword</label>
                            <input type="text" class="form-control" value="<?=@$metares['meta_keyword']?>" name="metaKeyword">
                        </div>
                        <div class="form-group">
                            <label class="form-label text-dark">Meta Description</label>
                            <textarea class="form-control " name="metaDescription"><?=@$metares['meta_description']?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label text-dark">Short Description</label>
                            <textarea class="form-control editor" name="page_short_description"><?=$PageRes['page_short_description']?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label text-dark">Description</label>
                            <textarea class="form-control editor" name="page_description"><?=$PageRes['page_description']?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label text-dark">Description 2</label>
                            <textarea class="form-control editor" name="page_description2"><?=$PageRes['page_description2']?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label text-dark">Description 3</label>
                            <textarea class="form-control editor" name="page_description3"><?=$PageRes['page_description3']?></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label text-dark">Image</label>
                            <input type="file" class="form-control" name="img">
                        </div>
                        <div class="form-group">
                        <img src="<?=base_url('public/upload/page/'.$PageRes['image']);?>" title="<?=$PageRes['page_name']?>" alt="<?=$PageRes['page_name']?>" class="imagethumb">
                        </div>
                        

                     <div class="form-group">
                         <input type="hidden" class="form-control" name="action" value="edit">
                        <button class="btn save_btn" type="submit">Save</button>
                         <a href="<?=admin_url('manage-page')?>" class="btn cancel_btn" title="Cancel">Cancel</a>
                    </div>
                </form>
             </div>
        </div>
    </div>
</div>
<!-- /row closed -->
</div>
<!-- /Container -->