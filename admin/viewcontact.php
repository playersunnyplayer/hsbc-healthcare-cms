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
$hdqry=mysqli_query($con,"select * from contact where header_id='$webId'");
$hdnum=mysqli_num_rows($hdqry);
$hdfetch=mysqli_fetch_array($hdqry);
checkIntrusion($adminId);
if(isset($_POST['addpage'])){
	extract($_POST);
	//$content2=$_POST['hi'];
	$content=$_POST['content'];
	$email=$_POST['email'];
	$tel=$_POST['tel'];
	$timing=$_POST['timing'];
	$timing2=$_POST['timing2'];
	$content2=$_POST['content2'];
	$address=$_POST['address'];

	$excQry=mysqli_query($con,"UPDATE `contact` SET `header_id`='$webId',`content`='$content',`tel`='$tel',`email`='$email',`timing`='$timing',`timing2`='$timing2',`content2`='$content2',`address`='$address',`status`='1' WHERE `id`=1");
	if($excQry ){
		header("location:viewcontact.php?msg=ins");
	}else{
		header("location:contact.php?msg=inf");
	}
	}
	if(isset($_GET['msg'])&&$_GET['msg']!=''){
	$msg=$_GET['msg'];
$name='Contact us';
	switch($msg){
	case 'ins':
		$msg='<strong>Success!</strong> Data has been added Successfully !!';
		$class='success';
	break;

	case 'inf':
		$msg='Data not updated Successfully !!';
		$class='danger';
	break;
	case 'ups':
		$msg='<strong>Success!</strong> updated Successfully !!';
		$class='success';
	break;

	case 'upf':
		$msg=$name.' Data not updated Successfully !!';
		$class='danger';
	break;
  case 'dls':
		$msg='<strong>Success!</strong> Data Deleted Successfully !!';
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
<title>View Contact | <?php echo getSiteTitle($webId); ?> </title>
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
<h4 class="mb-3 font-size-18">Contact Us</h4>

                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                           <li class="breadcrumb-item"> <a href="viewpage.php">Pages</a></li>
                                            <li class="breadcrumb-item active">Conatct</li>
                                        </ol>
                                  

</div>
</div>
<div class="col-6" style="text-align:right">
    <div class="page-title-right ">
        <?php if ($hdnum==0) {?>
<?php	} else { ?>
<a href="updatecontact.php?hid=<?php echo base64_encode($hdfetch['id']) ?>"><button type="button" class="btn btn-success btn-md waves-effect waves-light">Edit Content</button></a>
<?php } ?>
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
<?php if ($hdnum>0) {?>
	<div class="row">
	<div class="col-lg-12">
	<div class="card">
	<div class="card-body">
		<div class="row"><div  class="mb-3 col-lg-12"><?php echo $hdfetch['content'] ?></div></div>
	<div class="row" style="background-color:<?php echo getWebsiteColor() ?>;font-size:16px;text-align:center;padding:20px;color:#fff">
		<div  class="mb-3 col-lg-12" >
		Tel:<?php echo $hdfetch['tel'] ?></br>
		Email:-<?php echo $hdfetch['email'] ?></br>
		Monday-Friday:-<?php echo $hdfetch['mtf_from'].'-'.$hdfetch['mtf_to'] ?></br>
		(Excl Bank Holidays)Saturday:-<?php echo $hdfetch['sat_from'].'-'.$hdfetch['sat_to'] ?></br>
	</div>
	</div>
	<div class="row" ><div  class="mb-3 col-lg-12" style="padding-top:10px"><?php echo $hdfetch['content2'] ?></div></div>
	<div class="row" style="background-color:<?php echo getWebsiteColor() ?>;font-size:16px;text-align:center;padding:20px;color:#fff">
	    <div  class="mb-3 col-lg-12"><?php echo $hdfetch['address']?>
	    </div>
	</div>
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
																 <a href="updatecontact.php?home=Add"	<button type="button" class="btn btn-success btn-md waves-effect waves-light">Add Content</button></a>

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
