<?php
ob_start();
session_start();
include("configuration/connect.php");
include("configuration/functions.php");
$logo=getProjectLogo();
//$name=getProjectName();
$myIp=$_SERVER['REMOTE_ADDR'];
$device=php_uname();
$deviceuser=getenv("username");
$ldate=date("d F, Y h:i A");
$odate=date("d/m/Y");
$ltime=date("h:i A");
if(isset($_POST['login']))
	{
		$email=mysqli_real_escape_string($con,$_POST['username']);
		$apwd=mysqli_real_escape_string($con,$_POST['password']);
			$admres=mysqli_query($con,"select * from `admin` where `username`='$email' and `password`='$apwd' ");
			if(mysqli_num_rows($admres)>0)
			{$adm=mysqli_fetch_row($admres);
        $aid=$adm[0];
         $name=$adm[1].''.$adm[2];
         $user=$adm[1];$image=$adm[12];
        $logindate=date("d F, Y h:i A");
           $admres=mysqli_query($con,"update `admin` set `last_login`='$logindate' where `id` = '$aid'");
              $_SESSION['aid']=$aid;
              $_SESSION['loggedin_time'] = time();
              setcookie('username',$user,time()+3600*240);
              setcookie('loginname',$name,time()+3600*240);
              setcookie('loginimage',$image,time()+3600*240);
        $sql=mysqli_query($con,'select * from websiteheader ');
				$num=mysqli_num_rows($sql);
        if($aid=='7'){

										header("location:admin-dashboard.php");
								}
                else{
								header("location:selectcompany.php");
								}
			}
      else{
      header("location:index.php?msg=inf");
      }
    }
if(isset($_GET['msg'])&&$_GET['msg']!=''){
	$msg=$_GET['msg'];
	if($msg=='inf'){
		$msgText="Wrong Username Or Password";
	}elseif($msg=='cpt'){
		$msgText="Wrong captcha";
	}elseif($msg=='exp'){
		$msgText="Your Session is expired login again";
	}
	elseif($msg=='err'){
		$msgText="Something goes worng!!!!";
	}else{
		$msgText='';
	}
}

?>
<!doctype html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Login </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <?php include 'css.php'; ?>

    </head>

    <body>
        <div id="main" class="account-pages my-5 pt-sm-4">
            <div class="container">
							<div class="row">
                <div class="col-lg-12">
                    <div class="text-center mb-4 text-muted">
										
                        <span  style="text=align:center;height:100px;width:100px;">
                            <img src="assets/images/TIHLogo.svg" alt="" class="" style="width:170px">
                        </span>

                    </div>
                </div>
            </div>
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-5 col-xl-4">
                        <div class="card overflow-hidden">

                            <div class="card-body ">
                                <div class="p-2">
                                  <?php if($msg!=''){ ?>
                                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                               	<?php echo $msgText; ?>
                                               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                           </div>
                                        <?php } ?>

                                    <form class="form-horizontal" action=""method="post">

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text"required class="form-control" id="username" name="username" placeholder="Enter username">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div class="input-group auth-pass-inputgroup" >
                                                <input type="password" required class="form-control" name="password" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                                                <button class="btn btn-light " type="button" id="password-addon" style="border:1px solid #ced4da"><i class="mdi mdi-eye-outline"></i></button>
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember-check">
                                            <label class="form-check-label" for="remember-check">
                                                Remember me
                                            </label>
                                        </div>

                                        <div class="mt-3 d-grid">
                                            <button class="btn waves-effect waves-light" style="background-color:<?php echo getWebsiteColor(); ?>;color:#fff" type="submit"name="login">Log In</button>
                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>
                      <!--  <div class="mt-5 text-center">
                            <div>
                                <p class="text-muted" > Powered By <img src="Picture3.png" height="37"/></p>
                            </div>
                        </div>-->

                    </div>
                </div>
            </div>
        </div>
        <!-- end account-pages -->
				<script src="assets/libs/jquery/jquery.min.js"></script>
				        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
				        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
				        <script src="assets/libs/simplebar/simplebar.min.js"></script>
				        <script src="assets/libs/node-waves/waves.min.js"></script>

				        <!-- App js -->
				        <script src="assets/js/app.js"></script>

    </body>
</html>
