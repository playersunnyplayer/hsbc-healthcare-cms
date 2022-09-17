<?php
ob_start();
session_start();
$adminId=$_SESSION['aid'];
$webId=$_SESSION['web'];
include_once("configuration/connect.php");
include_once("configuration/functions.php");
if(isset($_SESSION["aid"])) {
if(isLoginSessionExpired()) {
header("Location:logout.php");
}
}
$date=date('d-m-Y h:i:sa');
checkIntrusion($adminId);
if(isset($_POST['addhome'])){
	extract($_POST);
	$web=$_POST['hidid'];
//	$pid=base64_encode(1);
	$content=$_POST['content'];
	$filename = date('YmdHis')."_".$_FILES['image']['name'];
  $valid_ext = array('png','jpeg','jpg','ico');
  $location2="../assets/img/".$filename;
  $location = "../assets/img/".$filename;
  $file_extension = pathinfo($location, PATHINFO_EXTENSION);
  $file_extension = strtolower($file_extension);
  if(in_array($file_extension,$valid_ext)){
    compressImage($_FILES['image']['tmp_name'],$location,60);
	  }else{
    echo "Invalid file type.";
	  }
	$sqlQry="INSERT INTO `websitehomepage`(`id`, `header_id`, `content`, `img`, `status`, `up_id`, `date`)
	VALUES (NULL,'$web','$content','$filename','1','$adminId','$date')";
$excQry=mysqli_query($con,$sqlQry);
$insId=mysqli_insert_id($con);
	$pid=base64_encode($insId);
 if($excQry ){
		header("location:viewhomepage.php?msg=ins&pid=$pid");
	}else{
		header("location:viewhomepage.php?msg=inf&pid=$pid");
	}
	}
if(isset($_POST['addpage'])){
	extract($_POST);
	$id=$_POST['hidid'];
	$pid=base64_encode(id);
	$content=$_POST['content'];
$filename2=$_FILES['image2']['name'];
	$filename = date('YmdHis')."_".$_FILES['image2']['name'];
  $valid_ext = array('png','jpeg','jpg','ico');
   $location2="../assets/img/".$filename;
  $location = "../assets/img/".$filename;
  $file_extension = pathinfo($location, PATHINFO_EXTENSION);
  $file_extension = strtolower($file_extension);
  if(in_array($file_extension,$valid_ext)){
    compressImage($_FILES['image2']['tmp_name'],$location,60);
	  }else{
    echo "Invalid file type.";
	  }

	if($filename2!=''&& $filename2!=''){
	$sqlQry="UPDATE `websitehomepage` SET `content`='$content',`img`='$filename',`status`='1',`date`='$date',`up_id`='$adminId' WHERE `id` =$id";
 }else{
	 	$sqlQry="UPDATE `websitehomepage` SET `content`='$content',`status`='1',`date`='$date',`up_id`='$adminId' WHERE `id` = '$id' ";

 }
$excQry=mysqli_query($con,$sqlQry);
 if($excQry ){
		header("location:viewhomepage.php?msg=ins&pid=$pid");
	}else{
		header("location:viewhomepage.php?msg=inf&pid=$pid");
	}
	}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Update Home Page| <?php echo getSiteTitle($webId); ?> </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include 'css.php'; ?>
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script>
function myFunction() {
  var x = document.getElementById("mySelect").value;
	window.location.href="dashboard.php?web="+x;
}
</script>
<script>
function readURL(input) {
		if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
						$('#pimage')
								.attr('src', e.target.result);
				};

				reader.readAsDataURL(input.files[0]);
		}
}
</script>
</head>
<body >
<!-- Begin page -->
<div id="layout-wrapper">
<?php include 'header.php'; ?>
<!-- ========== Left Sidebar Start ========== -->
<?php include 'leftmenu.php'; ?>
<!-- Left Sidebar End -->
<div class="main-content">
<div class="page-content">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-3"></div>
	<div class="col-md-2"></div>
		<div class="col-md-4" >
			<select  class="form-control select2" style="width:250px" id="mySelect" onchange="myFunction()" >
				<?php $qry=mysqli_query($con,"select * from websiteheader where assign_to='$adminId'");
				$num=mysqli_num_rows($qry);
				if($num>0){
				while ($fetch=mysqli_fetch_array($qry)) {
				?>
				<option value="<?php echo base64_encode($fetch['id']) ?>"   <?php if ($webId==$fetch['id']){ ?>selected<?php } ?>><?php echo $fetch['site_name'] ?></option>
				<?php }} ?>
			</select>
			<a target="_blank" href="http://cms.dev.patientzone.co.uk/#/<?php echo getCustomerSlugById($webId) ?>" ><button class="btn btn-success "> <i class="fas fa-globe"></i> Launch</button> </a>
		</div>
	</div>
