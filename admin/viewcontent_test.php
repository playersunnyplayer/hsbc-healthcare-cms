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
$did=base64_decode($_GET['did']);
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
	$page=mysqli_fetch_array(mysqli_query($con,"select * from websitepage where id='$pid'"));
}
if(isset($_GET['msg'])&&$_GET['msg']!=''){
	$msg=$_GET['msg'];

	switch($msg){
	case 'ins':
		$msg='Data has been added Successfully !!';
		$class='success';
	break;

	case 'inf':
		$msg='Data not inserted Successfully !!';
		$class='danger';
	break;
	case 'ups':
		$msg='Data updated Successfully !!';
		$class='success';
	break;

	case 'upf':
		$msg='Data not updated Successfully !!';
		$class='danger';
	break;
  case 'dls':
		$msg='Data Deleted Successfully !!';
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
        <title>View Content | <?php echo getSiteTitle(); ?> </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include 'css.php'; ?>
<link rel="stylesheet" href="assets/css/msc-style.css">
<script src="assets/js/msc-script.js">
					<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
				<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
				<script type="text/javascript" src="assets/js/bootstrap-select.js"></script>
				<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
				<!-- Font Awesome Css -->
				<link href="css/font-awesome.min.css" rel="stylesheet" />
				<!-- Bootstrap Select Css -->
				<link href="assets/css/bootstrap-select.css" rel="stylesheet" />
				<!-- Custom Css -->
				<link href="assets/css/style.css" rel="stylesheet" />
				<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
				<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
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
                    <div class="container-fluid">
											<div class="row">
						                            <div class="col-12">
						                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
						                                    <h4 class="mb-sm-0 font-size-18"><?php echo  $page['name'].' '.'Page Section' ?></h4>
																								<div class="page-title-right">
																								<a href="addmorecontent.php?pid=<?php echo base64_encode($page['id']) ?>"	<button type="button" class="btn btn-primary btn-sm waves-effect waves-light">Add Content</button></a>

																							                                     </div>
						                                </div>
						                            </div>
						                        </div>
						                        <!-- end page title -->
																		<div class="alert icon-alert with-arrow alert-success form-alter" role="alert" style="display:none">
																		<i class="fa fa-fw fa-check-circle"></i>
																		<strong> Success ! </strong> <span class="success-message"> Post Order has been updated successfully </span>
																		</div>
																		<div class="alert icon-alert with-arrow alert-danger form-alter" role="alert" style="display:none">
																		<i class="fa fa-fw fa-times-circle"></i>
																		<strong> Note !</strong> <span class="warning-message"> Empty list can't be Process </span>
																		</div>
						                        <div class="row">
						                            <div class="col-lg-9">
																						<div class="accordion" id="accordionExample">
	<ul class="list-unstyled" id="post_list">
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
																					<li data-post-id="<?php echo $fetch["id"]; ?>">

																					 <div class="accordion-item"  style="cursor:move">
																							 <h2 class="accordion-header" id="<?php echo $head; ?>">
																									 <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $colsp; ?>" aria-expanded="true" aria-controls="<?php echo $colsp; ?>">
																									<?php echo $fetch['heading'] ?>
																									 </button>
																							 </h2>
																							 <div id="<?php echo $colsp; ?>" class="accordion-collapse collapse" aria-labelledby="<?php echo $head; ?>" data-bs-parent="#accordionExample">
																									 <div class="accordion-body">
																											 <div class="text-muted">
																													 <?php echo $fetch['content'] ?>
																											 </div>
																											 <div  style="text-align:right">

																												<a href="editcontent.php?cid=<?php echo base64_encode($fetch['id']) ?>" title="Message"><button type="button" class="btn btn-dark btn-sm "><i class="bx bx-edit"></i> Edit</button></a>
																												<a href="viewcontent.php?did=<?php echo base64_encode($fetch['id']) ?>&pid=<?php echo base64_encode($pid) ?>" title="Profile"><button type="button" class="btn btn-danger btn-sm "><i class="bx bxs-trash"></i> Delete</button></a>

																											</div>
																									 </div>
																							 </div>
																					 </div>

																						</li>
																					<?php }} ?>
																				</ul>
																				</div>
						                            </div>
						                            <!-- end col -->

						                            <div class="col-lg-3">

						                                <div class="card">
						                                    <div class="card-body">
						                                        <h4 class="card-title mb-4">Page Attribute</h4>
						                                        <div class="table-responsive">
						                                            <table class="table align-middle table-nowrap">
						                                                <tbody>
						                                                    <tr>
						                                                        <td ><h5 class="font-size-14 m-0">Page</h5></td>
						                                                        <td><?php echo $page['name'] ?></td>

						                                                    </tr>
						                                                    <tr>
																																	<td ><h5 class="font-size-14 m-0">Theme</h5></td>
																																 <td><?php echo getThemePosition($page['theme']) ?></td>

						                                                    </tr>
						                                                    <tr>
																																	<td ><h5 class="font-size-14 m-0">Order</h5></td>
																																 <td><?php echo $page['position'] ?></td>
						                                                    </tr>
																																<tr>
																																	<td ><h5 class="font-size-14 m-0">Status</h5></td>
																																 <td><?php echo getStatus($page['status']) ?></td>
						                                                    </tr>
																															<!--	<tr>

																																	<td colspan="2"><button type="button"  class="btn btn-primary btn-sm waves-effect waves-light">Update Page</button></td>
																																</tr>-->

						                                                </tbody>
						                                            </table>

						                                        </div>
						                                    </div>
						                                </div>
						                            </div>
						                            <!-- end col -->
						                        </div>
                    </div>
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
<?php include 'footer.php' ?>
            </div>
            <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->
  <?php include 'script.php'; ?>
	<script type="text/javascript">
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
	}
	});
	});
	</script>
	<script>
