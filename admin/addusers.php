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
$date=date('d-m-Y h:i:sa');
$conn=mysqli_connect('localhost','pzcs','pzcscms','pzcscms')or die('could not establish connection with mysqli');
if(isset($_POST['addemp'])){
extract($_POST);
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$empid=$_POST['empid'];
$email=$_POST['email'];
$uname=$_POST['uname'];
$pwd=$_POST['pwd'];
$sts=$_POST['sts'];

 $admres=mysqli_query($con,"select * from `admin` where `email`='$email'");
  $admres1=mysqli_query($con,"select * from `admin` where `username`='$uname'");
    if(mysqli_num_rows($admres)>0){
      header("location:addusers.php?msg=eml");
    }else if((mysqli_num_rows($admres1)>0)){
         header("location:addusers.php?msg=usr");
    }
    else{
		$conn=mysqli_connect('localhost','pzcs','pzcscms','pzcscms')or die('could not establish connection with mysqli');
$sqlQry="INSERT INTO `admin`(`id`,`emp_id`, `firstname`, `lastname`, `username`, `password`, `email`,`status`,`last_login`, `contact` `loginAccess`, `cookies`, `image`, `fcm`) VALUES (NULL,'$empid','$fname','$lname','$uname','$pwd','$email','$sts','1','2','3','4','4','4')";
$sql1="INSERT INTO `admin`( `firstname`, `lastname`, `username`, `password`, `email`, `last_login`, `contact`, `status`, `emp_id`, `loginAccess`, `cookies`, `image`, `fcm`)
 VALUES ('$fname','$lname','$uname','$pwd','$email','$date','not found','$sts','$empid','1','1','user.png','notdefine')";
$execQry=mysqli_query($con,$sql1);

}
if($execQry){
header("location:users.php?msg=ins");
}else{
header("location:addusers.php?msg=inf");
}

}
if(isset($_POST['updateemp'])){
extract($_POST);
$id=$_POST['hidid'];
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$empid=$_POST['empid'];
$email=$_POST['email'];
$uname=$_POST['uname'];
$pwd=($_POST['pwd']);
$sts=$_POST['sts'];

$sqlQry="UPDATE `admin` SET `firstname`='$fname',`lastname`='$lname',`password`='$pwd',`status`='$sts' WHERE `id`='$id'";
$execQry=mysqli_query($con,$sqlQry);
if($execQry){
header("location:users.php?msg=ups");
}else{
header("location:addusers.php?msg=upf");
}
}
if(isset($_GET['msg'])&&$_GET['msg']!=''){
$msg=$_GET['msg'];

switch($msg){
case 'ins':
$msg='<strong>Success!</strong> User has been added Successfully !!';
$class='success';
break;

case 'inf':
$msg='Profile data not inserted Successfully !!';
$class='danger';
break;
case 'ups':
$msg='<strong>Success!</strong> User updated Successfully !!';
$class='success';
break;
case 'usr':
$msg='Username allready exists !!';
$class='danger';
break;
case 'upf':
$msg='Profile data not updated Successfully !!';
$class='danger';
break;
case 'eml':
$msg='Email id already exists !!';
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
<title>Add User </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include 'css.php'; ?>
<link href="assets/libs/spectrum-colorpicker2/spectrum.min.css" rel="stylesheet" type="text/css">
<script src="assets/libs/jquery/jquery.min.js"></script>
<style media="screen">
.field-icon {
	text-align:center;
float: right;
padding-top: 10px;
padding-right: 10px;
padding-left: 10px;
background-color: #eff2f7;
border: 1px solid #ced4da;
  border-top-right-radius: 5px;
  border-bottom-right-radius: 5px;
margin-top: -36px;
height:35px;
width: 40px;
position: relative;
z-index: 2;
cursor: pointer;
}
</style>
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

 $(document).ready(function() {
           var val ='USR'+ Math.floor(1000 + Math.random() * 9000);
    $('#empid').val(val);
            });
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
<h4 class="mb-3 font-size-18">All Users</h4>

                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="users.php"></a>All Users</li>
                                            <li class="breadcrumb-item active">	<?php if(isset($_GET['emp_id'])&& $_GET['emp_id']!=''){echo 'Update User';}else{ echo 'Add New';}?></li>
                                            
                                        </ol>
                                  

</div>
</div>
<div class="col-6" style="text-align:right">
    <div class="page-title-right ">
<!--<a href="addcompany.php"	<button type="button" class="btn btn-primary btn-md waves-effect waves-light">Add New</button></a>-->
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
	<?php if (isset($_GET['emp_id'])&&$_GET['emp_id']!='') {
	$eid=base64_decode($_GET['emp_id']);
	$qry=mysqli_query($con,"select * from admin where id='$eid'");
	$fetch2=mysqli_fetch_array($qry);?>
<input type="hidden" name="hidid" value="<?php echo $fetch2['id'] ?>">
<div class="row">
<div class="col-md-6">
<div class="mb-3">
<label for="formrow-name-input" class="form-label">First Name <span style="color:red">*</span></label>
<input type="text" class="form-control" id="fname" name="fname" value="<?php echo $fetch2['firstname'] ?>">
</div>
</div>
<div class="col-md-6">
<div class="mb-3">
<label for="formrow-name-input" class="form-label">Last Name </label>
<input type="text" class="form-control" id="lname" name="lname" value="<?php echo $fetch2['lastname'] ?>">
</div>
</div>
</div>
<div class="row">
<div class="col-md-6">
<div class="mb-3">
<label for="formrow-name-input" class="form-label">User Id <span style="color:red">*</span></label>
<input type="text" class="form-control" id="empid2" name="empid2" readonly value="<?php echo $fetch2['emp_id'] ?>">
</div>
</div>
<div class="col-md-6">
<div class="mb-3">
<label for="formrow-name-input" class="form-label">Email <span style="color:red">*</span></label>
<input type="email" class="form-control" id="email" name="email" readonly value="<?php echo $fetch2['email'] ?>">
</div>
</div>
</div>
<div class="row">
<div class="col-md-4">
<div class="mb-3">
<label for="formrow-name-input" class="form-label">User Name <span style="color:red">*</span></label>
<input type="text" class="form-control" readonly id="uname" name="uname" value="<?php echo $fetch2['username'] ?>">
</div>
</div>
<div class="col-md-6">
<div class="mb-3">
<label for="formrow-name-input" class="form-label">Password <span style="color:red">*</span></label>
<input id="password-field" type="password" class="form-control" id="pwd" name="pwd" value="<?php echo ($fetch2['password']) ?>">
<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
</div>
</div>
<div class="col-md-2">
<div class="mb-3">
	<label for="order">Status</label>
	<select class="form-select" name="sts" id="sts">
		<option <?php if ($fetch2['status']=='1') { ?>selected <?php } ?>value="1">Active</option>
		<option <?php if ($fetch2['status']=='0') { ?>selected <?php } ?>value="0">Inactive</option>
	</select>
</div>
</div>
</div>
<div >
<button type="submit" name="updateemp" class="btn btn-success waves-effect waves-light btn-md w-mdd">Update</button> <button style="margin-left:10px" onclick="goBack()" type="button" name="cancel" class="btn btn-outline-success btn-md w-md ml-1">Cancel</button>
</div>

<?php }else{ ?>

	<div class="row">
	<div class="col-md-6">
	<div class="mb-3">
	<label for="formrow-name-input" class="form-label">First Name <span style="color:red">*</span></label>
	<input type="text" class="form-control" id="fname" name="fname" value="">
	</div>
	</div>
	<div class="col-md-6">
	<div class="mb-3">
	<label for="formrow-name-input" class="form-label">Last Name </label>
	<input type="text" class="form-control" id="lname" name="lname" value="">
	</div>
	</div>
	</div>
	<div class="row">
	<div class="col-md-6">
	<div class="mb-3">
	<label for="formrow-name-input" class="form-label">User Id <span style="color:red">*</span></label>
	<input type="text" class="form-control" id="empid" name="empid" readonly value="">
	</div>
	</div>
	<div class="col-md-6">
	<div class="mb-3">
	<label for="formrow-name-input" class="form-label">Email <span style="color:red">*</span></label>
	<input type="email" class="form-control" id="email" name="email" value="">
	</div>
	</div>
	</div>
	<div class="row">
	<div class="col-md-4">
	<div class="mb-3">
	<label for="formrow-name-input" class="form-label">User Name <span style="color:red">*</span></label>
	<input type="text" class="form-control" id="uname" name="uname" value="">
	</div>
	</div>
	<div class="col-md-4">
	<div class="mb-3">
	<label for="formrow-name-input" class="form-label">Password <span style="color:red">*</span></label>
	<input id="password-field" type="password" class="form-control" id="pwd" name="pwd" value="">
	<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
	</div>
	</div>

	<div class="col-md-4">
	<div class="mb-3">
		<label for="order">Status</label>
		<select class="form-select" name="sts" id="sts">
			<option value="1">Active</option>
			<option value="0">Inactive</option>
		</select>
	</div>
	</div>
	</div>
	<div >
	<button type="submit" name="addemp" class="btn btn-success waves-effect waves-light btn-md w-md">Add</button>   <button style="margin-left:10px" type="button" onclick="goBack()"name="cancel" class="btn btn-outline-success btn-md w-md">Cancel</button>
	</div>
<?php } ?>
</form>
                                                </div>
                                            </div>
                                            <div class="col-5 align-self-end">
                                                <img src="assets/images/verification-img.png" height="330" width="330" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>

									</div>
									</div>
									</div>
</div>
<!-- container-fluid -->
</div>

</div>
<!-- end main content-->
</div>
<!-- END layout-wrapper -->
<?php include 'script.php'; ?>
<script type="text/javascript">
function goBack() {
window.history.go(-1);
}
$(".toggle-password").click(function() {
$(this).toggleClass("fa-eye fa-eye-slash");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
input.attr("type", "text");
} else {
input.attr("type", "password");
}
});
</script>

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
fname: "required",
empid: "required",
email: {
	required: true,
	email: true,
	accept:"[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}"
},
uname: "required",
pwd: {
						required: true, minlength: 5
			},
repwd: {
						required: true, minlength: 5, equalTo: "#pwd",
			}
},
messages: {
fname: "Please enter name",
empid: "Please enter user id",
email: "Please enter email",
uname: "Please enter username",
pwd:{
	required:"Please enter new password",
	minlength:"Password should be minimum 5 digit."
} ,
repwd:{
	required: "Please enter retype  password",
	minlength: "Password should be minimum 5 digit.",
	equalTo: "Please should be the same as new password"
}
    
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
