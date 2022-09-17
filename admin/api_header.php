<?php
 include("configuration/connect.php");
 include("configuration/functions.php");
 header('Content-Type:application:json');
 header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
 ?>
<?php
if($_SERVER['REQUEST_METHOD']=='GET'){
 $hid  = $_GET['web'];
	$abc=array();
$qry=mysqli_query($con,"SELECT * FROM `websiteheader` where slug='$hid'");
$num=mysqli_num_rows($qry);
$records= array();
if($qry)
{
	while($record=mysqli_fetch_assoc($qry))
	{
		$records[]=$record;

	}
//$abc['msg']=$records;
	echo json_encode($records);
}
}
	//echo $num;
//print_r ($records);
?>