document.addEventListener("DOMContentLoaded", function() {
		var demobtn = document.querySelector("#demo1");
		demobtn.addEventListener("click", function() {
			mscConfirm("Delete?",function(){
				mscAlert("Post deleted");
			});
		});
		var demobtn1 = document.querySelector("#demo2");
		demobtn1.addEventListener("click", function() {
			mscConfirm("Delete", "Are you sure you want to delete this post?", function(){
				mscAlert("Post deleted");
			});
		});
		var demobtn2 = document.querySelector("#demo3");
		demobtn2.addEventListener("click", function() {
			mscConfirm("Delete", "Are you sure you want to delete this post?", function(){
				mscAlert("Post deleted");
			},
			function() {
				mscAlert('Cancelled');
			});
		});
		var demobtn3 = document.querySelector("#demo4");
		demobtn3.addEventListener("click", function() {
			mscConfirm({
				title: 'License',
				subtitle: 'Do you accept the licese agreement?',
				okText: 'I Agree',
				cancelText: 'I Dont',
				dismissOverlay: true,
				onOk: function() {
						mscAlert('Awesome.');
				},
				onCancel: function() {
						mscAlert('Sad face :( .');
				}
			});
		});
		var demobtn4 = document.querySelector("#demo5");
		demobtn4.addEventListener("click", function() {
				mscPrompt({
						title: 'Subscribe',
						subtitle: 'Enter your email to subscribe to the newsletter',
						placeholder: 'Your email here', // default: empty, placeholder for input text box
						okText: 'Subscribe',    // default: OK
						cancelText: 'Cancel', // default: Cancel
						onOk: function(val) {
								mscAlert({
										title: "Done",
										subtitle: "Your email: "+val+" has subscribed to the newsletter."
								});
						},
						onCancel: function() {
								mscAlert(":( You cancelled on me.");
						}
				});
		});
		var demobtn5 = document.querySelector("#demo7");
		demobtn5.addEventListener("click", function() {
				mscAlert({
						title: 'Done',
						subtitle: 'You have subscribed to the mailing list.',  // default: ''
						okText: 'Close',    // default: OK
						dismissOverlay: true
				});
		});
		var demobtn6 = document.querySelector("#demo6");
		demobtn6.addEventListener("click", function() {
				mscAlert("Hello world");
		});

		var demobtn7 = document.querySelector("#demo8");
		demobtn7.addEventListener('click', function() {
				mscAlert({
					title: 'Done',

					subtitle: 'You have been registered successfully. \n Your reg. ID is 4321', // default: ''

					okText: 'Close',    // default: OK

				});
		});
});
var disqus_shortname = 'bitwiser'; // required: replace example with your forum shortname
		/* * * DON'T EDIT BELOW THIS LINE * * */
(function() {
		var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
		dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
		(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
})();
</script>
    </body>
</html>
