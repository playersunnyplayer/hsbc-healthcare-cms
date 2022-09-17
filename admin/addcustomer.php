<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
session_start();
$adminId=$_SESSION['aid'];
include_once("configuration/connect.php");
include_once("configuration/functions.php");
//header('Content-type: application/json');
if(isset($_SESSION["aid"])) {
if(isLoginSessionExpired()) {
header("Location:logout.php");
}
}
checkIntrusion($adminId);
$date=date('d-m-Y h:i:sa');

if(isset($_POST['addcomp'])){
extract($_POST);
$crmname=$_POST['name'];
$crmtitle=$_POST['contact'];
$crmtagline=$_POST['tagline'];
$slug=strtolower($_POST['slug']);
$color=$_POST['color'];
$emp_id=$_POST['emp_id'];
$tnc=$_POST['tnc'];
$privacy=$_POST['privacy'];
$loginurl=$_POST['loginurl'];
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
if(checkcustomerSlug($slug)==0){
$sqlQry="INSERT INTO `websiteheader`(`id`, `site_name`, `slug`,`site_logo`,`site_icon` ,`site_contact`, `site_tagline`, `color`, `emp_id`, `assign_to`, `up_id`,`tnc`,`privacy`,`loginurl` ,`date`, `status`)
VALUES (NULL,'$crmname','$slug','$filename','$iconfile','$crmtitle','$crmtagline','$color','$adminId','$emp_id','$adminId','$tnc','$privacy','$loginurl','$date','1')";
$execQry=mysqli_query($con,$sqlQry);
$apiid=mysqli_insert_id($con);
if($execQry){
$logourl="http://cms.dev.patientzone.co.uk/assets/img/".$filename;
$favIcon="http://cms.dev.patientzone.co.uk/assets/img/".$iconfile;
$curl = curl_init();
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
print_r($data2);
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://cs.api.dev.patientzone.co.uk/api-patientzone/theme",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $data2,
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 737a2d62-3698-4007-91cb-b38fef76d438"
  ),
));
$response = curl_exec($curl);
echo $response;
header("location:customers.php?msg=ins");
}else{
header("location:customers.php?msg=upf");
}
}else{
header("location:addcustomer.php?msg=usr");
}
}
if(isset($_GET['msg'])&&$_GET['msg']!=''){
$msg=$_GET['msg'];
switch($msg){
case 'ins':
$msg='<strong>Success!</strong> Customer  has been added Successfully !!';
$class='success';
break;

case 'inf':
$msg='Customer not inserted Successfully !!';
$class='danger';
break;
case 'ups':
$msg='<strong>Success!</strong> Customer data updated Successfully !!';
$class='success';
break;

case 'usr':
$msg='Customer slug is not avilable !!';
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
<title>Add Customer </title>
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
function checkreslug(code) {
if(code.length>=4){
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) {
var b=this.responseText;
var s=b.split('#');
if(s[0]==1){
document.getElementById("cod").innerHTML =s[1];
document.getElementById("cod").style.color = "red";

return false;
}else{
document.getElementById("cod").innerHTML ='Avilable';
document.getElementById("cod").style.color = "green";

}

}
};
xhttp.open("POST", "checkslug.php?code="+code, true);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xhttp.send();

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
                            <div class="col-12">
                                <div class="page-title-box  align-items-center justify-content-between">
                                    <h4 class="mb-3 font-size-18">Add Customer</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="customers.php">Customer</a></li>
                                            <li class="breadcrumb-item active">Add Customer</li>
                                        </ol>
                                    </div>

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
<div class="row">
<div class="col-7">
<div class="p-3">
<form  id="myform" action="" method="post" enctype="multipart/form-data">
<div class="row">
<div class="col-md-6">
<div class="mb-3">
<label for="formrow-name-input" class="form-label">Name <span style="color:red">*</span></label>
<input onKeyUp="fillPrintableName()" type="text" class="form-control" id="name" name="name" value="<?php echo $hqry['site_name'] ?>">
</div>
<div class="mb-3">
<label for="TagLine" class="form-label"> Slug <span style="color:red">*</span></label>
<input style="text-transform:lowercase" onKeyup="checkreslug(this.value)" type="text" class="form-control" id="slug" name="slug" value="<?php echo $hqry['slug'] ?>" >
<span  style="color:red"><small id="cod"><?php echo $rftxt?></small></span>

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
<div class="row">
    <div class="col-md-8">
        <label for="formrow-logo-input" class="form-label"> Logo <span style="color:red">*</span></label><br>
<div style="width:100%;margin: 0px auto 25px;overflow:hidden;padding:10px;border:1px dashed #ddd;text-align:center;">
<img id="pimage" src="patientZoneCMSAdmin/src/assets/img/<?php echo $hqry['site_logo'] ?>"  alt="" style="width:70px">
</div>
<input style="margin-top:20px" class="form-control form-control" id="image" type="file" name="image" onchange="readURL(this);">
    </div>
    <div class="col-md-4">
      <label for="image2" class="form-label"> Icon <span style="color:red">*</span></label><br>
<div style="width:100%;margin: 0px auto 25px;overflow:hidden;padding:10px;border:1px dashed #ddd;text-align:center;">
<img id="pimage2" src="patientZoneCMSAdmin/src/assets/img/<?php echo $hqry['site_logo'] ?>"  alt="" style="width:20px">
</div>
<input style="margin-top:20px" class="form-control form-control" id="image2" type="file" name="image2" onchange="readURL2(this);">  
    </div>
</div>

</div>

<div class="mb-3">
<label for="formrow-inputContact" class="form-label"> Assign To <span style="color:red">*</span></label>
<select class="form-select" name="emp_id" id="emp_id">
<option value="">Select Employee</option>
<?php $qry=mysqli_query($con,"select * from admin where status='1'");
$num=mysqli_num_rows($qry);
if ($num>0) {
while ($emp=mysqli_fetch_array($qry)) {?>
<option <?php if ($emp['id']=='1') { ?>selected <?php } ?>value="<?php echo $emp['id'] ?>"><?php echo $emp['username'] ?></option>
<?php }}else{ ?>
<option value="0">--No Record found--</option>
<?php } ?>
</select>
</div>
<div class="mb-3">
<label for="formrow-inputContact" class="form-label"> Status <span style="color:red">*</span></label>
<select class="form-select" name="sts" id="sts">
<option value="1">Active</option>
<option value="0">Inactive</option>
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
<div><button type="submit" name="addcomp" id="addcomp" class="btn btn-success waves-effect waves-light btn-md w-md">Add </button> <button style="margin-left:10px" onclick="goBack()" type="button" name="cancel" class="btn btn-outline-success waves-effect waves-light btn-md w-md">Cancel </button></div>
</form>
</div>
</div>
<div class="col-5 align-self-end">
<img src="assets/images/verification-img.png" alt="" class="img-fluid">
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
