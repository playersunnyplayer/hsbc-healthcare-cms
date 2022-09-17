<?php
ob_start();
session_start();
$adminId=$_SESSION['aid'];
include_once("configuration/connect.php");
include_once("configuration/functions.php");
$logo=getProjectLogo();
if(isset($_SESSION["aid"])) {
if(isLoginSessionExpired()) {
header("Location:logout.php");
}
}
checkIntrusion($adminId);
if (isset($_POST['go'])) {
  $web=base64_encode($_POST['comp']);
  header("location:dashboard.php?web=$web");
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Select Company </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include 'css.php'; ?>

</head>

<body>
<div id="main" class="account-pages my-5 pt-sm-4">
<div class="container">
<div class="row">
<div class="col-lg-12">
<div class="text-center mb-4 text-muted">
<?php if($logo!=''){ ?>
<span  style="text=align:center;height:100px;width:100px;">
<img src="assets/images/logo.png" alt="" class="" style="width:100px">
</span>
<?php } ?>
</div>
</div>
</div>
<div class="row">

  <div class="row justify-content-center">
				 <div class="col-md-8 col-lg-6 col-xl-5">
						 <div class="card">

								 <div class="card-body">

										 <div class="p-2">
												 <div class="text-center">

														 <div class="avatar-md mx-auto">
																 <div class="avatar-title rounded-circle bg-light">
																		 <i class="fas fa-globe h1 mb-0 text-primary"></i>
																 </div>
														 </div>
                             <form class="" action="" method="post">


														 <div class="p-2 mt-4">
																 <h4>Select Company</h4>
																 <p class="text-muted"></p>
                                 <select class="form-control" name="comp">
                                   <?php $qry=mysqli_query($con,"select * from websiteheader where assign_to='$adminId'");
                                   $num=mysqli_num_rows($qry);
                                   if($num>0){
                                   while ($fetch=mysqli_fetch_array($qry)) {?>
                                   <option value="<?php echo $fetch['id']?>"><?php echo $fetch['site_name']?></option>
                                <?php }} ?>
                                 </select>
																 <div class="mt-4">
																	<button name="go" type="submit" class="btn btn-primary btn-sm waves-effect waves-light">Go To Dashboard</button>
																 </div>
														 </div>
                             </form>
												 </div>
										 </div>

								 </div>
						 </div>


				 </div>
		 </div>

</div>
</div>
</div>
<!-- end account-pages -->
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/metismenu/metisMenu.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

</body>
</html>
