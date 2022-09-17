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
        <title>Form Repeater | Skote - Admin & Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="shortcut icon" href="assets/images/favicon.ico">
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <script>
        $counter =0;
        //$a =0;
        	// add code
            function addCode(ele)
            {
            	$button = $(ele);
            	// increment
            	$counter += 1;
            	$button.closest('tr').before('<tr><td><div  class="mb-3 col-lg-12"><label for="name">Title</label><input type="text"  name="pp['+$counter+'][title]" class="form-control"/></div><div  class="mb-3 col-lg-12"><label for="name">Content</label><input type="text" class="form-control" id="editor'+$counter+'" placeholder="Content" name="pp['+$counter+'][content]"></div><button class="btn btn-danger btn-md remove_code" type="button" onClick="remove(this)">Remove section</button></td></tr>');
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
<?php include 'header.php'?>

            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">
<?php include 'leftmenu.php' ?>
                </div>
            </div>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->

                        <!-- end page title -->
  <form class="repeater" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Example</h4>
                                        <div class="col-md-12">
                                        <div class="mb-3">
                                        <label for="formrow-logo-input" class="form-label">Page Name</label><br>
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $hqry['name'] ?>">
                                        </div>
                                        </div>
                                        <table class="table ">
                                      			<tr>
                                      				<td>
                                      					<div  class="mb-3 col-lg-12"><label for="name">Title</label><input type="text" id="name" name="pp[0][title]" class="form-control"/></div>
                                      					<div  class="mb-3 col-lg-12"><label for="name">Name</label><input type="text" id="editor" name="pp[0][content]" class="form-control"/></div>		</td>
                                      			</tr>
                                      			<tr>
                                      				<td colspan="2">
                                      					<button class="btn btn-success btn-md" type="button" name="add_code" onClick="addCode(this)"><i class="fa fa-plus"></i> More Section</button>&nbsp;
                                      				</td>
                                      			</tr>
                                      		</table>







                                                </div>

                                            </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Example</h4>
                                    </div>
                                  </div>
                              </div>
                        </div>
                        <!-- end row -->
</form>

                        <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © Skote.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by Themesbrand
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->



        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>

        <!-- form repeater js -->
        <script src="assets/libs/jquery.repeater/jquery.repeater.min.js"></script>

        <script src="assets/js/pages/form-repeater.int.js"></script>

        <script src="assets/js/app.js"></script>
        <script>
        $(document).ready(function() {
			CKEDITOR.replace('editor');
			});
        </script>
    </body>
</html>
