<?php
include("inc/functions.php");
 $api_key = '2fc22670e98abe4f39bc94fbac789463';
$token = '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';
                     //api_key                          //token
$url = "https://$api_key:$token@stephenokpeku.myshopify.com/admin/products.json";
$curl = curl_init( $url );
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
 $jack = json_decode($response, JSON_PRETTY_PRINT);
//echo json_encode($response, TRUE);
// echo print_r($jack);
curl_close($curl);      
$link = "https://$api_key:$token@blinginglight.myshopify.com/admin/api/2021-04/checkouts.json";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $link);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$feed = curl_exec($ch);
 $back = json_decode($feed, true);
 curl_close($ch); 
   foreach($back as $give){
      foreach ($give as $shipping_address) {
        //  echo json_encode($shipping_address['shipping_address']);
        // if(isset($shipping_address['shipping_address'])){
        //   $shipping_address['shipping_address']['first_name'];

        }
        $del_province = $shipping_address['shipping_address']['province']?? "";
        $del_city =  $shipping_address['shipping_address']['city']?? "";
       $del_address =  $shipping_address['shipping_address']['address1']?? "";
       $del_phone =  $shipping_address['shipping_address']['phone']?? "";
        $del_first_name = $shipping_address['shipping_address']['first_name']?? "";
         $del_last_name =  $shipping_address['shipping_address']['last_name']?? "";
         $delivery = $shipping_address['shipping_lines'];
        // echo json_encode($delivery);
        // echo json_decode(print_r($delivery));
      }
   foreach($delivery as $reach){
     $standard = $reach['price'];
    $d_price = $reach['original_shop_price'];
   }
      //  echo $del_last_name;

//shipping_lines

$link = "https://$api_key:$token@blinginglight.myshopify.com/admin/api/2021-04/checkouts.json";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $link);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$feed = curl_exec($ch);
 $back = json_decode($feed, true);
 curl_close($ch);




 

foreach($jack as $props){
  
   foreach($props as $key => $value){
     
    $name = $value['name'];
     $number =  substr($value['phone'],  4);
    $address =  $value['address1'];
     $city =   $value['city'];
   }
  
}




// /** data   */

$ch = curl_init();
$url = "http://206.189.199.89/api/v2.0/BookOrder";
curl_setopt($ch, CURLOPT_URL,  $url);
curl_setopt($ch, CURLOPT_ENCODING, " ");
curl_setopt($ch,  CURLOPT_TIMEOUT,  0);
curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json"
));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
  "CustomerID" => 850,
	"PaymentMode" => "pickup",
    "FixedDeliveryCharge" => 10,
	"Vehicle" => "Bike",

	"IsProductOrder" => 0,
    "BankCode" => "",
    "AccountNumber"=> "",

    "IsProductInsurance" => 0,
    "InsuranceAmount" => 0,
    
    "PickUpContactName" => "$name",
    "PickUpContactNumber" => "0".$number,
    "PickUpGooglePlaceAddress" =>"$address",
    "PickUpLandmark" => "$city",
	
    "PickUpRequestedTime" => "06 AM to 09 PM",
	"PickUpRequestedDate" => "30/09/2020",
    "DeliveryRequestedTime" => "08 AM to 09 PM",

    "Packages" => [
          array(
            "DeliveryContactName" => "$del_first_name"." ". $del_last_name,
            "DeliveryContactNumber" => "$del_phone",
            "DeliveryGooglePlaceAddress" => "$del_address",
            "DeliveryLandmark" => "$del_city",
            "PackageDescription" => "gur",
            "ProductAmount" =>400,
          )
    ],

    "CustomerAuth"=>"QiLmr5TvjkVdbkRedy1iTxxKoJN97BzG"
)));
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2TLS);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
 $response = curl_exec($ch);

 $err = curl_error($ch);

 curl_close($ch);

 if ($err) {
  echo "cURL Error #:" . $err;
 } else {
    $joker = json_decode($response, JSON_PRETTY_PRINT);
    echo print_r($joker);
  //  $conn = mysqli_connect('localhost', 'root', '', 'lawcrest');
  //  if(mysqli_errno($conn)){
	//    echo "failed the connect the DB".mysqli_errno($conn);
	//   mysqli_close($conn);
  //   }
     
//   //    $sql = "INSERT INTO delly(token, update_date, ResponseMessage) values( '".$steve['authentication_token']."', NOW(), '".$steve['authentication_token']."')";
//   //    $query = mysqli_query($conn, $sql);
  }

?>


