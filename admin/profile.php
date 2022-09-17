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
checkIntrusion($adminId);
$date=date('d-m-Y');
$qry=mysqli_query($con,"select * from websiteheader where id='$webId'");
$hqry=mysqli_fetch_array($qry);
if(isset($_POST['update'])){
extract($_POST);
$id=$_POST['hidid'];
$crmname=$_POST['name'];
$crmtitle=$_POST['contact'];
$crmtagline=$_POST['tagline'];
$color=$_POST['color'];
$sts=$_POST['sts'];
$slug=strtolower($_POST['slug']);
$sts=$_POST['sts'];
$tnc=$_POST['tnc'];
$privacy=$_POST['privacy'];
$hidslug=strtolower($_POST['hidslug']);
$filename = $_FILES['image']['name'];
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
if($hidslug==$slug){
if($filename!=''&& $filename!=''){
$sqlQry="UPDATE `websiteheader` SET `site_name`='$crmname',`site_logo`='$filename',`site_contact`='$crmtitle',`assign_to`='$emp_id',`site_tagline`='$crmtagline',`status`='$sts',`color`='$color',`date`='$date',`slug`='$slug',`tnc`='$tnc',`privacy`='$privacy'
WHERE `id` = '$id'";
}else{
$sqlQry="UPDATE `websiteheader` SET `site_name`='$crmname',`site_contact`='$crmtitle',`site_tagline`='$crmtagline',`assign_to`='$emp_id',`status`='$sts',`color`='$color',`date`='$date',`slug`='$slug',`tnc`='$tnc',`privacy`='$privacy'  WHERE `id` = '$id'";

}
$execQry=mysqli_query($con,$sqlQry);
if($execQry){
header("location:profile.php?msg=ups");
}else{
header("location:profile.php?msg=upf");
}
}else{
   if (checkcustomerSlug($slug)=='0') {
    if($filename!=''&& $filename!=''){
    $sqlQry="UPDATE `websiteheader` SET `site_name`='$crmname',`site_logo`='$filename',`site_contact`='$crmtitle',`assign_to`='$emp_id',`site_tagline`='$crmtagline',`status`='$sts',`color`='$color',`date`='$date',`slug`='$slug',`tnc`='$tnc',`privacy`='$privacy'
    WHERE `id` = '$id'";
    }else{
    $sqlQry="UPDATE `websiteheader` SET `site_name`='$crmname',`site_contact`='$crmtitle',`site_tagline`='$crmtagline',`status`='$sts',`assign_to`='$emp_id',`color`='$color',`date`='$date',`slug`='$slug',`tnc`='$tnc',`privacy`='$privacy'  WHERE `id` = '$id'";

    }
    $execQry=mysqli_query($con,$sqlQry);
    if($execQry){
    header("location:profile.php?msg=ups");
    }else{
    header("location:profile.php?msg=upf");
    }
  }else{
    header("location:profile.php?msg=url");
  }
}
}
if(isset($_GET['msg'])&&$_GET['msg']!=''){
$msg=$_GET['msg'];

switch($msg){
case 'ins':
$msg='<strong>Success!</strong> Profile data has been added Successfully !!';
$class='success';
break;

case 'url':
$msg=' Customer slug allready exists !!';
$class='danger';
break;
case 'ups':
$msg='<strong>Success!</strong> Profile data updated Successfully !!';
$class='success';
break;

case 'upf':
$msg='Profile data not updated Successfully !!';
$class='danger';
break;
case 'default' :
$msg='';
break;

}
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Profile | <?php echo getSiteTitle($webId); ?> </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include 'css.php'; ?>
<link href="assets/libs/spectrum-colorpicker2/spectrum.min.css" rel="stylesheet" type="text/css">
<script src="assets/libs/jquery/jquery.min.js"></script>
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
<div class="page-content" >
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
<div class="container-fluid" >
    <div class="row">
<div class="col-6">
<div class="page-title-box  align-items-center justify-content-between">
<h4 class="mb-3 font-size-18">Profile</h4>

                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                           
                                            <li class="breadcrumb-item active">Profile</li>
                                        </ol>
                                  

</div>
</div>
<div class="col-6" style="text-align:right">
    <div class="page-title-right ">
</div>
</div>
</div>
<div class="row">
<div class="col-xl-12">
<?php if($msg!=''){ ?>
<div class="alert alert-<?php echo $class ?> alert-dismissible fade show" role="alert">
<?php echo $msg; ?>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php } ?></div></div>

<div class="row">
<div class="col-xl-12">
<div class="card overflow-hidden">
<div class="">
<div class="row">
<div class="col-7">
<div class="p-3">
<form  id="myform" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="hidid" value="<?php echo $hqry['id'] ?>">
<div class="row">
<div class="col-md-6">
<div class="mb-3">
<label for="formrow-name-input" class="form-label">Name <span style="color:red">*</span></label>
<input onKeyUp="fillPrintableName()" type="text" class="form-control" id="name" name="name" value="<?php echo $hqry['site_name'] ?>">
</div>
<div class="mb-3">
<label for="TagLine" class="form-label"> Slug <span style="color:red">*</span></label>
<input style="text-transform:lowercase;" type="text" class="form-control" id="slug" name="slug" value="<?php echo $hqry['slug'] ?>" >
<input style="text-transform:lowercase;" type="hidden" class="form-control" id="hidslug" name="hidslug" value="<?php echo $hqry['slug'] ?>" >

</div>
<div class="mb-3">
<label for="TagLine" class="form-label"> TagLine </label>
<input type="text" class="form-control" id="tagline" name="tagline" value="<?php echo $hqry['site_tagline'] ?>" >
</div>
<div class="mb-3">
<label for="formrow-inputContact" class="form-label"> Contact <span style="color:red"></span></label>
<input type="text" class="form-control" id="contact" name="contact" value="<?php echo $hqry['site_contact'] ?>" >
</div>

</div>


<div class="col-md-6">
<div class="mb-3">
<label for="formrow-logo-input" class="form-label"> Logo <span style="color:red">*</span></label><br>
<div style="width:100%;margin: 0px auto 25px;overflow:hidden;padding:10px;border:1px dashed #ddd;text-align:center;">
<img id="pimage" src="../assets/img/<?php echo $hqry['site_logo'] ?>"  alt="" style="width: 100px;
    margin: 0 10px 0 20px;">
</div>

<input style="" class="form-control " id="image" type="file" name="image" onchange="readURL(this);">
</div>

<div class="mb-3">
<label for="formrow-inputContact" class="form-label"> Assign To <span style="color:red">*</span></label>
<select class="form-select" name="emp_id" id="emp_id">
<option value="0">Select Employee</option>
<?php $qry=mysqli_query($con,"select * from admin where status='1'");
$num=mysqli_num_rows($qry);
if ($num>0) {
while ($emp=mysqli_fetch_array($qry)) {?>
<option <?php if ($emp['id']==$hqry['assign_to']) { ?>selected <?php } ?>value="<?php echo $emp['id'] ?>"><?php echo $emp['username'] ?></option>
<?php }}else{ ?>
<option value="0">--No Record found--</option>
<?php } ?>
</select>
</div>
<div class="mb-3">
<label for="formrow-inputContact" class="form-label"> Status <span style="color:red">*</span></label>
<select class="form-select" name="sts" id="sts">
<option <?php if ($hqry['status']=='1') { ?>selected <?php } ?> value="1">Active</option>
<option <?php if ($hqry['status']=='0') { ?>selected <?php } ?> value="0">Inactive</option>
</select>
</div>
</div>
<div class="col-md-4">
<div class="mb-3">
<label class="form-label">Color</label>
<input type="text" name="color" required class="form-control" id="colorpicker-default" value="<?php echo $hqry['color'] ?>">
</div>
</div>
<div class="col-md-4">
<div class="mb-3">
<label class="form-label">Terms & Condition URL</label>
<input type="text" name="tnc" required class="form-control" id="tnc" value="<?php echo $hqry['tnc'] ?>">
</div>
</div>
<div class="col-md-4">
<div class="mb-3">
<label class="form-label">Privacy Policy</label>
<input type="text" name="privacy" required class="form-control" id="privacy" value="<?php echo $hqry['privacy'] ?>">
</div>
</div>

</div>
<div >
<button type="submit" name="update" class="btn btn-primary w-md btn-md">Update</button> <button style="margin-left:10px" type="button" onclick="goBack()"name="cancel" class="btn btn-outline-primary btn-md w-md">Cancel</button>
</div>
<div>

</div>
</form>   </div>
</div>
<div class="col-5 align-self-end">
<img src="assets/images/verification-img.png" height="330" width="330" alt="" class="img-fluid">
</div>
</div>
</div>

</div>
</div>
</div>
</div>
<!-- container-fluid -->
</div>
<!-- End Page-content -->

</div>
<!-- end main content-->
</div>
<!-- END layout-wrapper -->
<?php include 'script.php'; ?>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="http://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
<script type="text/javascript">
function changeUrl() {
  alter('val');
}
function goBack() {
  window.history.go(-1);
}
function fillPrintableName(){
var fname=document.getElementById('name').value;
var c=fname.replace(/\s/g, '-')
var nameoncard =document.getElementById('slug');
nameoncard.value=c;
}
$(document).ready(function() {

$('#myform').validate({
rules: {
name: "required",
slug:"required",
contact: {
number: true,
minlength: 10,
maxlength: 10
},
formFileSm: "required"
},
messages: {
name: "Please enter name",
slug:"Plese enter slug",
contact: {

minlength: "Please enter 10 digit contact no",
maxlength: "Please enter 10 digit contact no"
},
formFileSm: "Please select logo"
},
submitHandler: function(form) { // for demo
form.submit();
}
});

});
</script>
<script src="assets/libs/select2/js/select2.min.js"></script>

<script src="assets/libs/spectrum-colorpicker2/spectrum.min.js"></script>


<!-- form advanced init -->
<script src="assets/js/pages/form-advanced.init.js"></script>
</body>
</html>
