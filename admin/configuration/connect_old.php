<?php
include_once('global.php');
$con=mysqli_connect($Global['host'],$Global['username'],$Global['password'])or die('can\'t establish connection with mysqli');
$dbSelect=mysqli_select_db($con,$Global['database']) or die('could not connect to the database');
//$con=mysqli_connect('localhost','hsbc','TNsUJAjl0.&]','hsbc')or die('can\'t establish connection with mysqli');
?>
