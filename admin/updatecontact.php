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
checkIntrusion($adminId);
if(isset($_POST['addpage'])){
extract($_POST);
$id=$_POST['hidid'];
$content=$_POST['content'];
$email=$_POST['email'];
$tel=$_POST['tel'];
$mtf_from=$_POST['mtf_from'];
$mtf_to=$_POST['mtf_to'];
$sat_from=$_POST['sat_from'];
$sat_to=$_POST['sat_to'];
$sun_from=$_POST['sun_from'];
$sun_to=$_POST['sun_to'];
$content2=$_POST['content2'];
$address=$_POST['address'];
$excQry=mysqli_query($con,"UPDATE `contact` SET `content`='$content',`tel`='$tel',
  `email`='$email',`mtf_from`='$mtf_from',`mtf_to`='$mtf_to',`sat_from`='$sat_from',`sat_to`='$sat_to',`sun_from`='$sun_from',`sun_to`='$sun_to',
  `content2`='$content2',`address`='$address',`date`='$date',`up_id`='$adminId',`status`='1' WHERE `id`='$id'");
if($excQry ){
header("location:viewcontact.php?msg=ins");
}else{
header("location:updatecontact.php?msg=inf");
}
}
if(isset($_POST['addhome'])){
extract($_POST);
$id=$_POST['hidid'];
$content=$_POST['content'];
$email=$_POST['email'];
$tel=$_POST['tel'];
$mtf_from=$_POST['mtf_from'];
$mtf_to=$_POST['mtf_to'];
$sat_from=$_POST['sat_from'];
$sat_to=$_POST['sat_to'];
$sun_from=$_POST['sun_from'];
$sun_to=$_POST['sun_to'];
$content2=$_POST['content2'];
$address=$_POST['address'];
$excQry=mysqli_query($con,"INSERT INTO `contact`(`id`, `header_id`, `content`, `tel`, `email`, `mtf_from`, `mtf_to`, `sat_from`, `sat_to`, `sun_from`, `sun_to`, `content2`, `address`, `status`, `up_id`, `date`)
 VALUES (null,'$id','$content','$tel','$email','$mtf_from','$mtf_to','$sat_from','$sat_to','$sun_from','$sun_to','$content2','$address','1','$adminId','$date')");
if($excQry ){
header("location:viewcontact.php?msg=ins");
}else{
header("location:updatecontact.php?msg=inf");
}
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Edit Contact | <?php echo getSiteTitle($webId); ?> </title>
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
<div class="container-fluid">
  	<?php if(isset($_GET['home'])&&$_GET['home']!=''){?>
       <div class="row">
<div class="col-6">
<div class="page-title-box  align-items-center justify-content-between">
<h4 class="mb-3 font-size-18">Add Contact</h4>

                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                           <li class="breadcrumb-item"> <a href="viewpage.php">Pages</a></li>
                                            <li class="breadcrumb-item active">Add Contact</li>
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
      <form action="" method="post" id="myform"  enctype="multipart/form-data">
<input type="hidden" name="hidid" value="<?php echo $webId ?>">
      <div class="row">
      <div class="col-lg-12">
      <div class="card">
      <div class="card-body">
      <div class="row"><div  class="mb-3 col-lg-12"><label for="name">Content</label><textarea id="editor" name="content" class="form-control"><?php echo $fetch['content'] ?></textarea></div></div>
    <div class="row">
<div  class="mb-3 col-lg-6"><label for="name">Telephone</label><input type="text" id="name" required name="tel" placeholder="##########"  class="form-control" value="<?php echo $fetch['tel'] ?>"/></div>
<div  class="mb-3 col-lg-6"><label for="name">Email</label><input type="text" id="email" required name="email" placeholder="#####@###.##" class="form-control" value="<?php echo $fetch['email'] ?>"/></div>
<div  class="mb-3 col-lg-4"><label for="name">Monday-Friday</label>
<div class="d-flex">
<input type="time" id="mtf_from" required name="mtf_from" placeholder="Timing(08:00-18:00)" class="form-control" value="<?php echo $fetch['mtf_from'] ?>"/>
<input type="time" id="mtf_to" required name="mtf_to" placeholder="Timing(08:00-18:00)" style="margin-left:20px" class="form-control" value="<?php echo $fetch['mtf_to'] ?>"/>
</div>
</div>
<div  class="mb-3 col-lg-4"><label for="name">Saturday</label>
<div class="d-flex" >
<input type="time" id="sat_from" required name="sat_from" placeholder="Timing(Excl Bank Holidays)" class="form-control" value="<?php echo $fetch['sat_from'] ?>"/>
<input type="time" id="sat_to" required name="sat_to" placeholder="Timing(Excl Bank Holidays)" class="form-control" style="margin-left:20px" value="<?php echo $fetch['sat_to'] ?>"/>
</div>
</div>
<div  class="mb-3 col-lg-4">
<label for="name">Sunday</label>
<div class="d-flex" >
<input type="time" id="sun_from" name="sun_from" placeholder="Sunday" class="form-control" value="<?php echo $fetch['sun_from'] ?>"/>
<input type="time" id="sun_to" name="sun_to" placeholder="Sunday" class="form-control" style="margin-left:20px" value="<?php echo $fetch['sun_to'] ?>"/>
</div>
</div>
</div>
      <div class="row"><div  class="mb-3 col-lg-12"><label for="name">Content</label><textarea id="editor2" name="content2" class="form-control"><?php echo $fetch['content2'] ?></textarea></div></div>
      <div class="row"><div  class="mb-3 col-lg-12"><label for="name">Address</label><textarea id="address" required name="address" class="form-control"><?php echo $fetch['address']?></textarea></div></div>
      <div class="row">
      <div class="mb-3 col-md-4">
      <button type="submit" name="addhome" class="btn btn-success w-md btn-md">Add</button>	<button style="margin-left:10px" type="reset" onclick="goBack()"name="resetpage" class="btn btn-outline-success btn-md w-md">Cancel</button>
      </div>
      </div>
      </div>
      </div>
      </div>
      </div>
      </form>
    <?php }else{ ?>
    <div class="row">
<div class="col-6">
<div class="page-title-box  align-items-center justify-content-between">
<h4 class="mb-0 font-size-18">Update Contact</h4>

                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                           <li class="breadcrumb-item"> <a href="viewpage.php">Pages</a></li>
                                            <li class="breadcrumb-item active">Update Contact</li>
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
<form action="" method="post" id="myform2"  enctype="multipart/form-data">
<?php $fetch=mysqli_fetch_array(mysqli_query($con,"select * from contact where header_id='$webId'")); ?>
<input type="hidden" name="hidid" value="<?php echo $fetch['id']; ?>">
<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-body">
<div class="row"><div  class="mb-3 col-lg-12"><label for="name">Content</label><textarea id="editor" name="content" class="form-control"><?php echo $fetch['content'] ?></textarea></div></div>
<div class="row">
<div  class="mb-3 col-lg-6"><label for="name">Telephone</label><input type="text" id="name" required name="tel" placeholder="##########"  class="form-control" value="<?php echo $fetch['tel'] ?>"/></div>
<div  class="mb-3 col-lg-6"><label for="name">Email</label><input type="text" id="email" required name="email" placeholder="#####@###.##" class="form-control" value="<?php echo $fetch['email'] ?>"/></div>
<div  class="mb-3 col-lg-4"><label for="name">Monday-Friday</label>
<div class="d-flex">
<input type="time" id="mtf_from" required name="mtf_from" placeholder="Timing(08:00-18:00)" class="form-control" value="<?php echo $fetch['mtf_from'] ?>"/>
<input type="time" id="mtf_to" required name="mtf_to" placeholder="Timing(08:00-18:00)" style="margin-left:20px" class="form-control" value="<?php echo $fetch['mtf_to'] ?>"/>
</div>
</div>
<div  class="mb-3 col-lg-4"><label for="name">Saturday</label>
<div class="d-flex" >
<input type="time" id="sat_from" required name="sat_from" placeholder="Timing(Excl Bank Holidays)" class="form-control" value="<?php echo $fetch['sat_from'] ?>"/>
<input type="time" id="sat_to" required name="sat_to" placeholder="Timing(Excl Bank Holidays)" class="form-control" style="margin-left:20px" value="<?php echo $fetch['sat_to'] ?>"/>
</div>
</div>
<div  class="mb-3 col-lg-4">
<label for="name">Sunday</label>
<div class="d-flex" >
<input type="time" id="sun_from" name="sun_from" placeholder="Sunday" class="form-control" value="<?php echo $fetch['sun_from'] ?>"/>
<input type="time" id="sun_to" name="sun_to" placeholder="Sunday" class="form-control" style="margin-left:20px" value="<?php echo $fetch['sun_to'] ?>"/>
</div>
</div>
</div>
<div class="row"><div  class="mb-3 col-lg-12"><label for="name">Content</label><textarea id="editor2" name="content2" class="form-control"><?php echo $fetch['content2'] ?></textarea></div></div>
<div class="row"><div  class="mb-3 col-lg-12"><label for="name">Address</label><textarea id="address" required name="address" class="form-control"><?php echo $fetch['address']?></textarea></div></div>
<div class="row">
<div class="mb-3 col-md-4">
<button type="submit" name="addpage" class="btn btn-success w-md btn-md">Update</button>	<button style="margin-left:10px" type="reset" onclick="goBack()"name="resetpage" class="btn btn-outline-success btn-md w-md">Cancel</button>
</div>
</div>
</div>
</div>
</div>
</div>
</form>
<?php } ?>
</div>
</div>
</div>
</div>
<?php include 'script.php'; ?>

<script src="assets/js/pages/form-advanced.init.js"></script>
<script type="text/javascript">
function goBack() {
  window.history.go(-1);
}
CKEDITOR.replace( 'editor' );
CKEDITOR.replace( 'editor2' );
CKEDITOR.replace( 'address' );
</script>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="http://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

$('#myform2').validate({
rules: {
content:{required:true}
tel:"required",
email: {
required: true,
email: true
},
timing: "required",
timing2: "required",
editor2:"required",
address:"required"
},
messages: {
content: "Please enter content",
tel:"Please enter telephone no",
email: {
required: "Please enter email",
email:"Plese enter valid email"
},
timing: "Please enter time",
timing2: "Please saturday time",
editor2: "Please enter content",
address:"Please enter address"
},
submitHandler: function(form) { // for demo
form.submit();
}
});

});
</script>
<script src="assets/libs/select2/js/select2.min.js"></script>

<script src="assets/libs/spectrum-colorpicker2/spectrum.min.js"></script>


<!-- form advanced init -->
<script src="assets/js/pages/form-advanced.init.js"></script>
</body>
</html>
