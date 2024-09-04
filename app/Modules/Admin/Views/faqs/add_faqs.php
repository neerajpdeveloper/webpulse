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
          <form name="newfaqForm" action="" method="POST" enctype="multipart/form-data">
            <?=csrf_field();?>
            <?php if(isset($validation)):?>
            <div class="alert alert-danger">
              <?= $validation->listErrors(); ?>
            </div>
            <?php endif;?>
            <?php echo print_session_msg(); ?>
            <div class="form-group">
              <label class="form-label text-dark">Faq Question</label>
              <input type="text" class="form-control" name="faq_question" required="">
            </div>
            <div class="form-group">
              <label class="form-label text-dark">FAQ Answer</label>
              <textarea class="form-control" name="faq_answer" required></textarea>
            </div>
            <div class="form-group">
              <input type="hidden" class="form-control" name="action" value="save">
              <button class="btn save_btn" type="submit">Save</button>
              <a href="<?=admin_url('manage-faqs')?>" class="btn cancel_btn" title="Cancel">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
