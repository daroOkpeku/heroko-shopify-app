<?php
include("./apicode/connect.php");
  $api_key = '2fc22670e98abe4f39bc94fbac789463';
$token = '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';
$url = "https://$api_key:$token@blinginglight.myshopify.com//admin/api/2021-04/orders.json?status=any";
$curl = curl_init( $url );
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
 $jack = json_decode($response, true);
curl_close($curl);
$data = array();
foreach ($jack as $ray) {
  // echo json_encode($ray);
 foreach ($ray as $song) {
 foreach($song['line_items'] as $line => $doc){

    // $doc['destination_location']['name']??" ";
   if($line <= 10) {
    $data[$line] = $doc;

    
              }
 }
 }
 
}
  $link = "https://$api_key:$token@blinginglight.myshopify.com/admin/api/2021-04/locations.json";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $link);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$feed = curl_exec($ch);

 
 curl_close($ch); 
  $food  = json_decode($feed, true);
  foreach($food as $one)
  echo json_encode($one);
     foreach($one as $owner)
   echo $owner['id'];

// echo json_encode($data);
//list('name'=>$name, 'destination_location'=>$destination_location ) = $data;

foreach($data as $round){
 //echo json_encode($data);
  $id = $round['id'];
  $purchasedItem = $round['name'];
 $purchasedQuantity = $round['fulfillable_quantity'];

 $consumerName = $round['destination_location']['name'];
 $houseAddress = $round['destination_location']['address1'];
  $insideHouse = $round['destination_location']['address2'];
 $city = $round['destination_location']['city'];
 

// $sql = "INSERT INTO ordershopify (order_id, purchasedItem, purchasedQuantity, consumerName, houseAddress, houseApartment, city, update_time)
//       VALUES('$id', '$purchasedItem', '$purchasedQuantity', '$consumerName', '$houseAddress', '$insideHouse', '$city',  NOW())";
// $query = mysqli_query($conn, $sql);
}
