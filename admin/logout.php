<?php
session_start();
	session_unset('aid');
	session_unset('web');
	session_destroy();
header("location:index.php");

?>
