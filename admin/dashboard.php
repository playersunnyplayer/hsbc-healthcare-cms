<?php
ob_start();
session_start();
$adminId=$_SESSION['aid'];
include_once("configuration/connect.php");
include_once("configuration/functions.php");
if (isset($_GET['web'])&&$_GET['web']!='') {
$wid=base64_decode($_GET['web']);
$_SESSION['web']=$wid;
}
if(isset($_SESSION["aid"])) {
if(isLoginSessionExpired()) {
header("Location:logout.php");
}
}
$webId=$_SESSION['web'];
checkIntrusion($adminId);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Dashboard | <?php echo getSiteTitle($webId); ?> </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include 'css.php'; ?>
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<style>
#sticky-div {
   position : fixed;
 /*bottom:0;*/

}
</style>
<script>
function myFunction() {
  var x = document.getElementById("mySelect").value;
	window.location.href="dashboard.php?web="+x;
}
</script>
<script>
$counter =0;
//$a =0;
	// add code
		function addCode(ele)
		{
			$button = $(ele);
			// increment
			$counter += 1;
			$button.closest('tr').before('<tr><td><div  class="mb-3 col-lg-12"><label for="name">Title</label><input type="text"  name="pp['+$counter+'][title]" class="form-control"/></div><div  class="mb-3 col-lg-12"><label for="name">Content</label><textarea class="form-control" id="editor'+$counter+'" placeholder="Content" name="pp['+$counter+'][content]"></textarea></div><div style="text-align:right"><button class="btn btn-danger btn-md remove_code"  type="button" onClick="remove(this)">Remove section</button></div></td></tr>');
			var a="editor"+$counter;
			CKEDITOR.replace(a);
		}
		function remove(ele)
		{
			$button = $(ele);
			$button.closest('tr').remove();
			return false;
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
			<!--<div class="col-md-1"></div>-->
	</div>
<div class="container-fluid">
    <div class="row">
<div class="col-12">
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
<h4 class="mb-sm-0 font-size-18"> </h4>

</div>
</div>
</div>
	<div class="row">
				<div class="col-xl-12">
						<div class="card overflow-hidden">
								<div class="">
										<div class="row ">
												<div class="col-7">
														<div class=" p-3">
																<h5 class="text-success" style="margin:20px 0 30px">Welcome <?php echo getAdminName($adminId) ?> !</h5>
																<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur varius, odio quis vestibulum hendrerit, nisl neque venenatis purus, non scelerisque nulla risus at nisl. Proin pretium, justo quis ultricies vehicula, nisi mi condimentum ar Proin pretium, justo quis ultricies vehicula, nisi mi condimentum arProin pretium, justo quis ultricies vehicula, nisi mi condimentum arProin pretium, justo quis ultricies vehicula, nisi mi condimentum ar </p>

														<a href="addpage.php" ><button class="btn-success btn-md btn">Create New Page</button></a>



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
</div>
</div>
</div>
<?php include 'script.php'; ?>
<script src="assets/libs/select2/js/select2.min.js"></script>
<!-- form advanced init -->
<script src="assets/js/pages/form-advanced.init.js"></script>
</body>
</html>
