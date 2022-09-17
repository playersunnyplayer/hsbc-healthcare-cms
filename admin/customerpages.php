<?php
ob_start();
session_start();
$adminId=$_SESSION['aid'];
//$webId=$_SESSION['web'];
include_once("configuration/connect.php");
include_once("configuration/functions.php");
if(isset($_SESSION["aid"])) {
if(isLoginSessionExpired()) {
header("Location:logout.php");
}
}
if(isset($_GET['cmp_id'])&&$_GET['cmp_id']!=''){
		$cmpid=$_GET['cmp_id'];
	$cmp=base64_decode($_GET['cmp_id']);
}
checkIntrusion($adminId);
if(isset($_GET['did'])&&$_GET['did']!=''){
$did=($_GET['did']);
$pid=base64_encode($did);
$cmp=($_GET['cmp_id']);
$delQry=mysqli_query($con,"delete from `websitepage` where `id`='$did'");
if($delQry){
header("location:customerpages.php?msg=dls&pid=$pid&cmp_id=$cmp");
}else{
header("location:customerpages.php?msg=dlf&pid=$pid&cmp_id=$cmp");
}
}

if(isset($_GET['msg'])&&$_GET['msg']!=''){
$msg=$_GET['msg'];
$name=getPageNameById(base64_decode($_GET['pid']));
$cmp=base64_decode($_GET['cmp_id']);
switch($msg){
case 'ins':
$msg='<strong>Success!</strong> Data has been added Successfully !!';
$class='success';
break;

case 'inf':
$msg='Data not inserted Successfully !!';
$class='danger';
break;
case 'ups':
$msg='<strong>Success!</strong> Data updated Successfully !!';
$class='success';
break;

case 'dlf':
$msg=$name.' page not deleted !!';
$class='danger';
break;
case 'dls':
$msg= '<strong>Success!</strong> Page Deleted Successfully !!';
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
<title>Company Pages </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include 'css.php'; ?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<script type="text/javascript" src="assets/js/bootstrap-select.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<!--<script src="assets/libs/jquery/jquery.min.js"></script>--->
<!-- Font Awesome Css -->
<link href="css/font-awesome.min.css" rel="stylesheet" />
<!-- Bootstrap Select Css -->
<link href="assets/css/bootstrap-select.css" rel="stylesheet" />
<!-- Custom Css -->
<link href="assets/css/style.css" rel="stylesheet" />
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
<script>

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
<div class="container-fluid mt-3">
<div class="row">
<div class="col-6">
<div class="page-title-box align-items-center justify-content-between">
<h4 class="mb-3 font-size-18"><?php echo getSiteTitle($cmp) ?> All Pages  </h4>
<div class="page-title-right">
    <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item "><a href="customers.php">Customers</a></li>
                                            <li class="breadcrumb-item active">Customer Pages</li>
                                        </ol>
</div>
</div>
</div>
<div class="col-6" style="text-align:right">
    <div class="page-title-right ">
<a href="customeraddpage.php?cmp_id=<?php echo base64_encode($cmp) ?>"	<button type="button" class="btn btn-success btn-md waves-effect waves-light">Add New</button></a>
</div>
</div>
</div>
<form class="" action="" method="post">
<input type="hidden" name="hidid" id="hidid" value="<?php echo $cmpid; ?>">
</form>

<?php if($msg!=''){ ?>
<div class="alert alert-<?php echo $class ?> alert-dismissible fade show" role="alert">
<?php echo $msg; ?>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php } ?>
<div class="alert alert-success alert-dismissible fade show" role="alert" style="display:none">
<strong> Success ! </strong> <span class="success-message"> Page Order has been updated successfully </span>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<div class="row">
<div class="col-lg-12">
<div class="card" style="margin-bottom:0px">
<table class="table table-light table-borderless" style="margin-bottom:0px">
<tr  title="Home page can not be moved">
<th width="5%" style="vertical-align:middle!important;">#</th>
<th width="25%" style="vertical-align:middle!important;">Name</th>
<th width="20%" style="vertical-align:middle!important;">Last Update</th>
<th width="15%" style="vertical-align:middle!important;">Status</th>
<th width="20%" style="vertical-align:middle!important;" >Action</th>
</tr>
</table>
</div>
<div class="card" style="margin-bottom:0px">
<table class="table  table-borderless" style="margin-bottom:0px">
<tr >
<td width="5%" style="vertical-align:middle!important;">
<div class="avatar-xs">
<span class="avatar-title rounded-circle" style="background-color:#eff2f7">
<i class="fas fa-arrows-alt" title="You can't move home page"></i>
</span>
</div>
</td>
<td width="25%" style="vertical-align:middle!important;">
<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">Home Page</a></h5>
</td>
<td width="20%" style="vertical-align:middle!important;"><p class="text-muted mb-0"><?php echo getLastUpdate('websitehomepage',$cmp); ?></p></td>
<td width="15%" style="vertical-align:middle!important;"><?php echo getStatus(1); ?></td>
<td width="20%" style="vertical-align:middle!important;">
	<?php if(checkContent('websitehomepage',$cmp)>0) {?>
<a href="customerupdatehome.php?cmp_id=<?php echo base64_encode($cmp) ?>"><button type="button" class="btn btn-outline-success waves-effect waves-light btn-md"  title="Edit page content"><i class="fas fa-edit"></i></button></a>
<?php }else{ ?>
	<a style="margin-left:10px"  href="customerupdatehome.php?home=add&cmp_id=<?php echo base64_encode($cmp) ?>"><button  type="button" class="btn btn-outline-success waves-effect waves-light btn-md"  title="Add home page content"><i class="fas fa-plus-circle"></i></button></a>
<?php } ?>

</td>
</td>
</tr>
</table>
</div>

<ul class="list-unstyled" id="post_list">
<?php
$i=0;
$qry=mysqli_query($con,"select * from websitepage where header_id='$cmp' order by position asc");
$num=mysqli_num_rows($qry);
if($num>0){
while ($page=mysqli_fetch_array($qry)) {
$i++;
if ($page['theme']=='1') {
$thm="Theme One";
}
if ($page['theme']=='2') {
$thm="Theme Two";
}
if ($page['theme']=='3') {
$thm="Theme Three";
}
if($page['status']==0){
$class='bg-warning bg-gradient bg-soft';
}else{
$class="";
}
?>
<li data-post-id="<?php echo $page["id"]; ?>">
<div class="card  <?php echo $class; ?>"  style="margin-bottom:0px;">
<table class="table  table-borderless" style="margin-bottom:0px">
<tr>
<td width="5%" style="vertical-align:middle!important;">
<div class="avatar-xs" style="cursor:move">
<span class="avatar-title rounded-circle">
<i class="fas fa-arrows-alt"></i>
</span>
</div>
</td>
<td width="25%" style="vertical-align:middle!important;">
<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark"><?php echo $page['name'] ?></a></h5>
</td>

<td width="20%" style="vertical-align:middle!important;"><p class="text-muted mb-0"><?php echo $page['date']; ?></p></td>
<td width="15%" style="vertical-align:middle!important;"><?php echo getStatus($page['status']); ?></td>
<td width="20%" style="vertical-align:middle!important;">
<a href="customerpagecontent.php?pid=<?php echo base64_encode($page['id']) ?>"><button type="button" class="btn btn-outline-success waves-effect waves-light btn-md" title="Edit Page Content" ><i class="fas fa-edit"></i> </button></a>
<a style="margin-left:10px"  href="#del" class=delete id="<?php echo ($page['id']) ?>"  ><button  data-bs-toggle="modal" data-bs-target="#del" class="btn btn-outline-danger waves-effect waves-light btn-md" type="button"><i class="fas fa-trash-alt" ></i> </button></a></td>
</td>
</tr>
</table>
</div>
</li>
<?php }}else{?>

<?php } ?>

</ul>
<div class="card">
<table class="table  table-borderless" style="margin-bottom:0px">
<tr  >
<td width="5%" style="vertical-align:middle!important;">
<div class="avatar-xs">
<span class="avatar-title rounded-circle" style="background-color:#eff2f7">
<i class="fas fa-arrows-alt" title="You Can't move contact page"></i>
</span>
</div>
</td>
<td width="25%" style="vertical-align:middle!important;">
<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">Contact Page</a></h5>
</td>
<td width="20%" style="vertical-align:middle!important;"><p class="text-muted mb-0"><?php echo getLastUpdate('contact',$cmp); ?></p></td>
<td width="15%" style="vertical-align:middle!important;"><?php echo getStatus(1); ?></td>
<td width="20%" style="vertical-align:middle!important;">
	<?php if(checkContent('contact',$cmp)>0) {?>
<a href="customerupdatecontact.php?cmp_id=<?php echo base64_encode($cmp) ?>"><button type="button" class="btn btn-outline-success waves-effect waves-light btn-md"  title="Edit contact page content"><i class="fas fa-edit"></i></button></a>
<?php }else{ ?>
	<a style="margin-left:10px"  href="customerupdatecontact.php?home=add&cmp_id=<?php echo base64_encode($cmp) ?>"><button type="button" class="btn btn-outline-success waves-effect waves-light btn-md"  title="Add contact page content"><i class="fas fa-plus-circle"></i></button></a>
<?php } ?>

</td>
</tr>
</table>
</div>

</div>

</div>

</div>

</div>

</div>

</div>
<div id="del" class="modal fade bs-example-modal-sm bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
  <div class="modal-body">
                               <div class="text-center mb-4">
                                   <div class="avatar-md mx-auto mb-4">
                                       <div class="avatar-title bg-light rounded-circle text-success h1">
                                           <i class="mdi mdi-trash-can"></i>
                                       </div>
                                   </div>

                                   <div class="row justify-content-center">
                                       <div class="col-xl-10">
                                           <h4 class="text-success">Are you sure?</h4>
                                           <p class="text-muted font-size-14 mb-4">You won't be able to revert this!</p>

                                           <div class=" ">
                                             <span id="delbtn"></span>
                                                <button class="btn btn-danger" type="button" data-bs-dismiss="modal" aria-label="Close">
                                                   Cancel
                                               </button>

                                           </div>

                                       </div>
                                   </div>
                               </div>
                           </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>
<?php include 'script.php'; ?>
<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>

			<!-- Sweet alert init js-->
			<script src="assets/js/pages/sweet-alerts.init.js"></script>
<script type="text/javascript">
function goBack() {
window.history.go(-1);
}
$(document).ready(function(){
$("#post_list" ).sortable({
//alert('sdfsdf');
placeholder : "ui-state-highlight",
update  : function(event, ui)
{
var post_order_ids = new Array();
$('#post_list li').each(function(){
post_order_ids.push($(this).data("post-id"));
});
$.ajax({
url:"update_fn.php",
method:"POST",
data:{post_order_ids:post_order_ids},
success:function(data)
{
if(data){
$(".alert-danger").hide();
$(".alert-success").show();
}else{
$(".alert-success").hide();
$(".alert-danger").show();
}
}
});
}
});
});
function errorMsg(){
confirm("Are you sure want to delete");
}
</script>
<script type="text/javascript">
$(document).on("click",".delete",function(){
var a=this.id;
var b=$("#hidid").val();
//alert(b);
var x="<a  href='customerpages.php?did="+a+"&cmp_id="+b+"'><button class='btn btn-success'>Yes delete it!</button></a>";
$('#delbtn').html(x);
})
</script>
</body>
</html>
