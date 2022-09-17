<?php
include_once("global.php");
include_once("connect.php");
$baseurl=$Global['baseurl'];
//include_once('class.phpmailer.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require ('PHPMailer/src/PHPMailer.php');
require ('PHPMailer/src/Exception.php');
require ('PHPMailer/src/SMTP.php');
error_reporting(0);
function isLoginSessionExpired() {
	$login_session_duration = 14400;
	$current_time = time();
	if(isset($_SESSION['loggedin_time']) and isset($_SESSION['aid'])){
		if(((time() - $_SESSION['loggedin_time']) > $login_session_duration)){
			return true;
		}
	}	return false;
}
function checkIntrusion($aid){
	if(!isset($_SESSION['aid'])){
		header("location:logout.php");
	}

}
function getCRMDetail(){
	global $con;
	$execQry=mysqli_fetch_row(mysqli_query($con,"select * from `generalsettings` "));
	return $execQry;
}
function getHeaderDetail(){
	global $con;
	$execQry=mysqli_num_rows(mysqli_query($con,"select * from `generalsettings` "));
	return $execQry;
}
function getHeaderId($id){
	global $con;
	$execQry=mysqli_fetch_row(mysqli_query($con,"select id from `websiteheader` where slug='$id'"));
	return $execQry[0];
}
function getCustomerSlugById($id){
	global $con;
	$execQry=mysqli_fetch_row(mysqli_query($con,"select slug from `websiteheader` where id='$id'"));
	return $execQry[0];
}
function getPageId($id,$hid){
	global $con;
	$execQry=mysqli_fetch_row(mysqli_query($con,"select id from `websitepage` where url='$id' and header_id='$hid'"));
	return $execQry[0];
}
function getBreadCrumb($url){
	global $con;
	if(getMenuSubCategoryDetailByUrl($url)){

	$menuArr=getMenuSubCategoryDetailByUrl($url);
	$subCategoryName=$menuArr[2];
	$categoryId=$menuArr[1];
	$categoryName=getMenuCatNameById($categoryId);
	$crumb="<span style='color:#976646;'>Home / ".$categoryName."</span> / <span style='color:#976646;'>".$subCategoryName."</span>";
	}else{
	$crumb=	"<span style='color:#976646;'>Home</span>";
	}
	return $crumb;

}
function getMenuCatNameById($id){
	global $con;
	$execQry=mysqli_fetch_row(mysqli_query($con,"select `category` from `menucategory` where `id`='$id'  "));
	return $execQry[0];
}
function getMenuSubCategoryDetailByUrl($link){
	global $con;

	$qry=mysqli_query($con,"select * from `menusubcategory` where `link`='$link'");
	$numRows=mysqli_num_rows($qry);
	if($numRows>0){
	$execQry=mysqli_fetch_row(mysqli_query($con,"select * from `menusubcategory` where `link`='$link'"));
		return $execQry;
	}else{
		return false;
	}
}
function getMenuIdByUrl($url){
	global $con;

	$menuArr=getMenuSubCategoryDetailByUrl($url);
	$subCategoryName=$menuArr[2];
	$categoryId=$menuArr[1];
	return $categoryId;
}
function getSiteTitle($id){
	global $con;
	$sqlQry=mysqli_query($con,"select `site_name` from `websiteheader` where id='$id' ");
	$fetchQry=mysqli_fetch_row($sqlQry);
	echo stripslashes($fetchQry[0]);
}

