<?php
include("./apicode/connect.php");
$api_key = '2fc22670e98abe4f39bc94fbac789463';
$token = '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';
  $link = "https://$api_key:$token@blinginglight.myshopify.com/admin/api/2021-04/locations.json";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $link);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$feed = curl_exec($ch);
 curl_close($ch); 
  $food  = json_decode($feed, true);
  $Owner = [];
  $Owner_name = '';
  $Owner_address1 ='';
  $Owner_phone = '';
  foreach($food as $food_list){
    foreach($food_list as $food_data){
     array_push($Owner, $food_data);
    } 
   
  }
 

  foreach($Owner as $Owner_list){
   $Owner_name .= $Owner_list['name'];
  $Owner_address1 .= $Owner_list['address1'];
  $Owner_phone .= $Owner_list['phone'];
  }

  echo json_encode($Owner_name.$Owner_address1. $Owner_phone);
?>