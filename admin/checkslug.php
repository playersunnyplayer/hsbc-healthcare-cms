<?php
 sleep(1);
 header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
 header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
 header ("Cache-Control: no-cache, must-revalidate");
 header ("Pragma: no-cache");
 include("configuration/connect.php");
 include("configuration/functions.php");
 $code=$_GET['code'];
 $selQry=mysqli_num_rows(mysqli_query($con,"select * from `websiteheader` where `slug`='$code' "));
	if($selQry>0){
	//	$fetch=mysqli_fetch_array(mysqli_query($con,"select usr_name from `user_reg` where `usr_ref_code`='$code' "));
		$x= 'Company slug or username not avilable try another';  // done..successfull
	}else{
	    $x=  'Avilable'; // some problem occured
	}
echo  $selQry.'#'.$x

 ?>
