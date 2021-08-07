<?php

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
 // echo json_encode($jack);
 foreach ($ray as $song) {
 foreach($song['line_items'] as $line => $doc){
   if($line <= 1) {
    $data[$line] = $doc;

    
}
 }
 }
 
}

echo json_encode($data);
//list('name'=>$name, 'destination_location'=>$destination_location ) = $data;

foreach($data as $round){
// echo json_encode($data);

 $purchasedItem = $round['name'];
 $purchasedQuantity = $round['fulfillable_quantity'];

 $consumerName = $round['destination_location']['name'];
 $houseAddress = $round['destination_location']['address1'];
  $insideHouse = $round['destination_location']['address2'];
 $city = $round['destination_location']['city'];
 

$sql = "INSERT INTO ordershopify (purchasedItem, purchasedQuantity, consumerName, houseAddress, houseApartment, city)
      VALUES('$purchasedItem', '$purchasedQuantity', '$consumerName', '$houseAddress', '$insideHouse', '$city' )";
$query = mysqli_query($conn, $sql);
}

// /** data   */

//  $ch = curl_init();
// $url = "http://206.189.199.89/api/v2.0/GetOrder";
// curl_setopt($ch, CURLOPT_URL,  $url);
// curl_setopt($ch, CURLOPT_ENCODING, " ");
// curl_setopt($ch,  CURLOPT_TIMEOUT,  0);
// curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
// // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
// curl_setopt($ch, CURLOPT_POST, 1);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//     "Content-Type: application/json"
// ));
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
//   "CustomerID" => 850,
//     "CustomerAuth"=>"l3lCF2VusEodN8Z5BV0eg9YDtMqxDyER",
//     "OrderID"=> 1688
// )));
// curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2TLS);
//  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//  $response = curl_exec($ch);
//  echo json_encode($response);
//  $err = curl_error($ch);

//  curl_close($ch);

/**dellyman api */