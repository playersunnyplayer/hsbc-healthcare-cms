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
 $pid  = $_GET['pid'];
 $hid  = $_GET['web'];
 $abc=array();
$id=getHeaderId($hid);
$qry6=mysqli_fetch_array(mysqli_query($con,"SELECT position FROM `websitepage` WHERE url='$pid' and header_id='$id' "));
$pos=$qry6['position'];
$qry=mysqli_query($con,"SELECT * FROM `websitepage` WHERE position>'$pos' and status='1' and header_id='$id' order by position asc limit 1");
$num=mysqli_num_rows($qry);
$records= array();

if($num>0){
if($qry)
{
	while($record=mysqli_fetch_assoc($qry))
	{
	array_push($records,array(
		"slug"=>$hid,
		"url"=>$record['url'],
		"name"=>$record['name']

		));

	}
//	$records['slug']=$hid;
//$abc['mnu']=$records;

/*array_push($records,array(
		"slug"=>$hid

		));*/

}
}
else{
  array_push($records,array("id"=>'0',
  	        "slug"=>$hid,
	    	"url"=>'contact-us',
	    	"name"=>'contact-us'

		));
}
echo json_encode($records);
}
	//echo $num;
//print_r ($records);
?>
