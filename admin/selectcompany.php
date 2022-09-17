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
if(isset($_GET['web'])&&$_GET['web']!=''){
$web=base64_decode($_GET['web']);
$val=$_GET['val'];
$sql=mysqli_query($con,"update websiteheader set status='$val' where id='$web'");
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
<h4>Select Company</h4>
</div>
</div>
</div>
<div class="row">
<?php $qry=mysqli_query($con,"select * from websiteheader where assign_to='$adminId'");
$num=mysqli_num_rows($qry);
if($num>0){
while ($fetch=mysqli_fetch_array($qry)) {
?>
<div class="col-xl-3 col-sm-6">

<div class="card text-center">
  <?php if ($fetch['status']=='1') {?>
<i class="mdi mdi-circle text-success align-middle me-1"style="text-align:right"></i>
  <?php }else{ ?>
<i class="mdi mdi-circle text-danger align-middle me-1"style="text-align:right"></i>
<?php } ?>

<div class="card-body">

<div class="mb-4">
<img class="avatar-sm" src="../assets/img/<?php echo $fetch['site_logo'] ?>" alt="">
</div>
<h5 class="font-size-15 mb-1"><a href="dashboard.php?web=<?php echo base64_encode($fetch['id']) ?>" class="text-dark"><?php echo $fetch['site_name'] ?></a></h5>
<div class="">
  <?php echo getEmpStatus($fetch['status']) ?>
</div>
</div>
<div class="card-footer bg-transparent border-top d-flex">

<div class="flex-fill" style="border-right:1px solid #f6f6f6;padding: .625rem 1.25rem;" >
<a href="dashboard.php?web=<?php echo base64_encode($fetch['id']) ?>" >Edit </a>
</div>

<div class="flex-fill" style="border-right:1px solid #f6f6f6;padding: .625rem 1.25rem;" >
    <?php if ($fetch['status']=='1') {?>
<a href="selectcompany.php?web=<?php echo base64_encode($fetch['id']) ?>&val=0">Inactive</a>
    <?php }else{ ?>
<a href="selectcompany.php?web=<?php echo base64_encode($fetch['id']) ?>&val=1">Active</a>
<?php } ?>
</div>
<div class="flex-fill" style="padding: .625rem 1.25rem;" >
<a target="_blank" href="http://cms.dev.patientzone.co.uk/index.html#/home/<?php echo $fetch['slug'] ?>" >Launch </a>
</div>
</div>
</div>
</div>

<?php }}else{?>
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
<div class="p-2 mt-4">
<h4>Alert !!!</h4>
<p class="text-muted">You have not assigned any copmany for edit..</p>
<div class="mt-4">
<a href="logout.php"	<button type="button" class="btn btn-primary btn-md waves-effect waves-light">Logout</button></a>

</div>
</div>
</div>
</div>

</div>
</div>


</div>
</div>
<?php		} ?>
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
