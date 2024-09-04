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
                <label class="form-label text-dark">Color Name</label>
                <input type="text" class="form-control" value="<?=$ColorRes['color_name']?>" name="color_name" required>
            </div>
            <div class="form-group">
                <label class="form-label text-dark">Select Color</label>
                <input type="text" id="hex" name="color_code" required value="<?=$ColorRes['color_code']?>">
                <input type="color" id="color" value="<?=$ColorRes['color_code']?>">
            </div>
        
                <div class="form-group">
                    <label class="form-label text-dark">Image</label>
                    <input type="file" class="form-control" name="Colorimg" >
                </div>
                
                <div class="form-group">
                <input type="hidden" class="form-control" name="action" value="edit">
                <button class="btn save_btn" type="submit">Save</button>
                <a href="<?=admin_url('manage-color')?>" class="btn cancel_btn" title="Cancel">Cancel</a>
                </div>
                </form>
           
            </div>
        </div>
    </div>
</div>
<!-- /row closed -->

</div>
<!-- /Container -->
<script>
    let colorInput = document.querySelector('#color');
let hexInput = document.querySelector('#hex');
colorInput.addEventListener('input', () =>{
    let color = colorInput.value;
    hexInput.value = color;
});
</script>