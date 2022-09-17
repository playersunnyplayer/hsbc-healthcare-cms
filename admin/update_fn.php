<?php
ob_start();
session_start();
$adminId=$_SESSION['aid'];
include_once("configuration/connect.php");
include_once("configuration/functions.php");

$post_order_ids = [1,2,3,4,5,6];
$post_order = isset($_POST["post_order_ids"]) ? $_POST["post_order_ids"] : [];
 
if(count($post_order)>0){
	for($order_no= 0; $order_no < count($post_order); $order_no++)
	{
	 $query = "UPDATE websitepage SET position = '".($order_no+1)."' WHERE id = '".$post_order[$order_no]."'";
	 mysqli_query($con, $query);
	}
	echo true; 
}else{
	echo false; 
}

?>