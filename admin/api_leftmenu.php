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
  $id=getHeaderId($hid);
$qry=mysqli_query($con,"SELECT * FROM `websitepage` WHERE header_id='$id' and status='1' order by position asc");
$num=mysqli_num_rows($qry);
$records= array();
if($qry)
{
	while($record=mysqli_fetch_assoc($qry))
	{
		$records[]=$record;

	}
//$abc['mnu']=$records;
	echo json_encode($records);
}
}
	//echo $num;
//print_r ($records);
?>
