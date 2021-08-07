<?php
$display = "";
$ch = curl_init();

$url = "http://206.189.199.89/api/v2.0/Vehicles";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$res = curl_exec($ch);
$err = curl_errno($ch);
curl_close($ch); 
if($err){
echo "error".$err;
}

$see = json_decode($res, TRUE);
echo json_encode($see);
?>