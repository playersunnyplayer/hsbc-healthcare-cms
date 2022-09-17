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

checkIntrusion($adminId);
if(isset($_POST['update'])){
$pid=base64_encode($_POST['hidId']);
$id=$_POST['hidId'];
$name=$_POST['name'];
$slug=$_POST['slug'];
$status=$_POST['sts'];
$date=date('d-m-Y h:i:sa');
$delQry=mysqli_query($con,"update websitepage set name='$name',url='$slug', status='$status',date='$date' where `id`='$id'");
if($delQry){
header("location:viewcontent.php?msg=ups&pid=$pid");
}else{
header("location:viewcontent.php?msg=inf&pid=$pid");
}
}
if(isset($_GET['did'])&&$_GET['did']!=''){
$did=($_GET['did']);
$pid=($_GET['pid']);
$delQry=mysqli_query($con,"delete from `websitepagecontent` where `id`='$did'");
if($delQry){
header("location:viewcontent.php?msg=dls&pid=$pid");
}else{
header("location:viewcontent.php?msg=dlf&pid=$pid");
}
}
if(isset($_GET['pid'])&&$_GET['pid']!=''){
$pid=base64_decode($_GET['pid']);
$cmpid=$_GET['pid'];
$page=mysqli_fetch_array(mysqli_query($con,"select * from websitepage where id='$pid'"));
}
if(isset($_GET['msg'])&&$_GET['msg']!=''){
$msg=$_GET['msg'];
$name=getPageNameById($_GET['pid']);
switch($msg){
case 'ins':
$msg='<strong>Success!</strong> Data has been added Successfully !!';
$class='success';
break;

case 'inf':
$msg=$name.'Data not updated Successfully !!';
$class='danger';
break;
case 'ups':
$msg='<strong>Success!</strong> updated Successfully !!';
$class='success';
break;

case 'dlf':
$msg=$name.' section not deleted !!';
$class='danger';
break;
case 'dls':
$msg='<strong>Success!</strong> Section Deleted Successfully !!';
$class='success';
break;
case 'default' :
$msg='';
break;

}
}
?>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>View Content | <?php echo getSiteTitle($webId); ?> </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include 'css.php'; ?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<script type="text/javascript" src="assets/js/bootstrap-select.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<!-- Font Awesome Css -->
<link href="css/font-awesome.min.css" rel="stylesheet" />
<!-- Bootstrap Select Css -->

<!-- Custom Css -->
<link href="assets/css/style.css" rel="stylesheet" />
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

<script>
function myFunction() {
var x = document.getElementById("mySelect").value;
window.location.href="dashboard.php?web="+x;
}
</script>

