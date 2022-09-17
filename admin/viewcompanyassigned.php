<?php

 header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

 header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

 header ("Cache-Control: no-cache, must-revalidate");

 header ("Pragma: no-cache");

 include("configuration/connect.php");

 include("configuration/functions.php");
 ?>
<?php


$pid = $_POST['pid'];
		$prog="<table class='table table-striped table-sm table-bordered table-hover table-checkable table-responsive' >
								<thead>
								<tr>
								<th width=1% style='text-align:center;background-color:#f0f0f0;'> SL.No</th>
								<th width=5% style='text-align:left;background-color:#626262;color:#fff'>Comapny</th>
								<th width=8% style='text-align:center;background-color:#94B86E;color:#fff'>Slug</th>
								<th width=5% style='text-align:center;background-color:#F0AD4E;color:#fff'>Date</th>
								</tr>
								</thead>
								<tbody >";
								$disQry=mysqli_query($con,"select * from `websiteheader` where `assign_to`='$pid'  order by id asc");
								$disrows=mysqli_num_rows($disQry);
								$sl=0;
								if($disrows>0){
								while($disfetch=mysqli_fetch_array($disQry)){

							$sl++;
								$prog.="
								<tr>
								<td align='center' >".$sl."</td>
								<td align='center' style='text-align:left'>".$disfetch['site_name']."</td>
								<td align='center'>
								".$disfetch['slug']."
								</td>
								<td align='center'>".$disfetch['date']."</td>

								</tr>";
								}
								}

								$prog.="</tbody></table>";
	echo $prog;
?>