function getProjectLogo(){
	global $con;
	$sqlQry=mysqli_query($con,"select `site_logo` from `websiteheader`");
	$fetchQry=mysqli_fetch_row($sqlQry);
	return $fetchQry[0];
}
function limitContent($title,$value){
if(strlen($title)>$value){
	$content=substr($title,0,$value);
}else{
     $content=$title;
}
return $content;
}
function getAdminEmail($id){
	global $con;
	$sqlQry=mysqli_query($con,"select `email` from `admin` where `id`='$id'");
	$fetchQry=mysqli_fetch_row($sqlQry);
	return $fetchQry[0];
}
function getAdminName($id){
	global $con;
	$sqlQry=mysqli_query($con,"select `firstname`,`lastname` from `admin` where `id`='$id'");
	$fetchQry=mysqli_fetch_row($sqlQry);
	return $fetchQry[0].' '.$fetchQry[1];
}
function getAssignedCompany($id){
	global $con;
	$name=array();
	$sqlQry=mysqli_query($con,"select `site_name` from `websiteheader` where `assign_to`='$id'");
	$num=mysqli_num_rows($sqlQry);
	if($num>0){
		while ($fetch=mysqli_fetch_array($sqlQry)) {
			$name[]=$fetch['site_name'];
			// code...
		}
	}else{
		$name[0]='0';
	}
	return $name;
}


function sendFeedBackMail($name,$email,$contact,$message,$baseurl){
	global $con;
$to="sagarallahabad@gmail.com";
$date=date("Y-m-d");
$cemail="thefootballlink.com";
$sub="A New Enquiry  has been received !";
$msg='<head>
	<title>New mail</title>
	<style>
	.mailcontent{
		font-family:Arial, Helvetica, sans-serif;
		font-size:12px;
		padding:5px;
		text-align:justify;
	}
	.verysmalltextblack{
		color:#2C2C2C;
		text-decoration:none;
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:10px;
		font-weight:bold;
	}
	</style>
	</head>

<body>
<table width="100%" style="border:solid 1px #666666" cellpadding="10" cellspacing="0" bgcolor="#F0F0F0" >
  <tr  valign="top" bgcolor="#FFFFFF" >
    <td align="left" colspan="2"  valign="middle"><img src="'.$baseurl.'/images/logo.png" alt="TFL " > </td>
  </tr>
    <tr>
			<td class="mailcontent"><strong>Name  :</strong></td>
			<td class="verysmalltextblack">'.$name.'</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="mailcontent"><strong>Mail :</strong></td>
				<td class="verysmalltextblack">'.$email.'</td>
			 </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="mailcontent"><strong>Contact No :</strong></td>
               <td class="verysmalltextblack">'.$contact.'</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="mailcontent"><strong>Message :</strong></td>
              <td class="verysmalltextblack">'.$message.'</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>

              </tr>
              <tr>
                <td class="mailcontent"><strong>Posted On:</strong></td>
              <td class="verysmalltextblack">'.$date.'</font></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>


</table><body><html>';
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	$mail=@mail($to,$sub,$msg,$headers);
	if($mail){
		return true;
	}else{
		return false;
	}


}

