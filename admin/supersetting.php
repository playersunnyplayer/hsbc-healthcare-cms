<?php
ob_start();
session_start();
$adminId=$_SESSION['aid'];
//$webId=$_SESSION['web'];
include_once("configuration/connect.php");
include_once("configuration/functions.php");
if(isset($_SESSION["aid"])) {
if(isLoginSessionExpired()) {
header("Location:logout.php");
}
}
checkIntrusion($adminId);
$qry=mysqli_query($con,"select * from admin where id='$adminId'");
$hqry=mysqli_fetch_array($qry);
if(isset($_POST['update'])){
extract($_POST);
$id=$_POST['hidid'];
$a=$_POST['new_password'];
$b=$_POST['new_password_repeat'];
$new_pwd=$_POST['new_password'];
$new_pwd_rep=$_POST['new_password_repeat'];
if($a==" " && $b==" "){
	header("location:supersetting.php?msg=nnot");
}else{
if($a==$b){
$sqlQry="UPDATE `admin` SET `password`='$new_pwd_rep' WHERE `id` = '$id'";
$execQry=mysqli_query($con,$sqlQry);
if($execQry){
header("location:supersetting.php?msg=ups&abc=$a");
}else{
header("location:supersetting.php?msg=upf");
}
}else{
header("location:supersetting.php?msg=not&abc=$a");
}
}

}
if(isset($_GET['msg'])&&$_GET['msg']!=''){
$msg=$_GET['msg'];

switch($msg){
case 'ins':
$msg='<strong>Success!</strong> Data has been added Successfully !!';
$class='success';
break;

case 'inf':
$msg='Password not updated Successfully !!';
$class='danger';
break;
case 'ups':
$msg='<strong>Success!</strong> Password updated Successfully !!';
$class='success';
break;
case 'not':
$msg='Password Doesnot match !!';
$class='danger';
break;
case 'nnot':
$msg='Password can not be blank !!';
$class='danger';
break;
case 'upf':
$msg='Data not updated Successfully !!';
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
<title>Profile  </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include 'css.php'; ?>
<script src="assets/libs/jquery/jquery.min.js"></script>
</head>
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
<h4 class="mb-3 font-size-18">Profile</h4>

                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Profile</li>
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
<div class="col-lg-12">
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
                                             <form id="myform" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="hidid" value="<?php echo $hqry['id'] ?>">
<div class="row " style="padding-top:20px">

<div class="col-lg-6">
<label >User Name</label>
<input type="text" class="form-control" id="horizontal-firstname-input" name="username" readonly value="<?php echo $hqry['username'] ?>">
<input type="hidden" class="form-control" id="horizontal-firstname-input" name="hidId" readonly value="<?php echo $hqry['id'] ?>">
</div>
<div class="col-lg-6">
<label >Old Password</label>
<input id="old-password-field" type="password" class="form-control" id="horizontal-email-input" name="old_password" value="">
<span toggle="#old-password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
</div>
</div>
<div class="row " style="padding-top:20px">
<div class="col-lg-6">
<label class="form-label">Password <span style="color:red">*</span></label>
<input id="password-field"  type="password"  class="form-control" name="new_password" placeholder="Enter password" >
<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
</div>
<div class="col-md-6">
<label class="form-label">Retype Password <span style="color:red">*</span></label>
<input type="password" id="retype-password-field"   class="form-control" name="new_password_repeat" placeholder="Re-type password" >
<span toggle="#retype-password-field"  class=" fa fa-fw fa-eye field-icon toggle-password"></span>
</div>
</div>
<div style="padding-top:25px">
<button type="submit" name="update" class="btn btn-primary w-md btn-md">Update</button> <button style="margin-left:10px" type="button" onclick="goBack()"name="cancel" class="btn btn-outline-primary btn-md w-md">Cancel</button>
			 	</div>

</form>    </div>
                                            </div>
                                            <div class="col-5 align-self-end">
                                                <img src="assets/images/verification-img.png" alt="" class="img-fluid" height="330" width="330">
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
<script type="text/javascript">
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
$(document).ready(function() {
$('#myform').validate({
rules: {
		old_password: {
                required: true, minlength: 5
          },
		new_password: {
                required: true, minlength: 5
          }

},
messages: {
	old_password: "Please enter old password",
	new_password:{
		required:"Please enter new password",
		minlength:"Password should be minimum 5 digit."
	}
},
submitHandler: function(form) { // for demo
	form.submit();
}
});

});
</script>
</body>
</html>
