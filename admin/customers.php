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
checkIntrusion($adminId);
if(isset($_GET['did'])&&$_GET['did']!=''){
$did=$_GET['did'];
$delQry=mysqli_query($con,"delete from `websiteheader` where `id`='$did'");
if($delQry){
header("location:customers.php?msg=dls");
}else{
header("location:customers.php?msg=dlf");
}
}
if(isset($_GET['msg'])&&$_GET['msg']!=''){
	$msg=$_GET['msg'];

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
	case 'dls':
		$msg='<strong>Success!</strong> Data Deleted Successfully !!';
		$class='success';
	break;
	case 'dlf':
		$msg='Data not deleted Successfully !!';
		$class='danger';
	break;
	case 'upf':
		$msg='Data data not updated Successfully !!';
		$class='danger';
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
<title>View Company </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include 'css.php'; ?>
<link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<script src=https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js></script>
<script type="text/javascript">
$(document).ready(function(){
$(".showcode").click(function(){
	alert('dfgdf');
var a=this.id;$.ajax({
	url:"viewproductcode.php",type:"post",data:{pid:a},
	success:function(b){
		//var vl=b.split('$');
		$("#pageinfo").html(b);

		}
		})
		})
		});
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
<div class="page-title-box  align-items-center justify-content-between">
<h4 class="mb-3 font-size-18">All Customer</h4>

                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="admin-dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Customer</li>
                                            
                                        </ol>
                                  

</div>
</div>
<div class="col-6" style="text-align:right">
    <div class="page-title-right ">
<a href="addcustomer.php"	<button type="button" class="btn btn-success btn-md waves-effect waves-light">Add New</button></a>
</div>
</div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php if($msg!=''){ ?>
<div class="alert alert-<?php echo $class ?> alert-dismissible fade show" role="alert">
<?php echo $msg; ?>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php } ?>
        
    </div>
</div>
<!-- end page title -->
<div class="row">
<div class="col-lg-12">
<div class="">
<div class="table-responsive">
<table id="datatable" class="table project-list-table table-nowrap align-middle table-borderless">
<!--  <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">-->
<thead>
<tr>
<th scope="col">#</th>
<th scope="col">Logo</th>
<th scope="col">Name</th>
<th scope="col">Slug</th>
<th scope="col">Contact</th>
<th scope="col">Assign To</th>
<th scope="col">Status</th>
<th scope="col">Action</th>
</tr>
</thead>
<tbody>
<?php
$i=0;
$qry=mysqli_query($con,"select * from websiteheader  order by id desc");
$num=mysqli_num_rows($qry);
if($num>0){
while ($product=mysqli_fetch_array($qry)) {
$i++;
?>
<tr>
<td> <div class="avatar-xs">
<span class="avatar-title rounded-circle" >
<?php echo $i; ?>
</span>
</div></td>
<td><img src="../assets/img/<?php echo $product['site_logo'] ?>" alt="" class="avatar-sm" style="max-height: 50px;
    max-width: 100px;
    height: auto;
    width: auto;"></td>
<td><a href="javascript: void(0);" class="text-dark"><?php echo $product['site_name'] ?></a></td>
<td><?php echo ($product['slug']) ?></td>
<td><?php echo $product['site_contact'] ?></td>
<td><?php echo  getAdminName($product['assign_to']) ?></td>
<td><?php echo getEmpStatus($product['status']) ?></td>
<td>
<a href="customerprofile.php?cmp_id=<?php echo base64_encode($product['id']) ?>"><button type="button" class="btn btn-success waves-effect waves-light btn-md"><i class="fas fa-user"></i> Profile</button></a>
<a href="customerpages.php?cmp_id=<?php echo base64_encode($product['id']) ?>"><button type="button" class="btn btn-success waves-effect waves-light btn-md"><i class="far fa-copy"></i> Pages</button></a>
<?php if($product['status']=='1'){?>
<a target="_blank" href="http://cms.dev.patientzone.co.uk/#/<?php echo $product['slug'] ?>" ><button type="button" class="btn btn-success waves-effect waves-light btn-md"><i class="fas fa-globe"></i> Launch </button></a>
<?php } ?>
<a href="#del" class=delete id="<?php echo ($product['id']) ?>"  ><button data-bs-toggle="modal" data-bs-target="#del" class="btn btn-danger btn-md waves-effect waves-light" type="button"><i class="bx bx-trash" ></i> Delete</button></a></td>
</tr>
<?php }}else{?>
<tr><td colspan="8" align="center">--No Record Found--</td></tr>
<?php } ?>
</tbody>
</table>
</div>
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
                                       <div class="avatar-title bg-light rounded-circle text-primary h1">
                                           <i class="mdi mdi-trash-can"></i>
                                       </div>
                                   </div>

                                   <div class="row justify-content-center">
                                       <div class="col-xl-10">
                                           <h4 class="text-primary">Are you sure? !!</h4>
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
<script src="assets/libs/jquery/jquery.min.js"></script>
			<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
			<script src="assets/libs/metismenu/metisMenu.min.js"></script>
			<script src="assets/libs/simplebar/simplebar.min.js"></script>
			<script src="assets/libs/node-waves/waves.min.js"></script>
			<!-- Required datatable js -->
			<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
			<script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
			<!-- Buttons examples -->
			<script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
			<script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
			<script src="assets/libs/jszip/jszip.min.js"></script>
			<script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
			<script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
			<script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
			<script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
			<script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

			<!-- Responsive examples -->
			<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
			<script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

			<!-- Datatable init js -->
			<script src="assets/js/pages/datatables.init.js"></script>

			<script src="assets/js/app.js"></script>
<script type="text/javascript">
$(document).on("click",".delete",function(){
var a=this.id;
var x="<a  href='customers.php?did="+a+"'><button class='btn btn-success'>Yes delete it!</button></a>";
$('#delbtn').html(x);
})
</script>
</body>
</html>
