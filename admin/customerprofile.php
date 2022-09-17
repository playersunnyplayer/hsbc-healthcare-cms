<?php
ob_start();
session_start();
$adminId=$_SESSION['aid'];
include_once("configuration/connect.php");
include_once("configuration/functions.php");
if(isset($_SESSION["aid"])) {
if(isLoginSessionExpired()) {
header("Location:logout.php");
}
}
checkIntrusion($adminId);
$date=date('d-m-Y');

if(isset($_POST['update'])){
extract($_POST);
$id=$_POST['hidid'];
$cmp_id=base64_encode($id);
$crmname=$_POST['name'];
$crmtitle=$_POST['contact'];
$crmtagline=$_POST['tagline'];
$color=$_POST['color'];
$emp_id=$_POST['emp_id'];
$slug=strtolower($_POST['slug']);
$sts=$_POST['sts'];
$tnc=$_POST['tnc'];
$privacy=$_POST['privacy'];
$loginurl=$_POST['loginurl'];
$hidslug=strtolower($_POST['hidslug']);
$filename = $_FILES['image']['name'];
$iconfile = $_FILES['image2']['name'];
$valid_ext = array('png','jpeg','jpg','ico');
$location2="/var/www/html/cms.patientzone.co.uk/assets/img/".$iconfile;
$location ="/var/www/html/cms.patientzone.co.uk/assets/img/".$filename;
$file_extension = pathinfo($location, PATHINFO_EXTENSION);
$file_extension = strtolower($file_extension);
move_uploaded_file($_FILES['image']['tmp_name'],$location);
move_uploaded_file($_FILES['image2']['tmp_name'],$location2);
/*if(in_array($file_extension,$valid_ext)){
compressImage($_FILES['image']['tmp_name'],$location,60);
}else{
echo "Invalid file type.";
}*/
if($filename!='')
{
    $fname=$_FILES['image']['name'];
}else{
    $fname=$_POST['hidlogo'];
}
if($iconfile!='')
{
    $icon=$_FILES['image2']['name'];
}else{
    $icon=$_POST['hidicon'];
}
if($hidslug==$slug){
$sqlQry="UPDATE `websiteheader` SET `site_name`='$crmname',`site_logo`='$fname',`site_icon`='$icon',`site_contact`='$crmtitle',`assign_to`='$emp_id',`site_tagline`='$crmtagline',`status`='$sts',`color`='$color',`date`='$date',`slug`='$slug',`tnc`='$tnc',`privacy`='$privacy',`loginurl`='$loginurl'
WHERE `id` = '$id'";
$execQry=mysqli_query($con,$sqlQry);
 $apiid=$id;
if($execQry){
    $curl = curl_init();
    $logourl="http://cms.dev.patientzone.co.uk/assets/img/".$fname;
$favIcon="http://cms.dev.patientzone.co.uk/assets/img/".$icon;
$apiid=$id;
$data=array(
"id"=> $slug,
"identifier"=> $slug,
"logoUrl"=> $logourl,
"faviconIcon"=> $favIcon,
"color"=> $color,
"loginUrl"=> $loginurl,
"termsUrl"=> $tnc,
"privacyPolicyUrl"=> $privacy
);
$data2=json_encode($data);
//print_r($data2);
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://cs.api.dev.patientzone.co.uk/api-patientzone/theme/".$slug,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "PUT",
  CURLOPT_POSTFIELDS => $data2,
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 737a2d62-3698-4007-91cb-b38fef76d438"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
header("location:customers.php?msg=ups");
}else{
header("location:customers.php?msg=upf");
}
}
else{
  if (checkcustomerSlug($slug)=='0') {
    $sqlQry="UPDATE `websiteheader` SET `site_name`='$crmname',`site_logo`='$fname',`site_icon`='$icon',`site_contact`='$crmtitle',`assign_to`='$emp_id',`site_tagline`='$crmtagline',`status`='$sts',`color`='$color',`date`='$date',`slug`='$slug',`tnc`='$tnc',`privacy`='$privacy',`loginurl`='$loginurl'
    WHERE `id` = '$id'";
    $execQry=mysqli_query($con,$sqlQry);
    $apiid=$id;
if($execQry){
$curl = curl_init();
$data=array(
"id"=> $apiid,
"identifier"=> $slug,
"logoUrl"=> $logourl,
"faviconIcon"=> $favIcon,
"color"=> $color,
"loginUrl"=> $loginurl,
"termsUrl"=> $tnc,
"privacyPolicyUrl"=> $privacy
);
$data2=json_encode($data);
//print_r($data2);
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://cs.api.dev.patientzone.co.uk/api-patientzone/theme/".$slug,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "PUT",
  CURLOPT_POSTFIELDS => $data2,
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 737a2d62-3698-4007-91cb-b38fef76d438"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

    header("location:customers.php?msg=ups");
    }else{
    header("location:customers.php?msg=upf");
    }
  }else{
    header("location:customerprofile.php?msg=url&cmp_id=$apiid");
  }
}
}
if(isset($_GET['cmp_id'])&&$_GET['cmp_id']!=''){
$cmp=base64_decode($_GET['cmp_id']);
$qry=mysqli_query($con,"select * from websiteheader where id='$cmp'");
$hqry=mysqli_fetch_array($qry);
}
if(isset($_GET['msg'])&&$_GET['msg']!=''){
$msg=$_GET['msg'];

switch($msg){
case 'ins':
$msg='<strong>Success!</strong> Profile data has been added Successfully !!';
$class='success';
break;
case 'url':
$msg='Customer slug allready exists !!';
$class='danger';
break;
case 'inf':
$msg=' Profile data not inserted Successfully !!';
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
<title>Customer Profile </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include 'css.php'; ?>
<link href="assets/libs/spectrum-colorpicker2/spectrum.min.css" rel="stylesheet" type="text/css">
<script src="assets/libs/jquery/jquery.min.js"></script>

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
function readURL2(input) {
if (input.files && input.files[0]) {
var reader = new FileReader();

reader.onload = function (e) {
$('#pimage2')
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
<div class="container-fluid mt-3">
<div class="row">
<div class="col-6">
<div class="page-title-box  align-items-center justify-content-between">
<h4 class="mb-3 font-size-18">Customer Profile</h4>

                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item "><a href="customers.php">Customers</a></li>
                                            <li class="breadcrumb-item active">Customer Profile</li>
                                        </ol>
                                  

</div>
</div>
<div class="col-6" style="text-align:right">
    <div class="page-title-right ">
<!--<a href="addcustomer.php"	<button type="button" class="btn btn-primary btn-md waves-effect waves-light">Add New</button></a>-->
</div>
</div>
</div>
<div class="row">
<div class="col-12">
<?php if($msg!=''){ ?>
<div class="alert alert-<?php echo $class ?> alert-dismissible fade show" role="alert">
<?php echo $msg; ?>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php } ?>
</div>
</div>
<div class="row">
<div class="col-xl-12">
<div class="card overflow-hidden">
<div class="">
<div class="row ">
<div class="col-7">
<div class=" p-3">

<form  id="myform" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="hidid" value="<?php echo $hqry['id'] ?>">
<div class="row">
<div class="col-md-6">
<div class="mb-3">
<label for="formrow-name-input" class="form-label">Name <span style="color:red">*</span></label>
<input type="text" class="form-control" id="name" name="name" value="<?php echo $hqry['site_name'] ?>">
</div>
<div class="mb-3">
<label for="TagLine" class="form-label"> Slug <span style="color:red">*</span></label>
<input style="text-transform:lowercase" type="text" class="form-control" id="slug" name="slug" value="<?php echo $hqry['slug'] ?>" >
<input style="text-transform:lowercase;" type="hidden" class="form-control" id="hidslug" name="hidslug" value="<?php echo $hqry['slug'] ?>" >

</div>
<div class="mb-3">
<label for="TagLine" class="form-label"> TagLine </label>
<input type="text" class="form-control" id="tagline" name="tagline" value="<?php echo $hqry['site_tagline'] ?>" >
</div>
<div class="mb-3">
<label for="formrow-inputContact" class="form-label"> Contact  <span style="color:red"></span></label>
<input type="text" class="form-control" id="contact" name="contact" value="<?php echo $hqry['site_contact'] ?>" >
</div>
</div>


<div class="col-md-6">
<div class="row">
    <div class="col-md-8">
        <label for="formrow-logo-input" class="form-label"> Logo <span style="color:red">*</span></label><br>
<div style="width:100%;margin: 0px auto 25px;overflow:hidden;padding:10px;border:1px dashed #ddd;text-align:center;">
<img id="pimage" src="../assets/img/<?php echo $hqry['site_logo'] ?>"  alt="" style="width:70px">
<input type="hidden" name="hidlogo" value="<?php echo $hqry['site_logo'] ?>"/>
</div>
<input style="margin-top:20px" class="form-control form-control" id="image" type="file" name="image" onchange="readURL(this);">
    </div>
    <div class="col-md-4">
      <label for="image2" class="form-label"> Icon <span style="color:red">*</span></label><br>
<div style="width:100%;margin: 0px auto 25px;overflow:hidden;padding:10px;border:1px dashed #ddd;text-align:center;">
<img id="pimage2" src="../assets/img/<?php echo $hqry['site_icon'] ?>"  alt="" style="width:20px">
<input type="hidden" name="hidicon" value="<?php echo $hqry['site_icon'] ?>"/>
</div>
<input style="margin-top:20px" class="form-control form-control" id="image2" type="file" name="image2" onchange="readURL2(this);">  
    </div>
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
<div class="col-md-6">
<div class="mb-3">
<label class="form-label">Color <span style="color:red">*</span></label>
<input type="text" name="color" required class="form-control" id="colorpicker-default" value="<?php echo $hqry['color'] ?>">
</div>
</div>
<div class="col-md-6">
<div class="mb-3">
<label class="form-label">Login Url <span style="color:red">*</span></label>
<input type="text" name="loginurl" required class="form-control" id="loginurl" value="<?php echo $hqry['loginurl'] ?>">
</div>
</div>
<div class="col-md-6">
<div class="mb-3">
<label class="form-label">Terms & Condition URL <span style="color:red">*</span></label>
<input type="text" name="tnc" required class="form-control" id="tnc" value="<?php echo $hqry['tnc'] ?>">
</div>
</div>
<div class="col-md-6">
<div class="mb-3">
<label class="form-label">Privacy Policy <span style="color:red">*</span></label>
<input type="text" name="privacy" required class="form-control" id="privacy" value="<?php echo $hqry['privacy'] ?>">
</div>
</div>
</div>
<div >
<button type="submit" name="update" class="btn btn-success w-md btn-md">Update </button>  <button style="margin-left:10px" onclick="goBack()" type="button" name="cancel" class="btn btn-outline-success btn-md w-md">Cancel </button>
</div>
<div>

</div>
</form>
</div>
</div>
<div class="col-5 align-self-end">
<img src="assets/images/profile-img.png" alt="" class="img-fluid">
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
function goBack() {
window.history.go(-1);
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

color:"required",
loginurl:"required",
emp_id:"required",
tnc:"required",
privacy:"required"
},
messages: {
name: "Please enter name",
slug:"Please enter slug",
contact: {
minlength: "Please enter 10 digit contact no",
maxlength: "Please enter 10 digit contact no"
},
color: "Please select color",

emp_id:"Plese select employee",
tnc:"Plese enter url",
privacy:"Plese enter url",
loginurl:"Plese enter login url",
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