<div class="container-fluid">
	<?php if(isset($_GET['home'])&&$_GET['home']!=''){?>
	    <div class="row">
<div class="col-6">
<div class="page-title-box  align-items-center justify-content-between">
<h4 class="mb-3 font-size-18">Add Home</h4>

                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                           <li class="breadcrumb-item"> <a href="viewpage.php">Pages</a></li>
                                            <li class="breadcrumb-item active">All Home</li>
                                        </ol>
                                  

</div>
</div>
<div class="col-6" style="text-align:right">
    <div class="page-title-right ">
</div>
</div>
</div>
	<?php if($msg!=''){ ?>
	<div class="alert alert-<?php echo $class ?> alert-dismissible fade show" role="alert">
	<?php echo $msg; ?>
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
	<?php } ?>
	<form id="myform" action="" method="post"   enctype="multipart/form-data">
		<input type="hidden" name="hidid" value="<?php echo $webId ?>">
	<div class="row">
	<div class="col-lg-12">
	<div class="card">
	<div class="card-body">
		<div class="row">
			<div  class="mb-3 col-lg-6">
			<label for="name">Content</label><textarea id="editor" name="content" class="form-control"><?php echo $fetch['content'] ?></textarea>
			<div  class="mb-3 col-lg-12" style="padding-top:25px"><label for="name">Image</label><input class="form-control form-control" id="image" type="file" name="image" onchange="readURL(this);"></div>

		</div>
			<div  class="mb-3 col-lg-6" >
				<label for="name">Image</label>	<br>
				<img id="pimage" style="max-width: 100%;" src="../assets/img/<?php echo $fetch['img'] ?>"  alt="">
			</div>
			</div>
			<div class="row">
			</div>



		<div class="row">
			<div class="mb-3 col-md-4">
			    <button type="submit" name="addhome" class="btn btn-success w-md btn-md">Add</button> <button style="margin-left:10px" type="reset" name="resetpage" onclick="goBack()" class="btn btn-outline-success btn-md w-md">Cancel</button>
			</div>

		</div>
	</div>
	</div>
	</div>
	</div>
	</form>
	<?php	} else{?>
    <div class="row">
<div class="col-6">
<div class="page-title-box  align-items-center justify-content-between">
<h4 class="mb-3 font-size-18">Update Home</h4>

                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                           <li class="breadcrumb-item"> <a href="viewpage.php">Pages</a></li>
                                            <li class="breadcrumb-item active">Update Home</li>
                                        </ol>
                                  

</div>
</div>
<div class="col-6" style="text-align:right">
    <div class="page-title-right ">
</div>
</div>
</div>
<?php if($msg!=''){ ?>
<div class="alert alert-<?php echo $class ?> alert-dismissible fade show" role="alert">
<?php echo $msg; ?>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php } ?>
<form id="myform" action="" method="post"   enctype="multipart/form-data">

	<?php $fetch=mysqli_fetch_array(mysqli_query($con,"select * from websitehomepage where header_id='$webId'")); ?>
	<input type="hidden" name="hidid" value="<?php echo $fetch['id'] ?>">
<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-body">
	<div class="row">
		<div  class="mb-3 col-lg-6">
		<label for="name">Content</label><textarea id="editor" name="content" class="form-control"><?php echo $fetch['content'] ?></textarea>
		<div  class="mb-3 col-lg-12" style="padding-top:25px"><label for="name">Image</label><input class="form-control form-control" id="image" type="file" name="image2" onchange="readURL(this);"></div>

	</div>
		<div  class="mb-3 col-lg-6" >
			<label for="name">Image</label>	<br><img id="pimage" style="max-width: 100%;" src="../assets/img/<?php echo $fetch['img'] ?>"  alt=""></div>
		</div>
		<div class="row">
		</div>



	<div class="row">
		<div class="mb-3 col-md-4">
		    <button type="submit" name="addpage" class="btn btn-success w-md btn-md">Update</button> <button style="margin-left:10px" type="reset" name="resetpage" onclick="goBack()" class="btn btn-outline-success btn-md w-md">Cancel</button>
		</div>

	</div>
</div>
</div>
</div>
</div>
</form>
<?php } ?>
</div>
</div>
</div>
</div>
<?php include 'script.php'; ?>
<script>
  CKEDITOR.replace( 'editor' );

</script>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="http://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
<script src="assets/libs/select2/js/select2.min.js"></script>
<script src="assets/js/pages/form-advanced.init.js"></script>
<script type="text/javascript">
function goBack() {
  window.history.go(-1);
}
$(document).ready(function() {
$('#myform').validate({
rules: {
		content: {
			required: function()
                        {
                         CKEDITOR.instances.cktext.updateElement();
                        },

                         minlength:1
		},
    image: "required"
},
messages: {
	content: "Please enter the home content",
	image:"Please select an image"

},
submitHandler: function(form) { // for demo
	form.submit();
}
});

});
</script>

	</body>
</html>
