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

$date=date('d-m-Y h:i:sa');
checkIntrusion($adminId);
if(isset($_POST['addpage'])){
	extract($_POST);
	$pi=$_POST['pid'];
	$pid=base64_encode($pi);
		$cid=$_POST['cid'];
		$title=$_POST['title'];
		$content=$_POST['content'];
$res=mysqli_query($con,"UPDATE `websitepagecontent` SET `heading`='$title',`content`='$content',`date`='$date' WHERE id='$cid'");
$res2=mysqli_query($con,"update websitepage set `date`='$date' where id='$pi'");
//$cqry=mysqli_query($con,"INSERT INTO `websitepagecontent`(`id`, `pid`, `heading`, `subheading`, `content`, `position`, `status`, `date`)VALUES (NULL,'$insId','$title','','$content','$pos','1','$date')");
	if($res ){
		header("location:viewcontent.php?msg=ins&pid=$pid");
	}else{
		header("location:viewcontent.php?msg=inf&pid=$pid");
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
	<div class="col-md-3"></div>
	<div class="col-md-3" >
	<select class="form-control select2" style="width:250px;" id="mySelect" onchange="myFunction()" >
	<?php $qry=mysqli_query($con,"select * from websiteheader where assign_to='$adminId'");
	$num=mysqli_num_rows($qry);
	if($num>0){
	while ($fetch=mysqli_fetch_array($qry)) {
	?>
	<option value="<?php echo base64_encode($fetch['id']) ?>"   <?php if ($webId==$fetch['id']){ ?>selected<?php } ?>><?php echo $fetch['site_name'] ?></option>
	<?php }} ?>
	</select>
	</div>
	</div>
<div class="container-fluid">
	<div class="row">
										<div class="col-12">
												<div class="page-title-box d-sm-flex align-items-center justify-content-between">
														<h4 class="mb-3 font-size-18">Edit Section </h4>
												</div>
										</div>
								</div>
<?php if($msg!=''){ ?>
<div class="alert alert-<?php echo $class ?> alert-dismissible fade show" role="alert">
<?php echo $msg; ?>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php } ?>
<?php if(isset($_GET['cid'])&&$_GET['cid']!=''){
	$cid=base64_decode($_GET['cid']);
	$qry=mysqli_query($con,"select * from websitepagecontent where id='$cid'");
	$num=mysqli_num_rows($qry);
	$page=mysqli_fetch_array($qry);
?>
<form id="myform" action="" method="post"   enctype="multipart/form-data">
	<input type="hidden" name="pid" value="<?php echo $page['pid'] ?>">
		<input type="hidden" name="cid" value="<?php echo $cid ?>">

<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-body">

				<div  class="mb-3 col-lg-12"><label for="name">Title</label><input type="text" id="name" name="title" class="form-control" value="<?php echo $page['heading'] ?>"/></div>
				<div  class="mb-3 col-lg-12"><label for="name">Content</label><textarea id="editor" name="content" class="form-control"><?php echo $page['content'] ?></textarea></div>		</td>

	<div class="mb-3 col-md-3"><button type="submit" name="addpage" class="btn btn-success w-md btn-md">Update</button> <a style="margin:left:10px" href="viewcontent.php?pid=<?php echo base64_encode($page['pid']); ?>"<button type="button" name="resetpage" class="btn btn-outline-success btn-md w-md">Cancel</button></a></div>
</div>
</div>
</div>
</div>

</div>
<?php }?>
</form>
</div>
</div>
</div>
</div>
<?php include 'script.php'; ?>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="http://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
<script src="assets/libs/select2/js/select2.min.js"></script>
<script src="assets/js/pages/form-advanced.init.js"></script>
<script type="text/javascript">
function goBack() {
  window.history.go(-1);
}
$(document).ready(function() {

$('#myform').validate({
rules: {
		title: "required",
 		content: "required"
},
messages: {
	title: "Title cannot blank",
	content: "Content can't blank"
},
submitHandler: function(form) { // for demo
	form.submit();
}
});

});
</script>

<script>
  CKEDITOR.replace( 'editor' );
</script>
</body>
</html>