<script>
  $(function() {
    $( "#jQuery_accordion" )
      .accordion({
      collapsible:true,
			autoHeight: false,
			heightStyle: "content",
			active: false ,
        header: "> div > h3"
      })
      .sortable({
        axis: "y",
        handle: "h3",
				update  : function(event, ui)
				{
					var post_order_ids = new Array();
					$('#jQuery_accordion h3').each(function(){
					post_order_ids.push($(this).data("post-id"));
					});
					$.ajax({
					url:"update_fn2.php",
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
				},
        stop: function( event, ui ) {
          // IE doesn't register the blur when sorting
          // so trigger focusout handlers to remove .ui-state-focus
          ui.item.children( "h3" ).triggerHandler( "focusout" );

          // Refresh accordion to handle new order
          $( this ).accordion( "refresh" );
        }
      });
  });
  </script>

<style>
.ui-accordion .ui-accordion-header {
	position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    width: 100%;
    padding: 1rem 1.25rem;
    font-size: .8125rem;
    color: #495057;
    text-align: left;
    background-color: #fff;
    border: 0;
		cursor:pointer;
    border-radius: 5px;
    overflow-anchor: none;
    -webkit-transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,border-radius .15s ease,-webkit-box-shadow .15s ease-in-out;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,border-radius .15s ease,-webkit-box-shadow .15s ease-in-out;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,border-radius .15s ease;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,border-radius .15s ease,-webkit-box-shadow .15s ease-in-out;
}
.ui-accordion .ui-accordion-icons {
	padding-left: 2.2em;
}
.ui-accordion .ui-accordion-icons .ui-accordion-icons {
	padding-left: 2.2em;
}
.ui-accordion .ui-accordion-header .ui-accordion-header-icon {
	position: absolute;
	left: .5em;
	top: 50%;
	margin-top: -8px;
}
.ui-accordion .ui-accordion-content {
	padding: 1rem 1.25rem;
min-height:auto !important;
	overflow: auto;
    /*background:#DAE9C5;*/
height:auto;
    border-top: 0;
    border-radius:0px;
    width:100%;
    /*margin-left:2px;*/
}
/* IE has layout issues when sorting (see #5413) */
  .group { zoom: 1;
		background-color: transparent;
    border: 1px solid rgba(0,0,0,.125);
		margin-bottom: 5px;
	 }
</style>
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
<h4 class="mb-3 font-size-18"><?php echo  $page['name'] ?></h4>

                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                           <li class="breadcrumb-item"> <a href="viewpage.php">Pages</a></li>
                                            <li class="breadcrumb-item active"><?php echo  $page['name'] ?></li>
                                        </ol>
                                  

</div>
</div>
<div class="col-6" style="text-align:right">
    <div class="page-title-right ">
        <a href="addmorecontent.php?pid=<?php echo base64_encode($page['id']) ?>"	<button type="button" class="btn btn-success btn-md waves-effect waves-light">Add Section</button></a>

</div>
</div>
</div>

	<div class="row">
	<div class="col-lg-12">
		<div class="alert alert-success alert-dismissible fade show" role="alert" style="display:none">
		<strong> Success ! </strong> <span class="success-message"> Section Order has been updated successfully </span>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		<div class="alert alert-danger alert-dismissible fade show" role="alert" style="display:none">
		<i class="fa fa-fw fa-times-circle"></i>
		<strong> Note !</strong> <span class="warning-message"> Empty list can't be Process </span>
		</div>
</div>
</div>
<div class="row">
<div class="col-lg-9">
<div id="jQuery_accordion">
	<?php
	$i=0;

	$qry=mysqli_query($con,"select * from websitepagecontent where pid='$pid' order by position asc");
	$num=mysqli_num_rows($qry);
	if($num>0){
	while ($fetch=mysqli_fetch_array($qry)) {
	$i++;
	$head='Heading'.$i;
	$colsp='Collaspe'.$i;
	?>
<div class="group">
	<h3 data-post-id="<?php echo $fetch["id"]; ?>" class="accordion-header" >

		<div class="avatar-xs" style="cursor:move">
	<span class="avatar-title rounded-circle">
	<i class="fas fa-arrows-alt"></i>
	</span>
	</div>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $fetch['heading'] ?>  </h3>
    <div>
			<div class="text-muted">
			<?php echo $fetch['content'] ?>
			</div>
			<div  style="text-align:right">

			<a href="editcontent.php?cid=<?php echo base64_encode($fetch['id']) ?>" title="Message"><button type="button" class="btn btn-success btn-md "><i class="bx bx-edit"></i> Edit</button></a>
			<a href="#del" class=delete id="<?php echo ($fetch['id']) ?>"  ><button width:100%;margin: 0px auto 25px;overflow:hidden;padding:10px;border:1px dashed #ddd;text-align:center; data-bs-toggle="modal" data-bs-target="#del" class="btn btn-danger btn-md " type="button"><i class="bx bx-trash" ></i> Delete</button></a></td>

			</div>
    </div>
</div>
 <?php }} ?>
</div>
</div>
<div class="col-lg-3">

<div class="card">
<div class="card-body">
<h4 class="card-title mb-4">Page Attribute</h4>
<form action=""method="post">
<div  class="mb-3 col-lg-12">
<label for="status">Name</label>
<input  type="hidden" id="hidId" name="hidId" class="form-control" value="<?php echo $page['id'] ?>"/>
<input onKeyUp="fillPrintableName()" type="text" id="name" name="name" class="form-control" value="<?php echo $page['name'] ?>"/>
</div>
<div  class="mb-3 col-lg-12">
<label for="status">Slug</label>

<input  type="text" id="slug" name="slug" class="form-control" value="<?php echo $page['url'] ?>"/>
</div>
<div  class="mb-3 col-lg-12">
<label for="order">Status</label>
<select class="form-control" name="sts" id="sts">
<option value="1">Published</option>
<option value="0" <?php if($page['status']=='0'){ ?>selected<?php } ?>>Save As Draft</option>

</select>
</div>
	<div class="mb-3 col-lg-12">
	<button type="submit" name="update" class="btn btn-success btn-md w-md">Update </button> <button onclick="goBack()" type="button" name="cancel" class="btn btn-outline-success btn-md w-md">Cancel </button>
	</div>


</form>

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
<script src="assets/libs/select2/js/select2.min.js"></script>
<script src="assets/js/pages/form-advanced.init.js"></script>
<script type="text/javascript">
function goBack() {
  window.history.go(-1);
}

</script>
<script type="text/javascript">
$(document).on("click",".delete",function(){
var a=this.id;
var b=$("#hidid").val();
//alert(b);
var x="<a  href='viewcontent.php?did="+a+"&pid="+b+"'><button class='btn btn-success'>Yes delete it!</button></a>";
$('#delbtn').html(x);
})
</script>
</body>
</html>
