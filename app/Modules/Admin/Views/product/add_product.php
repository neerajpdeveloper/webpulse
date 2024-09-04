
<!-- container -->
<div class="main-container container-fluid">
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
   <!-- breadcrumb -->
   <div class="breadcrumb-header justify-content-between">
      <div class="left-content">
         <span class="main-content-title mg-b-0 mg-b-lg-1">Add New Product</span>
      </div>
      <div class="justify-content-center mt-2">
         <ol class="breadcrumb">
            <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Admin</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add New Product</li>
         </ol>
      </div>
   </div>
   <!-- /breadcrumb -->
   <!-- row  -->
   <div class="row">
      <div class="col-12 col-sm-12">
         <div class="card">
            <div class="card-body">
               <form method="post" action="" enctype="multipart/form-data">
               <?=csrf_field();?>
            <?php if(isset($validation)):?>
            <div class="alert alert-danger">
              <?= $validation->listErrors(); ?>
             </div>
            <?php endif; ?>
        <?php echo print_session_msg(); ?>
                  <legend>Select Categories:</legend>
                  <fieldset>
                     <?php echo get_nested_dropdown_menu(0,''); ?>
                  </fieldset>
                  <div class="form-group">
                     <label class="form-label text-dark">Product Title</label>
                     <input type="text" class="form-control" value="" name="product_name" placeholder="Title" required>
                  </div>
                  <div class="form-group">
                     <label class="form-label text-dark">Product Display Title</label>
                     <input type="text" class="form-control" value="" name="product_name_p" placeholder="Display Title">
                  </div>
                  <div class="form-group">
                     <label class="form-label text-dark">Product Meta Title</label>
                     <input type="text" class="form-control" value="" name="productmetatitle" placeholder="Meta Title">
                  </div>
                  <div class="form-group">
                     <label class="form-label text-dark">Product Meta Keyword</label>
                     <textarea class="form-control" name="productmetakeyword" placeholder="Meta Keyword"></textarea>
                  </div>
                  <div class="form-group">
                     <label class="form-label text-dark">Product Meta Description</label>
                     <textarea class="form-control" name="productmetadescription" placeholder="Meta Description"></textarea>
                  </div>
                  <div class="form-group">
                     <label class="form-label text-dark">Product Short Description</label>
                     <textarea class="form-control" name="productshortdesc" required placeholder="Short Description"></textarea>
                  </div>
                  <div class="form-group">
                     <label class="form-label text-dark">Product Full Description</label>
                     <textarea class="form-control editor" name="productfulldesc" placeholder="Full Description"></textarea>
                  </div>
                  <div class="form-group">
                     <label class="form-label text-dark">Product Specification</label>
                     <textarea class="form-control editor" name="productspecification" placeholder="Specification"></textarea>
                  </div>
                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                           <label class="form-label text-dark">Product Code</label>
                           <input type="text" class="form-control" value="" name="product_code" placeholder="Code PRO1500">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label class="form-label text-dark">Stock Quantity</label>
                           <input type="number" class="form-control" value="" name="product_qty" placeholder="Example 500">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label class="form-label text-dark">Youtube Video ID</label>
                           <input type="text" class="form-control" value="" name="youtube_id" placeholder="Video ID">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label text-dark">Product Price</label>
                           <input type="number" class="form-control" value="" name="product_price" placeholder="Price">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label text-dark">Product Discount Price</label>
                           <input type="number" class="form-control" value=""  name="product_discountprice" placeholder="Discount Price">
                        </div>
                     </div>
                  </div>
                  <?php if($colorRes){ ?>
                  <legend>Select Color:</legend>
                  <fieldset>
                     <div class="row">
                     <?php foreach($colorRes as $color){ ?>
                        <div class="col-md-3"><input type="checkbox" name="color[]" value="<?=$color['color_id']?>"><label class="select-form"><?=$color['color_name']?></label></div>
                        <?php } ?>
                     </div>
                  </fieldset>
                  <?php } ?>
                  <?php if($sizeRes){ ?>
                  <legend>Select Size:</legend>
                  <fieldset>
                     <div class="row">
                     <?php foreach($sizeRes as $size){ ?>
                        <div class="col-md-3"><input type="checkbox" name="size[]" value="<?=$size['size_id']?>"><label class="select-form"><?=$size['size_name']?></label></div>
                        <?php } ?>
                     </div>
                  </fieldset>
                  <?php } ?>
                 <?php if($brandRes){ ?>
                  <legend>Select Brand:</legend>
                  <fieldset>
                     <div class="row">
                        <?php foreach($brandRes as $brand){ ?>
                           <div class="col-md-3"><input type="checkbox" name="brand[]" value="<?=$brand['brand_id']?>"><label class="select-form"><?php echo $brand['brand_name'];?></label></div>
                       <?php } ?>
                        
                     </div>
                  </fieldset>
                  <?php } ?>
                  <div class="form-group">
                     <label class="form-label text-dark">Product Image</label>
                     <input type="file" class="form-control" name="proimg">
                  </div>
                  <div class="form-group">
                     <label class="form-label text-dark">Multi Product Image</label>
                     <input type="file" class="form-control" multiple name="multipimg[]">
                  </div>
                  <div class="form-group">
                     <label class="form-label text-dark">Feature Product Image</label>
                     <input type="file" class="form-control" name="featureimg">
                  </div>
                  <div class="form-group">
                     <label class="form-label text-dark">Product Size Chart</label>
                     <input type="file" class="form-control" name="sizechartimg">
                  </div>
                  <div class="form-group">
                  <input type="hidden" class="form-control" name="action" value="save">
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