function getStatus($value){
	if($value==1){
		return '<span class="badge rounded-pill bg-success"> Published</span>';
	}
	if($value==0){
		return '<span class="badge rounded-pill bg-warning">In Draft</span>';
	}
}
function getEmpStatus($value){
	if($value==1){
		return '<span class="badge rounded-pill bg-success"> Active</span>';
	}
	if($value==0){
		return '<span class="badge rounded-pill bg-danger">Inactive</span>';
	}
}
function getTempStatus($value){
	if($value==1){
		return '<span class="label label-success">Verified</span>';
	}
	if($value==0){
		return '<span class="label label-default">Not Verify</span>';
	}
	if($value==2){
		return '<span class="label label-danger">Canceled</span>';
	}
	if($value==4){
		return '<span class="label label-info">Form Enter</span>';
	}
}
function getLastUpdate($table,$id){
	global $con;
	$execQry=mysqli_query($con,"select date from $table where `header_id`='$id'  ");
	$fetchRes=mysqli_fetch_row($execQry);
	return $fetchRes[0];

}
function checkContent($table,$id)
{
	global $con;
	$execQry=mysqli_query($con,"select * from $table where `header_id`='$id'  ");
	$fetchRes=mysqli_num_rows($execQry);
	return $fetchRes;
}
function checkcustomerSlug($code)
{
	global $con;
	$execQry=mysqli_query($con,"select * from websiteheader where `slug`='$code'  ");
	$fetchRes=mysqli_num_rows($execQry);
	return $fetchRes;
}
function checkcustomerSlugWithCode($id,$code)
{
	global $con;
	$execQry=mysqli_query($con,"select * from websiteheader where `slug`='$code' and id='$id'  ");
	$fetchRes=mysqli_num_rows($execQry);

	return $fetchRes;
}
function checkPageSlug($webId,$code)
{
	global $con;
	$execQry=mysqli_query($con,"select * from websitepage where `url`='$code' and header_id='$webId' ");
	$fetchRes=mysqli_num_rows($execQry);
	return $fetchRes;
}
function checkAssignCompany($code)
{
	global $con;
	$execQry=mysqli_query($con,"select * from websiteheader where `assign_to`='$code'  ");
	$fetchRes=mysqli_num_rows($execQry);
	return $fetchRes;
}
function getNumberOfRecords($table){
	global $con;
	$execQry=mysqli_query($con,"select count(*) from $table where `status`='1'  ");
	$fetchRes=mysqli_fetch_row($execQry);
	return $fetchRes[0];

}
function resize_both($oldname,$width,$height,$padding='0')
{
  $imgName=$width."_".$height."_".$oldname;
  $newname = "thumb/". $imgName;
  if(!file_exists($newname)){
  $imgpath=$width."_".$height."_".$oldname;
  $thumbh = $height;
  $thumbw = $width;
  $nh = $thumbh;
  $nw = $thumbw;
  $size = getImageSize("photos/".$oldname);
  $w = $size[0];
  $h = $size[1];
  $img_type  = $size[2];
  // Applying calculations to dimensions of the image
  $ratio = $h / $w;
  $nratio = $nh / $nw;

  if($ratio > $nratio)
  {
    $x = intval($w * $nh / $h);
    if ($x < $nw)
    {
      $nh = intval($h * $nw / $w);
    }
    else
    {
      $nw = $x;
    }
  }
  else
  {
    $x = intval($h * $nw / $w);
    if ($x < $nh)
    {
      $nw = intval($w * $nh / $h);
    }
    else
    {
      $nh = $x;
    }
  }
 switch($img_type) {
          case '1':
          $resimage = imagecreatefromgif("photos/".$oldname);
          break;
          case '2':
          $resimage = imagecreatefromjpeg("photos/".$oldname);
          break;
          case '3':
          $resimage = imagecreatefrompng("photos/".$oldname);
          break;
      }
//  $resimage = imagecreatefromjpeg($oldname);
	$newimage = imagecreatetruecolor($nw, $nh);  // use alternate function if not installed
	$white = imagecolorallocate($newimage, 255, 255, 255);
	imagefill($newimage,0,0,$white);
	imagecopyresampled($newimage, $resimage,0,0,0,0,$nw, $nh, $w, $h);
	$viewimage = imagecreatetruecolor($thumbw, $thumbh);
	imagecopy($viewimage, $newimage, 0, 0, 0, 0, $nw, $nh);
	imagejpeg($viewimage, $newname, 85);
	if($padding==1)
	{
		return "<img src='thumb/$imgpath' style='padding:0px 10px 5px 0px ;'  align='left'  >";
	}else{
		return "<img src='thumb/$imgpath'  align='left'   >";
	}
	}else{
		if($padding==1)
		{
			return "<img src='$newname'  style='padding:0px 10px 5px 0px;' align='left'   >";
		}else{
			return "<img src='$newname'   align='left'   >";

		}
	}

}

