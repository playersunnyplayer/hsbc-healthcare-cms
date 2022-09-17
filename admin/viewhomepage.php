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
$date=date('d-m-Y h:i:sa' );
checkIntrusion($adminId);
$hdqry=mysqli_query($con,"select * from websitehomepage where header_id='$webId'");
$hdnum=mysqli_num_rows($hdqry);
$hdfetch=mysqli_fetch_array($hdqry);
if(isset($_GET['msg'])&&$_GET['msg']!=''){
$msg=$_GET['msg'];
$name='Home Page';
switch($msg){
case 'ins':
$msg=$name.' Data has been updated Successfully !!';
$class='success';
break;

case 'inf':
$msg=$name.'Data not updated Successfully !!';
$class='danger';
break;
case 'ups':
$msg=$name.' updated Successfully !!';
$class='success';
break;

case 'upf':
$msg=$name.' Data not updated Successfully !!';
$class='danger';
break;
case 'dls':
$msg=$name.' Data Deleted Successfully !!';
$class='success';
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
<title>Home Page| <?php echo getSiteTitle($webId); ?> </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include 'css.php'; ?>
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<script>
function myFunction() {
  var x = document.getElementById("mySelect").value;
	window.location.href="dashboard.php?web="+x;
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
<div class="container-fluid" style="margin-top:10px">
        <div class="row">
<div class="col-6">
<div class="page-title-box  align-items-center justify-content-between">
<h4 class="mb-3 font-size-18">Home Page</h4>

                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                           <li class="breadcrumb-item"> <a href="viewpage.php">Pages</a></li>
                                            <li class="breadcrumb-item active">Home Page</li>
                                        </ol>
                                  

</div>
</div>
<div class="col-6" style="text-align:right">
    <div class="page-title-right ">
        <?php if ($hdnum==0) {?>
<?php	} else { ?>
<a href="updatehome.php?hid=<?php echo base64_encode($hdfetch['id']) ?>"><button type="button" class="btn btn-success btn-md waves-effect waves-light">Edit Content</button></a>
<?php } ?>
</div>
</div>
</div>

<?php if($msg!=''){ ?>
<div class="alert alert-<?php echo $class ?> alert-dismissible fade show" role="alert">
<?php echo $msg; ?>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php } ?>
<?php if ($hdnum>0) {?>
<div class="row">
<div class="col-lg-6">
<div class="card">
<div class="card-body">
<div class="row"><div  class="mb-3 col-lg-12"><?php echo $hdfetch['content'] ?></div></div>
</div>
</div>
</div>
<div class="col-lg-6">
<div class="card">
<div class="card-body">
<div class="row"> <img src="../assets/img/<?php echo $hdfetch['img'] ?>" alt=""></div>
</div>
</div>
</div>
</div>
<?php }else{ ?>
<div class="row justify-content-center">
			 <div class="col-md-8 col-lg-6 col-xl-5">
					 <div class="card">

							 <div class="card-body">

									 <div class="p-2">
											 <div class="text-center">

													 <div class="avatar-md mx-auto">
															 <div class="avatar-title rounded-circle bg-light">
																	 <i class="bx bx-home h1 mb-0 text-success"></i>
															 </div>
													 </div>
													 <div class="p-2 mt-4">
															 <h4>Alert !!!</h4>
															 <p class="text-muted">Home page content not created..</p>
															 <div class="mt-4">
																 <a href="updatehome.php?home=Add"	<button type="button" class="btn btn-success btn-md waves-effect waves-light">Add Content</button></a>

															 </div>
													 </div>
											 </div>
									 </div>

							 </div>
					 </div>


			 </div>
	 </div>
 <?php } ?>
</div>
</div>
</div>
</div>
<?php include 'script.php'; ?>
<script src="assets/libs/select2/js/select2.min.js"></script>
<script src="assets/js/pages/form-advanced.init.js"></script>
<script>
CKEDITOR.replace( 'editor' );
CKEDITOR.replace( 'editor2' );
</script>
</body>
</html>
