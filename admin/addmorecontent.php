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
if(isset($_GET['pid'])&&$_GET['pid']!=''){
	$pid=base64_decode($_GET['pid']);
}
$date=date('d-m-Y h:i:sa');
checkIntrusion($adminId);
if(isset($_POST['addpage'])){
	extract($_POST);
	$pid=$_POST['pid'];
	$pi=base64_encode($pid);
		$pos=$_POST['pord'];
$status='1';
//$i=0;
if( isset($_POST['pp']) && is_array( $_POST['pp'])) {
		foreach( $_POST['pp'] as $pp ) {
			$pos++;
			$subh=generateRandomString();
			$res = $con->query("insert into websitepagecontent (`pid`, `heading`,`subheading`, `content`, `position`, `status`, `date`)
				value('".$pid."','".$pp["title"]."','".$subh."','".$pp["content"]."', '".$pos."','".$status."','".$date."')");
		}
	}
//$cqry=mysqli_query($con,"INSERT INTO `websitepagecontent`(`id`, `pid`, `heading`, `subheading`, `content`, `position`, `status`, `date`)VALUES (NULL,'$insId','$title','','$content','$pos','1','$date')");
	if($res ){
		header("location:viewcontent.php?msg=ins&pid=$pi");
	}else{
		header("location:viewcontent.php?msg=inf&pid=$pi");
	}
	}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Add Page| <?php echo getSiteTitle($webId); ?> </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include 'css.php'; ?>
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="ckeditor/ckeditor.js"></script>
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
			<!--<div class="col-md-1"></div>-->
	</div>
<div class="container-fluid">
    <div class="row">
<div class="col-6">
<div class="page-title-box  align-items-center justify-content-between">
<h4 class="mb-3 font-size-18">Add Section</h4>

                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                           <li class="breadcrumb-item"> <a href="viewpage.php">Pages</a></li>
                                            <li class="breadcrumb-item active">Add Section</li>
                                        </ol>
                                  

</div>
</div>
<div class="col-6" style="text-align:right">
    <div class="page-title-right ">
</div>
</div>
</div>
<?php if($msg!=''){ ?>
<div class="alert alert-<?php echo $class ?> alert-dismissible fade show" role="alert">
<?php echo $msg; ?>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php } ?>
<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-body">
<form action=""  method="post"   enctype="multipart/form-data">
	<input type="hidden" name="pid" value="<?php echo $pid ?>">
		<input type="hidden" name="pord" value="<?php echo getContentNextPosition($pid) ?>">
<table class="table ">
		<tr>
			<td>
				<div  class="mb-3 col-lg-12"><label for="name">Section Title</label><input type="text" id="name" name="pp[0][title]" class="form-control"/></div>
				<div  class="mb-3 col-lg-12"><label for="name">Content</label><textarea id="editor" name="pp[0][content]" class="form-control"></textarea></div>
				</td>
		</tr>
		<tr>
			<td colspan="2">
				<button class="btn btn-success w-md btn-md" type="button" name="add_code" onClick="addCode(this)">Add New</button> <input style="margin-left:10px" type="submit" name="addpage" value="Publish" class="btn btn-success btn-md w-md"/> <input style="margin-left:10px" type="reset" name="" value="Cancel" class="btn btn-outline-success btn-md 	w-md">
			</td>
		</tr>
	</table>

	</form>
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
<script src="assets/js/pages/form-advanced.init.js"></script>
<script>
  CKEDITOR.replace( 'editor' );
</script>
</body>
</html>
