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
?>
<!doctype html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Dashboard </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include 'css.php'; ?>
				<script src="assets/libs/jquery/jquery.min.js"></script>
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
                            <div class="col-xl-12">
                                <div class="card overflow-hidden">
                                    <div class="">
                                        <div class="row">
                                            <div class="col-7">
                                                <div class="p-3">
                                              <h5 class="text-primary" style="margin:10px 0 30px">Welcome <?php echo getAdminName($adminId) ?> !</h5>
                                              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur varius, odio quis vestibulum hendrerit, nisl neque venenatis purus, non scelerisque nulla risus at nisl. Proin pretium, justo quis ultricies vehicula, nisi mi condimentum ar Proin pretium, justo quis ultricies vehicula, nisi mi condimentum arProin pretium, justo quis ultricies vehicula, nisi mi condimentum arProin pretium, justo quis ultricies vehicula, nisi mi condimentum ar </p>
                                             <p style="margin:30px 0 30px"><a  href="addcustomer.php" ><button class="btn-success waves-effect waves-light btn-md w-md btn">Create New Customer</button></a>  <a href="addusers.php" style="margin-left:10px"><button class="btn btn-outline-primary waves-effect waves-light btn-md w-md">Add New User</button></a></p> 
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
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
            </div>
            <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->
  <?php include 'script.php'; ?>
    </body>
</html>
