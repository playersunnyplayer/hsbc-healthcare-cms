<?php $logourl="http://cms.dev.patientzone.co.uk/assets/img/".$filename;
$favIcon="http://cms.dev.patientzone.co.uk/assets/img/".$iconfile;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$curl = curl_init();
    $logourl="https://23consultations.com/patientZoneCMSAdmin/assets/img/".$fname;
$favIcon="https://23consultations.com/patientZoneCMSAdmin/assets/img/".$icon;
$apiid=$id;
$data=array(
"id"=> $apiid,
"identifier"=> $slug,
"logoUrl"=> $logourl,
"faviconIcon"=> $favIcon,
"color"=> $color,
"loginUrl"=> $loginurl,
"termsUrl"=> $tnc,
"privacyPolicyUrl"=> $privacy
);
$data2=json_encode($data);
//print_r($data2);
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://cs.api.dev.patientzone.co.uk/api-patientzone/theme/".$id,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "PUT",
  CURLOPT_POSTFIELDS => $data2,
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 737a2d62-3698-4007-91cb-b38fef76d438"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
echo $response;
?>