function sendWelcomeMail($to,$from,$fromname,$subject,$msg,$Attech,$cardbenefits,$hotel,$prog_id){
		$uid=getUsernameAndPwdForEmail($prog_id);
		$uname=$uid[0];
		$upwd=$uid[1];
		$headers = 'MIME-Version: 1.0 \r\n'.
		'Content-type: text/html \r\n'.
		'X-Mailer: PHP/' . phpversion();
		$mail = new PHPMailer(true);
		$mail->IsHTML(true);
	    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
		$mail->isSMTP();
		$mail->SMTPAuth = true;  		// Set mailer to use SMTP
		if($prog_id =='22' || $prog_id =='24' || $prog_id =='26' || $prog_id =='29' || $prog_id =='32' || $prog_id =='35'|| $prog_id =='33')
		{
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;
		}
		else{
		$mail->SMTPSecure = 'non ssl';
		$mail->Host = "mail.rezervedindia.in";
		$mail->Port = 25;
		}
		$mail->Username = $uname;                 // SMTP username
		$mail->Password = $upwd;                         // SMTP password

		$mail->SMTPOptions = array(
		'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
		)
		);
		$mail->From = $from;
		$mail->FromName =$fromname;
		$mail->AddAddress($to);
		$mail->Subject = $subject;
		$mail->Body    = $msg;
		//$mail->AddAttachment($Attech);
		//$mail->AddAttachment($cardbenefits);
		$mail=$mail->Send();
}
function sendBasicMail($to,$from,$fromname,$subject,$msg,$Attech,$cardbenefits,$prog_id){
		$uid=getUsernameAndPwdForEmail($prog_id);
		$uname=$uid[0];
		$upwd=$uid[1];
		$headers = 'MIME-Version: 1.0 \r\n'.
		'Content-type: text/html \r\n'.
		'X-Mailer: PHP/' . phpversion();
		$mail = new PHPMailer(true);
		$mail->IsHTML(true);
	    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
		$mail->isSMTP();
		$mail->SMTPAuth = true;  		// Set mailer to use SMTP
		if($prog_id =='22' || $prog_id =='24' || $prog_id =='26' || $prog_id =='29' || $prog_id =='32' || $prog_id =='35'|| $prog_id =='33')
		{
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;
		}
		else{
		$mail->SMTPSecure = 'non ssl';
		$mail->Host = "mail.rezervedindia.in";
		$mail->Port = 25;
		}
		$mail->Username = $uname;                 // SMTP username
		$mail->Password = $upwd;                         // SMTP password
		$mail->SMTPOptions = array(
		'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
		)
		);
		$mail->From = $from;
		$mail->FromName=$fromname;
		$mail->AddAddress($to);
		$mail->Subject= $subject;
		$mail->Body= $msg;
		$mail->AddAttachment($Attech);
		$mail->AddAttachment($cardbenefits);
		$mail=$mail->Send();
}
function sendRenewalFormatMail($to,$from,$fromname,$subject,$msg,$prog_id){

	$uid=getUsernameAndPwdForEmail($prog_id);
		$uname=$uid[0];
		$upwd=$uid[1];
		$headers = 'MIME-Version: 1.0 \r\n'.
		'Content-type: text/html \r\n'.
		'X-Mailer: PHP/' . phpversion();
		$mail = new PHPMailer(true);
		$mail->IsHTML(true);
	    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
		$mail->isSMTP();
		$mail->SMTPAuth = true;  		// Set mailer to use SMTP
		if($prog_id =='22' || $prog_id =='24' || $prog_id =='26' || $prog_id =='29' || $prog_id =='32' || $prog_id =='35'|| $prog_id =='33')
		{
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;
		}
		else{
		$mail->SMTPSecure = 'non ssl';
		$mail->Host = "mail.rezervedindia.in";
		$mail->Port = 25;
		}
		$mail->Username = $uname;                 // SMTP username
		$mail->Password = $upwd;                         // SMTP password

		$mail->SMTPOptions = array(
		'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
		)
		);
		$mail->From = $from;
		$mail->FromName =$fromname;
		$mail->AddAddress($to);
		$mail->Subject = $subject;
		$mail->Body    = $msg;
		$mail=$mail->Send();
		/*if($mail){
		return true;
		}else{
		return false;
		}*/
}
function sendSecurityAlertMail($msg){
		$headers = 'MIME-Version: 1.0 \r\n'.
		'Content-type: text/html \r\n'.
		'X-Mailer: PHP/' . phpversion();
		$mail = new PHPMailer(true);
		$mail->IsHTML(true);
	    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
		$mail->isSMTP();
		$mail->SMTPAuth = true;  		// Set mailer to use SMTP
		$mail->SMTPSecure = 'non ssl';
		$mail->Host = "mail.rezervedindia.in";
		$mail->Port = 25;    // SMTP password
		$mail->Username = 'contactus@rezervedindia.in';                 // SMTP username
		$mail->Password = 'pms@1234';
		$mail->SMTPOptions = array(
		'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
		)
		);
		$mail->From ="info.privilegemember@gmail.com";
		$mail->FromName ="Privilege Member";
		$mail->AddAddress("it@coiclub.in");
		$mail->Subject ="Security Alert";
		$mail->Body = $msg;
			$maill=$mail->Send();
		if($maill){
		return true;
		}else{
		return false;
		}
}
function sendRoomReservationMail($to,$from,$fromname,$subject,$msg){
	$headers = 'MIME-Version: 1.0 \r\n'.
		'Content-type: text/html \r\n'.
		'X-Mailer: PHP/' . phpversion();
		$mail = new PHPMailer();
		$mail->IsSMTP();                                      // Set mailer to use SMTP
		$mail->IsHTML(true);
		$mail->From = $from;
		$mail->FromName =$fromname;
		$mail->SMTPAuth = false;
		$mail->AddAddress($to);
		$mail->Subject = $subject;
		$mail->Body    = $msg;
		$mail=$mail->Send();
		if($mail){
		return true;
		}else{
		return false;
		}
}
function sendRoomMail($to,$from,$fromname,$subject,$msg,$cc,$bcc,$prog_id){
		$uid=getUsernameAndPwdForEmail($prog_id);
		$uname=$uid[0];
		$upwd=$uid[1];
		$headers = 'MIME-Version: 1.0 \r\n'.
		'Content-type: text/html \r\n'.
		'X-Mailer: PHP/' . phpversion();
		$mail = new PHPMailer(true);
		$mail->IsHTML(true);
	    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
		$mail->isSMTP();
		$mail->SMTPAuth = true;  		// Set mailer to use SMTP
		if($prog_id =='22' || $prog_id =='24' || $prog_id =='26' || $prog_id =='29' || $prog_id =='32' || $prog_id =='35')	{
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;
		}
		else{
		$mail->SMTPSecure = 'non ssl';
		$mail->Host = "mail.rezervedindia.in";
		$mail->Port = 25;
		}// Specify main and backup SMTP servers
		                             // Enable SMTP authentication
		$mail->Username = $uname;                 // SMTP username
		$mail->Password = $upwd;                         // SMTP password
		$mail->SMTPOptions = array(
		'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
		)
		);
		$mail->From = $from;
		$mail->FromName =$fromname;
		$array =explode(',',$to);
		foreach($array as $email) {
		$mail->AddAddress($email);
		}
		if ($cc!=''){
		$ccarray =explode(',',$cc);
		foreach($ccarray as $ccemail) {
		$mail->AddCC($ccemail);
		}
		}
		if ($bcc!=''){
		$bccarray =explode(',',$bcc);
		foreach($bccarray as $bccemail) {
		$mail->AddBCC($bccemail);
		}
		}
		//$mail->AddCC('sanjeev.7836kumar@gmail.com');
		$mail->Subject = $subject;
		$mail->Body    = $msg;
		$mail=$mail->Send();
		if($mail){
		return true;
		}else{
		return false;
		}
}
function sendGenralQueryMail($to,$from,$fromname,$subject,$msg){
		$headers = 'MIME-Version: 1.0 \r\n'.
		'Content-type: text/html \r\n'.
		'X-Mailer: PHP/' . phpversion();
		$mail = new PHPMailer(true);
		$mail->IsHTML(true);
	    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
		$mail->isSMTP();
		$mail->SMTPAuth = true;  		// Set mailer to use SMTP

		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;
                         // SMTP password
		$mail->SMTPOptions = array(
		'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
		)
		);
		$mail->From =$from;
		$mail->Username = $from;                 // SMTP username
		$mail->Password = 'pms@1234$';
		$mail->FromName =$fromname;
		$array =explode(',',$to);
		foreach($array as $email) {
		$mail->AddAddress($email);
		}
		//$mail->AddCC('sanjeev.7836kumar@gmail.com');
		$mail->Subject = $subject;
		$mail->Body    = $msg;
		$mail=$mail->Send();
		if($mail){
		return true;
		}else{
		return false;
		}
}
function sendSocialLinkMail($to,$from,$fromname,$subject,$msg,$prog_id){
	$uid=getUsernameAndPwdForEmail($prog_id);
		$uname=$uid[0];
		$upwd=$uid[1];
		$headers = 'MIME-Version: 1.0 \r\n'.
		'Content-type: text/html \r\n'.
		'X-Mailer: PHP/' . phpversion();
		$mail = new PHPMailer(true);
		$mail->IsHTML(true);
	    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
		$mail->isSMTP();
		$mail->SMTPAuth = true;  		// Set mailer to use SMTP
		if($prog_id =='22' || $prog_id =='24' || $prog_id =='26' || $prog_id =='29' || $prog_id =='32' || $prog_id =='35')	{
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;
		}
		else{
		$mail->SMTPSecure = 'non ssl';
		$mail->Host = "mail.rezervedindia.in";
		$mail->Port = 25;
		}		// Specify main and backup SMTP servers
		                             // Enable SMTP authentication
		$mail->Username = $uname;                 // SMTP username
		$mail->Password = $upwd;
		$mail->SMTPOptions = array(
		'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
		$mail->From = $from;
		$mail->FromName =$fromname;
		$mail->AddAddress($to);
		$mail->Subject = $subject;
		$mail->Body    = $msg;
		$mail=$mail->Send();
		if($mail){
		return true;
		}else{
		return false;
		}
}
function sendBDMail($to,$cc,$subject,$msg){
	$Attech='The Choice of India.pptx';
		$headers = 'MIME-Version: 1.0 \r\n'.
		'Content-type: text/html \r\n'.
		'X-Mailer: PHP/' . phpversion();
		$mail = new PHPMailer(true);
		$mail->IsHTML(true);
	    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
		$mail->isSMTP();
		$mail->SMTPAuth = true;  		// Set mailer to use SMTP

		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;
		$mail->Username = 'info@coiclub.com';                 // SMTP username
		$mail->Password = 'zsyxrehmbfrlpllh';
		$mail->SMTPOptions = array(
		'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
		)
		);
		$mail->From ='info@coiclub.com';
		$mail->FromName ='The Choice Of India';
		$array =explode(',',$to);
		foreach($array as $email){
		$mail->AddAddress($email);
		}
		if ($cc!=''){
		$ccarray =explode(',',$cc);
		foreach($ccarray as $ccemail) {
		$mail->AddCC($ccemail);
		}
		}
		$mail->AddAttachment($Attech);
		$mail->Subject = $subject;
		$mail->Body    = $msg;
		$mail=$mail->Send();
		if($mail){
		return true;
		}else{
		return false;
		}
}
function sendGOVGOBDMail($to,$cc,$subject,$msg){
	//$Attech='The Choice of India.pptx';
		$headers = 'MIME-Version: 1.0 \r\n'.
		'Content-type: text/html \r\n'.
		'X-Mailer: PHP/' . phpversion();
		$mail = new PHPMailer(true);
		$mail->IsHTML(true);
	    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
		$mail->isSMTP();
		$mail->SMTPAuth = true;  		// Set mailer to use SMTP
		$mail->SMTPSecure = 'non ssl';
		$mail->Host = "mail.rezervedindia.in";
		$mail->Port = 25;
		$mail->Username = 'info@govgo.co.in';                 // SMTP username
		$mail->Password = 'Pms@1234';
		$mail->SMTPOptions = array(
		'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
		)
		);
		$mail->From ='info@govgo.co.in';
		$mail->FromName ='Go-V-Go';
		$array =explode(',',$to);
		foreach($array as $email){
		$mail->AddAddress($email);
		}
		if ($cc!=''){
		$ccarray =explode(',',$cc);
		foreach($ccarray as $ccemail) {
		$mail->AddCC($ccemail);
		}
		}
		//$mail->AddAttachment($Attech);
		$mail->Subject = $subject;
		$mail->Body    = $msg;
		$mail=$mail->Send();
		if($mail){
		return true;
		}else{
		return false;
		}
}
function sendSmtpMail2($to,$from,$fromname,$subject,$msg){

	$headers = 'MIME-Version: 1.0 \r\n'.
		'Content-type: text/html \r\n'.
		'X-Mailer: PHP/' . phpversion();
		$mail = new PHPMailer();
		$mail->IsSMTP();                                      // Set mailer to use SMTP

		$mail->IsHTML(true);
		$mail->From = $from;
		$mail->FromName =$fromname;
		$mail->SMTPAuth = true;
		$mail->Host = 'smtp.gmail.com';  // specify main and backup server
		$mail->Username = 'jayshreekumari1992@gmail.com';  // SMTP username
		$mail->Password = 'fb$rtq9694'; // SMTP password
		$mail->AddAddress($to);
		$mail->Subject = $subject;
		$mail->Body    = $msg;
		$mail=$mail->Send();
		if($mail){
		return true;
		}else{
		return false;
		}
}
function compressImage($source_image, $compress_image) {
$image_info = getimagesize($source_image);
if ($image_info['mime'] == 'image/jpeg') {
$source_image = imagecreatefromjpeg($source_image);
imagejpeg($source_image, $compress_image, 75);
} elseif ($image_info['mime'] == 'image/gif') {
$source_image = imagecreatefromgif($source_image);
imagegif($source_image, $compress_image, 75);
} elseif ($image_info['mime'] == 'image/png') {
$source_image = imagecreatefrompng($source_image);
imagepng($source_image, $compress_image, 6);
}
elseif ($image_info['mime'] == 'image/svg') {
$source_image = imagecreatefrompng($source_image);
imagepng($source_image, $compress_image, 6);
}
elseif ($image_info['mime'] == 'image/ico') {
$source_image = imagecreatefrompng($source_image);
imagepng($source_image, $compress_image, 4);
}
return $compress_image;
}
function getPageNameById($id){
	global $con;
	$sqlQry=mysqli_query($con,"select `name` from `websitepage` where `id`='$id'");
	$fetchQry=mysqli_fetch_row($sqlQry);
	return $fetchQry[0];
}
function getTotalPage($id){
	global $con;
	$sqlQry=mysqli_query($con,"select id from `websitepage` where header_id='$id' ");
	$fetchQry=mysqli_num_rows($sqlQry);
	$res=$fetchQry+2;
	return $res;
}
function getCheckPageContentById($id){
	global $con;
	$sqlQry=mysqli_query($con,"select id from `websitepagecontent` where `pid`='$id'");
	$fetchQry=mysqli_num_rows($sqlQry);
	return $fetchQry;
}
function getNextPosition(){
	global $con;
	$sqlQry=mysqli_query($con,"select max(position) from `websitepage` ");
	$fetchQry=mysqli_fetch_row($sqlQry);
	$id=$fetchQry[0]+1;
	return $id;
}
function getContentNextPosition($id){
	global $con;
	$sqlQry=mysqli_query($con,"select max(position) from `websitepagecontent` where pid='$id' ");
	$fetchQry=mysqli_fetch_row($sqlQry);
	$id=$fetchQry[0];
	return $id;
}
function getThemePosition($id){
	global $con;
	if ($id==1) {
		$thm='Theme One';// code...
	}
	if ($id==2) {
		$thm='Theme Two';// code...
	}
	if ($id==3) {
		$thm='Theme Three';// code...
	}
	return $thm;
}

function generateRandomString($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function getWebsiteColor() {
/*global $con;
	$sqlQry=mysqli_query($con,"select `color` from `websiteheader`  ");
	$num=mysqli_num_rows($sqlQry);
	if($num>0){
	$fetchQry=mysqli_fetch_row($sqlQry);
	$id=$fetchQry[0];
}else{
	$id='#AC286B';
}*/
//$id="#04b1a8";
$id="#00128C";
	return $id;
}
?>
