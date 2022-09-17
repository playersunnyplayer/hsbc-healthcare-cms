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
$res=mysqli_query($con,"UPDATE `websitepagecontent` SET `heading`='$title',`content`='$content',`date`='$date' WHERE id=$cid");
$res2=mysqli_query($con,"update websitepage set `date`='$date' where id=$pi");
//$cqry=mysqli_query($con,"INSERT INTO `websitepagecontent`(`id`, `pid`, `heading`, `subheading`, `content`, `position`, `status`, `date`)VALUES (NULL,'$insId','$title','','$content','$pos','1','$date')");
	if($res ){
		header("location:customerpagecontent.php?msg=ups&pid=$pid");
	}else{
		header("location:customerpagecontent.php?msg=inf&pid=$pid");
	}
	}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Edit Content </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include 'css.php'; ?>
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="ckeditor/ckeditor.js"></script>
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
<h4 class="mb-3 font-size-18">Edit Section</h4>

                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item "><a href="customers.php">Customers</a></li>
                                            <li class="breadcrumb-item">Customer Pages</li>
                                            <li class="breadcrumb-item active">Edit Section</li>
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

	<div class="mb-3 col-md-3">
	    <button type="submit" name="addpage" class="btn btn-success w-md btn-md">Save</button>
	    <a href="viewcontent.php?pid=<?php echo base64_encode($page['pid']); ?>"<button type="button" style="margin-left:10px" name="resetpage" class="btn btn-outline-success btn-md w-md">Cancel</button></a></div>
</div>
</div>
</div>
</div>

</div>
<?php }?>
</form>
</div>
</div>
<?php include 'footer.php' ?>
</div>
</div>
<?php include 'script.php'; ?>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="http://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
<script type="text/javascript">
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
