<?php
ob_start();
session_start();
$adminId=$_SESSION['aid'];
include_once("configuration/connect.php");
include_once("configuration/functions.php");
checkIntrusion($adminId);
if(isset($_SESSION["aid"])) {
	if(isLoginSessionExpired()) {
		header("Location:sessionout.php");
	}
}
/*if(getHeaderDetail()>0){
	echo '<script>alert("Your profile has been created..")</script>';
	header("location:profile.php");
}*/
if(isset($_POST['submit'])){
	extract($_POST);
	$crmname=$_POST['name'];
	$crmtitle=$_POST['contact'];
	$crmtagline=$_POST['tagline'];
	$color=$_POST['color'];
	$filename = $_FILES['image']['name'];
  $valid_ext = array('png','jpeg','jpg','ico');
   $location2="patientZoneCMSAdmin/src/assets/img/".$filename;
  $location = "patientZoneCMSAdmin/src/assets/img/".$filename;
  $file_extension = pathinfo($location, PATHINFO_EXTENSION);
  $file_extension = strtolower($file_extension);
  if(in_array($file_extension,$valid_ext)){
    compressImage($_FILES['image']['tmp_name'],$location,60);
	  }else{
    echo "Invalid file type.";
	  }


$excQry=mysqli_query($con,"INSERT INTO `websiteheader`(`id`, `site_name`, `site_logo`, `site_contact`, `site_tagline`, `color` ,`status`)
	 VALUES (NULL,'$crmname','$filename','$crmtitle','$crmtagline','$color','1')");
	if($excQry ){
		header("location:dashboard.php?msg=ins");
	}else{
		header("location:createprofile.php?msg=inf");
	}
	}
if(isset($_GET['msg'])&&$_GET['msg']!=''){
	$msg=$_GET['msg'];

	switch($msg){
	case 'ins':
		$msg='Data has been added Successfully !!';
		$class='success';
	break;

	case 'inf':
		$msg='Data not inserted Successfully !!';
		$class='danger';
	break;
	case 'ups':
		$msg='Data updated Successfully !!';
		$class='success';
	break;

	case 'upf':
		$msg='Data not updated Successfully !!';
		$class='danger';
	break;

	case 'ule':
		$msg='This username already exists!!';
		$class='danger';
	break;
	case 'dls':
		$msg='Administrator data deleted successfully !!';
		$class='success';
	break;

	case 'dlf':
		$msg='Administrator data not deleted successfully !!!!';
		$class='danger';
	break;

		case 'ads':
		$msg='Administrator rights added successfully !!';
		$class='success';
	break;

	case 'adf':
		$msg='Administrator rights not added successfully !!!!';
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
        <title>Create Profile  </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <?php include 'css.php'; ?>
			 <link href="assets/libs/spectrum-colorpicker2/spectrum.min.css" rel="stylesheet" type="text/css">
			  <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="account-pages my-3 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center pt-0">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">

                            <div class="card-body pt-3">
                                <!--<div class="auth-logo">
                                    <a href="index.php" class="auth-logo-light">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="assets/images/logo-light.svg" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>

                                    <a href="index.php" class="auth-logo-dark">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="assets/images/logo.svg" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>
                                </div>-->
                                <div class="p-2">
                                      <form id="myform" name="registration" class="form-horizontal"  action="" method="post" enctype="multipart/form-data">

                                        <div class="mb-3">
                                            <label for="username" class="form-label"> Name <span style="color:red">*</span></label>
                                            <input type="text" class="form-control"  id="name" name="name" placeholder="Website Name">
																						<span  style="color:red"><small id="namtxt"></small></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"> TagLine</label>
                                            <input type="text" class="form-control"  placeholder="Website TagLine" name=tagline>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"> Contact <span style="color:red">*</span></label>
                                            <input type="text" id="contact"  class="form-control"  placeholder="Website Contact" name=contact>
																						<span><small id="mobtxt" style="color:red"><?php echo $mobtxt?></small></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"> Logo <span style="color:red">*</span></label>
                                             <input class="form-control form-control" required  id="formFileSm" type="file" name="image">
																						 <span><small id="logtxt" style="color:red"><?php echo $mobtxt?></small></span>
                                        </div>
																				<div class="mb-3">
																			   <label class="form-label">Color</label>
																			                                                 <input type="text" name="color" required class="form-control" id="colorpicker-default" value="#AC286B">
																			                                             </div>
                                        <div class="mt-3 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light" name="submit"  type="submit">Create Profile</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <div>
                                <p class="text-muted"> Powered By <img src="Picture3.png" alt="Trust" height="37"/></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- end account-pages -->
				<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="http://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
			<script type="text/javascript">
			$(document).ready(function() {

    $('#myform').validate({
        rules: {
					  name: "required",
            contact: {
					required: true,
			     number: true,
			     minlength: 10,
			     maxlength: 10
				 },
				 formFileSm: "required"
        },
				messages: {
					name: "Please enter name",

					contact: {
						required: "Please enter contact no",
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

				<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
				<script src="assets/libs/select2/js/select2.min.js"></script>

				<script src="assets/libs/spectrum-colorpicker2/spectrum.min.js"></script>


				<!-- form advanced init -->
				<script src="assets/js/pages/form-advanced.init.js"></script>
<script src="assets/libs/parsleyjs/parsley.min.js"></script>

<script src="assets/js/pages/form-validation.init.js"></script>
    </body>
</html>
