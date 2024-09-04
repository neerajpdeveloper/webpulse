<style>
      fieldset {
      border: 1px solid #157abb;
      padding: 10px;margin-top:10px;
      margin-bottom:15px;
      }
      .select-form{
      padding-left: 2px;
      }
   </style>
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
                        <legend>Select Categories:</legend>
                  <fieldset>
                     <?php echo get_nested_dropdown_menu(0,$proRes['category_id']); ?>
                  </fieldset>
                  <div class="form-group">
                     <label class="form-label text-dark">Product Title</label>
                     <input type="text" class="form-control" value="<?=$proRes['product_name'];?>" name="product_name" placeholder="Title" required>
                  </div>
                  <div class="form-group">
                     <label class="form-label text-dark">Product Display Title</label>
                     <input type="text" class="form-control" value="<?=$proRes['product_name_p'];?>" name="product_name_p" placeholder="Display Title">
                  </div>
                  <div class="form-group">
                     <label class="form-label text-dark">Product Meta Title</label>
                     <input type="text" class="form-control" value="<?=$metares['meta_title'];?>" name="productmetatitle" placeholder="Meta Title">
                  </div>
                  <div class="form-group">
                     <label class="form-label text-dark">Product Meta Keyword</label>
                     <textarea class="form-control" name="productmetakeyword" placeholder="Meta Keyword"><?=$metares['meta_keyword'];?></textarea>
                  </div>
                  <div class="form-group">
                     <label class="form-label text-dark">Product Meta Description</label>
                     <textarea class="form-control" name="productmetadescription" placeholder="Meta Description"><?=$metares['meta_description'];?></textarea>
                  </div>
                  <div class="form-group">
                     <label class="form-label text-dark">Product Short Description</label>
                     <textarea class="form-control" name="productshortdesc" required placeholder="Short Description"><?=$proRes['short_desc'];?></textarea>
                  </div>
                  <div class="form-group">
                     <label class="form-label text-dark">Product Full Description</label>
                     <textarea class="form-control editor" name="productfulldesc" placeholder="Full Description"><?=$proRes['products_description'];?></textarea>
                  </div>
                  <div class="form-group">
                     <label class="form-label text-dark">Product Specification</label>
                     <textarea class="form-control editor" name="productspecification" placeholder="Specification"><?=$proRes['specification'];?></textarea>
                  </div>
                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                           <label class="form-label text-dark">Product Code</label>
                           <input type="text" class="form-control" value="<?=$proRes['product_code'];?>" name="product_code" placeholder="Code PRO1500">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label class="form-label text-dark">Stock Quantity</label>
                           <input type="number" class="form-control" value="<?=$proRes['product_qty'];?>" name="product_qty" placeholder="Example 500">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label class="form-label text-dark">Youtube Video ID</label>
                           <input type="text" class="form-control" value="<?=$proRes['youtube_id'];?>" name="youtube_id" placeholder="Video ID">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label text-dark">Product Price</label>
                           <input type="number" class="form-control" value="<?=$proRes['product_price'];?>" name="product_price" placeholder="Price">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label text-dark">Product Discount Price</label>
                           <input type="number" class="form-control" value="<?=$proRes['product_discounted_price'];?>"  name="product_discountprice" placeholder="Discount Price">
                        </div>
                     </div>
                  </div>
                  <?php 
                    $posted_color_arr = explode(',', $proRes['color_ids']);
                  if($colorRes){ ?>
                  <legend>Select Color:</legend>
                  <fieldset>
                     <div class="row">
                     <?php foreach($colorRes as $color){ 
                     $isChecked = (array_search($color['color_id'], $posted_color_arr) !== false);
                        ?>
                        <div class="col-md-3"><input type="checkbox" name="color[]" value="<?=$color['color_id']?>" <?= $isChecked ? 'checked' : ''; ?>><label class="select-form"><?=$color['color_name']?></label></div>
                        <?php } ?>
                     </div>
                  </fieldset>
                  <?php } ?>
                  <?php $posted_size_arr = explode(',', $proRes['size_ids']);
                   if($sizeRes){ ?>
                  <legend>Select Size:</legend>
                  <fieldset>
                     <div class="row">
                     <?php foreach($sizeRes as $size){
                        $isChecked = (array_search($size['size_id'], $posted_size_arr) !== false);
                        ?>
                        <div class="col-md-3"><input type="checkbox" name="size[]" value="<?=$size['size_id']?>" <?= $isChecked ? 'checked' : ''; ?>><label class="select-form"><?=$size['size_name']?></label></div>
                        <?php } ?>
                     </div>
                  </fieldset>
                  <?php } ?>
                 <?php   $posted_brand_arr = explode(',', $proRes['brand_ids']);
                 if($brandRes){ ?>
                  <legend>Select Brand:</legend>
                  <fieldset>
                     <div class="row">
                        <?php foreach($brandRes as $brand){ 
                             $isChecked = (array_search($brand['brand_id'], $posted_brand_arr) !== false);
                            ?>
                           <div class="col-md-3"><input type="checkbox" name="brand[]" value="<?=$brand['brand_id']?>" <?= $isChecked ? 'checked' : ''; ?>><label class="select-form"><?php echo $brand['brand_name'];?></label></div>
                       <?php } ?>
                        
                     </div>
                  </fieldset>
                  <?php } ?>
                  <div class="form-group">
                     <label class="form-label text-dark">Product Image</label>
                     <input type="file" class="form-control" name="proimg">
                  </div>
                  <div class="form-group">
                        <img src="<?=base_url(UPLOAD_DIR.'product/'.$proRes['product_img']);?>" title="<?=$proRes['product_name']?>" alt="<?=$proRes['product_name']?>" class="imagethumb">
                   </div>
                  <div class="form-group">
                     <label class="form-label text-dark">Feature Product Image</label>
                     <input type="file" class="form-control" name="featureimg">
                  </div>
                  <div class="form-group">
                        <img src="<?=base_url(UPLOAD_DIR.'product/feature/'.$proRes['feature_img']);?>" title="<?=$proRes['product_name']?>" alt="<?=$proRes['product_name']?>" class="imagethumb">
                        </div>
                  <div class="form-group">
                     <label class="form-label text-dark">Product Size Chart</label>
                     <input type="file" class="form-control" name="sizechartimg">
                  </div>
                  <div class="form-group">
                        <img src="<?=base_url(UPLOAD_DIR.'product/sizechart/'.$proRes['size_chart']);?>" title="<?=$proRes['product_name']?>" alt="<?=$proRes['product_name']?>" class="imagethumb">
                        </div>
                     <div class="form-group">
                         <input type="hidden" class="form-control" name="action" value="edit">
                        <button class="btn save_btn" type="submit">Save</button>
                         <a href="<?=admin_url('manage-product')?>" class="btn cancel_btn" title="Cancel">Cancel</a>
                    </div>
                </form>
             </div>
        </div>
    </div>
</div>
<!-- /row closed -->
</div>
<!-- /Container -->