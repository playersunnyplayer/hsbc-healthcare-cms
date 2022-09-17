<?php
ob_start();
session_start();
$adminId=$_SESSION['aid'];
include_once("configuration/connect.php");
include_once("configuration/functions.php");
checkIntrusion($adminId);
//$res=getAdminDetail($adminId);
$currentDate=date("d")."/".date("m")."/".date("Y");
if(isset($_POST['submit']))
{
$date=date('d/m/Y');$time=date('hh:mm sa');
$name=$_POST['pro_name'];$status=$_POST['status'];
$cat=$_POST['cat'];
$subcat=$_POST['subcat'];
$desp=$_POST['editor1'];
$price=$_POST['pro_price'];
$oprice=$_POST['pro_offer_price'];
$type=$_POST['view_type'];
$ptitle=$_POST['pagetitle'];$pdesp=$_POST['pagedesp'];$ptags=$_POST['tags'];
$sku=$_POST['sku'];$barcode=$_POST['barcode'];
$smethod=$_POST['smethod'];$samount=$_POST['samount'];$weight=$_POST['weight'];$height=$_POST['height'];
$length=$_POST['lenght'];$width=$_POST['width'];$ddate=$_POST['dldate'];
$vurl=$_POST['videourl'];
$countfiles = count($_FILES['sliderimage']['name']);
$filename = $_FILES['image']['name'];
  $valid_ext = array('png','jpeg','jpg');
   $location2="products/".$filename;
  $location = "../assets/images/products/".$filename;
  $file_extension = pathinfo($location, PATHINFO_EXTENSION);
  $file_extension = strtolower($file_extension);
  if(in_array($file_extension,$valid_ext)){
    compressImage($_FILES['image']['tmp_name'],$location,60);
	  }else{
    echo "Invalid file type.";
  }
$qry=mysqli_query($con,"INSERT INTO `product`(`id`, `category_id`, `subcategory_id`, `name`, `desp`, `price`, `fullprice`, `type`,`status`,`image`,`eid`,`date`,`time`)
VALUES (NULL,'$cat','$subcat','$name','$desp','$price','$oprice','$type','$status','$filename','$adminId','$date','$time')");
$pro_id=mysqli_insert_id($con);
$seoQry=mysqli_query($con,"INSERT INTO `productseo`(`id`, `pro_id`, `title`, `desp`, `tags`, `date`, `eid`, `status`)
VALUES (NULL,'$pro_id','$ptitle','$pdesp','$ptags','$date','$adminId','1')");
$shipQry=mysqli_query($con,"INSERT INTO `shipping`(`id`, `pro_id`, `type`, `amount`, `weight`, `length`, `height`, `width`, `deliverydate`, `date`, `time`, `status`, `eid`)
VALUES (NULL,'$pro_id','$smethod','$samount','$weight','$length','$height','$width','$ddate','$date','$time','$adminId','1')");
mysqli_query($con,"INSERT INTO `product_slider`(`id`, `pro_id`, `type`, `file`, `status`)
 VALUES (NULL,'$pro_id','1','$filename','1')");
 mysqli_query($con,"INSERT INTO `product_slider`(`id`, `pro_id`, `type`, `file`, `status`)
  VALUES (NULL,'$pro_id','2','$vurl','1')");
 for($i=0;$i<$countfiles;$i++){
  $filename = $_FILES['sliderimage']['name'][$i];
  compressImage($_FILES['sliderimage']['tmp_name'][$i],$location,60);
  $sliQry=mysqli_query($con,"INSERT INTO `product_slider`(`id`, `pro_id`, `type`, `file`, `status`)
   VALUES (NULL,'$pro_id','1','$filename','1')");
   $invQry=mysqli_query($con,"INSERT INTO `inventry`(`id`, `pro_id`, `sku`, `barcode`, `date`, `time`, `status`, `eid`)
   VALUES (NULL,'$pro_id','$sku','$barcode','$date','$time','1','$adminId')");
 }
  if($qry){
		header("location:Product.php?msg=ins");
	}else{
		header("location:Product.php?msg=inf");
	}
}
if(isset($_POST['update']))
{
  $hId=$_POST['hId'];
   $name=$_POST['u_pro_name'];$slug=$_POST['u_pro_slug'];$status=$_POST['u_status'];
$cat=$_POST['u_cat'];$subcat=$_POST['u_subcat'];$desp=$_POST['ueditor1'];
$price=$_POST['u_pro_price'];$oprice=$_POST['u_pro_offer_price'];$type=$_POST['u_view_type'];
$filename = $_FILES['u_image']['name'];

if($filename==''){
	$qry=mysqli_query($con,"UPDATE `product` SET `category_id`='$cat',`subcategory_id`='$subcat',`name`='$name',
	`desp`='$desp',`slug`='$slug',`price`='$price',`fullprice`='$oprice',`type`='$type',`status`='$status' WHERE id='$hId'");
}else{
	$valid_ext = array('png','jpeg','jpg');
   $location2="products/".$filename;
  $location = "products/".$filename;
  $file_extension = pathinfo($location, PATHINFO_EXTENSION);
  $file_extension = strtolower($file_extension);
  if(in_array($file_extension,$valid_ext)){
    compressImage($_FILES['u_image']['tmp_name'],$location,60);
	  }else{
    echo "Invalid file type.";
  }
  $qry=mysqli_query($con,"UPDATE `product` SET `category_id`='$cat',`subcategory_id`='$subcat',`name`='$name',
	`desp`='$desp',`slug`='$slug',`price`='$price',`fullprice`='$oprice',`type`='$type',`status`='$status',`image`='$filename' WHERE `id`='$hId'");
}

  if($qry){
		header("location:Product.php?msg=upd");
	}else{
		header("location:Product.php?msg=inf");
	}


}
	if(isset($_GET['msg'])&&$_GET['msg']!=''){
	$msg=$_GET['msg'];
	switch($msg){
	case 'ins':
		$msg='Data added Successfully !!';
		$class='success';
	break;
	case 'inf':
		$msg='Something went wrong !!';
		$class='danger';
	break;
	case 'upd':
		$msg='Data updated Successfully !!';
		$class='success';
	break;
	case 'dls':
		$msg='Data deleted successfully!!';
		$class='info';
	break;
	case 'dlf':
		$msg='Data not updated successfully !!!!';
		$class='warning';
	break;
	case 'default' :
		$msg='';
		break;

	}
	}

	?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
   <?php include 'include_file/meta.php'?>
<title><?php echo basename($_SERVER['PHP_SELF']).'-'; ?>Ani's Store</title>
    <?php include 'include_file/css.php'?>
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){

    });
    </script>
  </head>
  <body style="background-color:#F6F6F7">
<?php include 'include_file/header.php'?>
<?php include 'include_file/leftmenu.php'?>


    <div class="content pd-0">
      <div class="content-header">

      </div>
      <div class="content-body">
        <div class="container pd-x-0">
          <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
				          <li class="breadcrumb-item"><a href="#">Catelog Management</a></li>
                  <li class="breadcrumb-item"><a href="Product.php">Product</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Add Product</li>
                </ol>
              </nav>
              <h4 class="mg-b-0 tx-spacing--1">Add Product</h4>
            </div>
            <div class="d-none d-md-block">
              <a href="Product.php" ><button class="btn btn-sm pd-x-15 btn btn-outline-success btn-uppercase mg-l-5" data-toggle="modal" data-target=".bs-example-modal-sm"><i  class="fa fa-desktop wd-10 mg-r-5"></i> View Product</button></a>
            </div>
          </div>
      <div class="row ">
		  <div class="col-sm-12 col-lg-12">
		  <?php if($msg!=''){ ?>
			 <div class="alert alert-<?php echo $class;?> alert-dismissible " role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                   <?php echo $msg?>
                  </div>
				<?php } ?>
				</div>
      <form method='post' action='' enctype='multipart/form-data'>
		  <div class="col-sm-12 col-lg-12">
        <div class="row">
        <div class="col-md-8">

            <div class="card">
            <div class="card-body">
                    <p class="card-text"><label>Product Name *:</label>
        <input type="text" id="pro_name" class="form-control" name="pro_name" placeholder="Product Name" required>
          <label class=control-label>Product Description *:</label>
        <textarea id="desp" name="editor1" ></textarea>
        <script>
                CKEDITOR.replace( 'editor1' );
        </script></p>
              </div>
                </div>
              <div class="card mg-t-20">
              <div class="card-body">
                <h6 class="card-title">Product Media</h6>
                <div class="row row-xs">
                  <div class="col-md-4 ">
                  <label class=control-label>Primary Image <span class="badge badge-pill badge-light" data-container="body" data-toggle="popover" data-placement="top" data-content="Add primary image that will show on the website."><i class="fa fa-question "></i></span></label>

                  <div><input type="file" id='image' name="image" onchange="readURL(this);"></div>
                    <div id="viewimg" style="height:150px;width:210px;display:none"> <img id="pimage" height='150' width="210" style="border:none"  /></div>
                    </div>
                    <div class="col-md-4">
                    <label class=control-label>Primary Video Url <span class="badge badge-pill badge-light" data-container="body" data-toggle="popover" data-placement="top" data-content="Add Video URL."><i class="fa fa-question "></i></span></label>
                    <input type="text" class="form-control" name="videourl" value="">
                    </div>
                      <div class="col-md-4 ">
                      <label class=control-label>Slider Image <span class="badge badge-pill badge-light" data-container="body" data-toggle="popover" data-placement="top" data-content="select multiple image  that will show product description page as a slider into the website."><i class="fa fa-question "></i></span></label>

                      <input type="file" class="" id='sliderimage' name="sliderimage[]" multiple>

                        </div>
                </div>

              </div>
            </div>
            <div class="card mg-t-20">
            <div class="card-body">
                <h6 class="card-title">Product Pricing</h6>
                <p class="card-text">
                  <div class="row row-xs">
                  <div class="col-md-6">
                        <label> Price *:</label>
                        <input type="text" onKeyUp="calculatemargin();" id="pro_price" class="form-control" name="pro_price" placeholder="Product Price" required>
                        </div>
                        <div class="col-md-6">
                        <label>Compare at Price *: <span class="badge badge-pill badge-light" data-container="body" data-toggle="popover" data-placement="top" data-content="To show the reduced price move the prodcut's orignal price into Comapre at price"><i class="fa fa-question "></i></span></label>
                            <input type="text" id="pro_offer_price" class="form-control" name="pro_offer_price" placeholder="Discount Price" required>
                        </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-md-6">
                      <label> Cost Per Item *:</label>
                      <input type="text" id="costperitem" onKeyUp="calculatemargin();" class="form-control" name="costperitem" placeholder="Cost Per item" required>
                      <small>Customers won’t see this</small>
                      </div>
                      <div class="col-md-3 pd-t-25 pd-l-25">
                      <label class="">Margin</label><br>
                          <span id="margin"></span>
                      </div>
                      <div class="col-md-3 pd-t-25 pd-l-25">
                      <label>Profit Per Item</label><br>
                          <sapn id="prfit"></span>
                      </div>
              </div>
              <div class="custom-control custom-checkbox mg-t-20">
                <input type="checkbox" class="custom-control-input" id="protax" name="protax">
                <label class="custom-control-label" for="protax">Charge tax on this product</label>
              </div>
               </p>
            </div>
          </div>
          <div class="card mg-t-20">
          <div class="card-body">
            <h6 class="card-title">Inventry</h6>
          <p class="card-text" > <div class="row ">
                <div class="col-md-6">
              <label> SKU(Stock Keeping Unit) *:</label>
              <input type="text" id="sku" class="form-control" name="sku" placeholder="Product Stock" required>
              </div>
              <div class="col-md-6">
              <label>Barcode(ISBN,UPC,GTIN etc) *:</label>
                  <input type="text" id="barcode" class="form-control" name="barcode" placeholder="Barcode(ISBN,UPC,GTIN etc)" required>
              </div>

            </div>
            <div class="custom-control custom-checkbox mg-t-20">
              <input type="checkbox" class="custom-control-input" id="protrack" name="protrack">
              <label class="custom-control-label" for="protrack">Track Quantity</label>
            </div>

</p>
          </div>
        </div>
        <div class="card mg-t-20">
        <div class="card-body">
          <h6 class="card-title" >Shipping</h6>
          <p class="card-text">
            <div class="row">
              <div class="col-md-6">
                <label>Shipping Method *:</label>
                <select class="form-control" name="smethod" id="smethod">
                  <option value="0">--Select Method--</option>
                    <option value="1">Free</option>
                      <option value="2">Paid</option>
                            </select>
              </div>
              <div class="col-md-6">
                <label> Shipping Amount</label>
                <input type="text" id="samount" class="form-control" name="samount" placeholder="Shipping Amount" >
              </div>
            </div>
            <hr>
        <div class="row">
          <div class="col-md-3">
          <label> Weight :(gram)</label>
          <input type="text" id="weight" class="form-control" name="weight" placeholder="Weight(in gram)" >
          </div>
          <div class="col-md-3">
          <label>Length :</label>
              <input type="text" id="length" class="form-control" name="length" placeholder="Lenght" >
          </div>
          <div class="col-md-3">
          <label>Width :</label>
              <input type="text" id="width" class="form-control" name="width" placeholder="Width" >
          </div>
          <div class="col-md-3">
          <label>Height :</label>
              <input type="text" id="height" class="form-control" name="height" placeholder="Height" >
          </div>
          </div>
          <div class="row">
            <div class="col-md-12">
            <label>Delivery Date *:</label>
            <select class="form-control" name="dldate" id="dldate">
              <option value="0">Delivery Date</option>
              <?php for ($i=1; $i <30 ; $i++) {?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?> Days</option>
          <?php  } ?>
            </select>
            </div>
          </div>
          </p>
        </div>
      </div>
      </div>
        <div class="col-md-4">
          <div class="card">
          <div class="card-body">
            <h6 class="card-title">Product Type</h6>
            <p class="card-text">
              <div class="row row-xs">
                <label>View Type *:</label>
						        <select id="view_type" name="view_type" class="form-control">
								<option value="1"<?php if($fetch['type']=='1'){?>selected<?php } ?>>New</option>
								<option value="2" <?php if($fetch['type']=='2'){?>selected<?php } ?>>Hot</option>
								<option value="3" <?php if($fetch['type']=='3'){?>selected<?php } ?>>Sale</option>
								</select>
                <label>Status *:</label>
                    <select id="status" name="status" class="form-control">
                <option value="1" <?php if($fetch['status']=='1'){?>selected<?php } ?>>Active</option>
                <option value="0" <?php if($fetch['status']=='0'){?>selected<?php } ?>>Block</option>
                </select>
              </div>
            </p>
          </div>
        </div>
        <div class="card mg-t-20">
        <div class="card-body">
          <h6 class="card-title">Product Category</h6>
          <p class="card-text">
            <div class="row row-xs">
                <label>Select Category *:</label>
              <input type="hidden" value="<?php echo $fetch['id']?>" name="hId">
              <select id="cat" name="cat" class="form-control select2" required>
                          <option value="0">--Select Product Category--</option>
                  <?php $optqry=mysqli_query($con,"select* from category order by id desc;");
                  $num=mysqli_num_rows($optqry);
                  if($num>0){
                    while($opt=mysqli_fetch_array($optqry)){
                  ?><option value="<?php echo $opt['id']?>" <?php if($fetch['category_id']==$opt['id']){?>selected<?php } ?>><?php echo $opt['name']?></option>
                  <?php } } else {?>
                  <option value="0">Not Found</option>
                  <?php }?>
                  </select>
              <label>Sub Category *:</label>
              <select id="subcat" name="subcat" class="form-control select2" required>
              <?php $sid=$fetch['subcategory_id'];$optqry2=mysqli_query($con,"select* from subcategory where id='$sid' order by id desc;");
                  $num2=mysqli_num_rows($optqry2);
                  if($num2>0){
                    while($opt2=mysqli_fetch_array($optqry2)){
                  ?><option value="<?php echo $opt2['id']?>" <?php if($fetch['subcategory_id']==$opt2['id']){?>selected<?php } ?>><?php echo $opt2['name']?></option>
                  <?php } } else {?>
                  <option value="0">--Not Found--</option>
                  <?php }?>
              </select>
            </div>
          </p>
        </div>
      </div>
      <div class="card mg-t-20">
      <div class="card-body">
        <h6 class="card-title">SEO</h6>
        <p class="card-text">
          <div class="row row-xs">
            <label for="">Page Title</label>
            <input type="text" name="pagetitle" value="" class="form-control">
            <label for="">Page Description</label>
            <textarea name="pagedesp" class="form-control" rows="8" cols="80"></textarea>

          </div>
        </p>
      </div>
    </div>
    <div class="card mg-t-20">
    <div class="card-body">
      <h6 class="card-title">TAGS</h6>
      <p class="card-text">
        <div class="row row-xs">


          <input type="text" id="tags_1" name="tags" rows="8" cols="80" class="form-control"  data-role="tagsinput"/>
        </div>
      </p>
    </div>
  </div>

</div>
		</div>

  </div>
  <hr>
  <div class="row row-xs">
    <div class="col-md-12">
      <div class="d-sm-flex align-items-center justify-content-between">
        <button type="reset" name="Reset" class="btn btn-light">Reset</button>
    <button type="submit" class="btn btn-success" name="submit"><i class="fa fa-save"></i> Save Product</button>

      </div>
    </div>
  </div>
</form>
          </div><!-- row -->
        </div><!-- container -->
      </div>
    </div>

<?php include'include_file/jquery.php'?>
    <script>
      $(function(){
        'use strict'
        $('[data-toggle="popover"]').popover();

        // Primary Header
        $('.select2').select2({
          placeholder: 'Choose one',
          searchInputPlaceholder: 'Search options'
        });


      });
          $(document).ready(function(){
      $("select#cat").change(function(){
        //alert("dsfsd");
          var a=$('#cat').val();
          $.ajax({url:"ajax/getSubcategory.php",type:"post",data:{cid:a},success:function(c)
            {
          $("#subcat").html(c);


          }
        })});
        $(document).on("click",".addcat",function(){
          var a=this.id;
          $("#sub_hId").val(a);
        });
        $(document).on("click",".viewcat",function(){
          var a=this.id;
          $.ajax({url:"ajax/fetchsubcategorydetails.php",type:"post",data:{cid:a},success:function(c)
          {$("#myModalLabel3").html('View Sub Category');

          $("#data_body").html(c);}

        });
          });
        });
      function readURL(input) {
                  if (input.files && input.files[0]) {
                      var reader = new FileReader();
                      $('#viewimg').show();
                      reader.onload = function (e) {
                          $('#pimage')
                              .attr('src', e.target.result);
                      };

                      reader.readAsDataURL(input.files[0]);
                  }
              }
function calculatemargin(){

	var p=document.getElementById('pro_price').value;
	var c=document.getElementById('costperitem').value;

	var mar;
  var cal;
  cal=p-c;
  mar=(cal*100)/p;
  if(c==''){
    document.getElementById('prfit').innerHTML='-';
    document.getElementById('margin').innerHTML='-';
  }else{
	document.getElementById('prfit').innerHTML=cal;
  document.getElementById('margin').innerHTML=mar+'%';
}
//  alert(p-c);
}
    </script>
  </body>
</html>
