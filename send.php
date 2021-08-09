<?php
 $conn = mysqli_connect('localhost', 'root', '', 'test');
 if(mysqli_errno($conn)){
     echo "failed the connect the DB".mysqli_errno($conn);
     mysqli_close($conn);
 }

$list = array('word'=>$_REQUEST['word'], 'product_code'=>$_REQUEST['product_code'], 'carrier'=>$_REQUEST['carrier'], 'product_name'=>$_REQUEST['product_name'] );
// echo json_encode($list);
$line_id = $_REQUEST['line_id'];
$product_code = $_REQUEST['product_code'];
$carrier = $_REQUEST['carrier'];
$product_name = $_REQUEST['product_name'];
$word = $_REQUEST['word'];
$customerId = $_REQUEST['customerId'];
$customerAuth = $_REQUEST['customerAuth'];
//echo json_encode($word);
$fullname = '';
$tele = '';
$city = '';
$fulladdress = '';
$singleProduct =[];
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
   $Owner_name = $Owner_list['name'];
  $Owner_address1 = $Owner_list['address1'];
  $Owner_phone = substr($Owner_list['phone'],  4);
  
  }


  


   $code =  explode(',', $product_code);
   $code_filted = array_filter($code);
 
   $fig = explode(',', $word);
  $fig_filted = array_filter($fig);
  $good = explode(',', $product_name);
  $good_filted = array_filter($good);
for($i=0; $i<count($code_filted); $i++){
    
  $sql = "SELECT * FROM rate WHERE product_id ='$code_filted[$i]' AND line_id='$line_id'";
  $query = mysqli_query($conn, $sql);
  $sub = mysqli_fetch_assoc($query);
  $sub['firstname'];
  $sub['lastname'];
  $sub['phone'];
  $sub['address']; 
  $sub['city'];
 $sub['state'];

$fullname = $sub['firstname']." ".$sub['lastname'].',';
$tele = $sub['phone'];
$fulladdress = $sub['address'].' '.$sub['city'].$sub['state'];
$city = $sub['city'];
}

//correct code






                $ch = curl_init();
                $url = "http://206.189.199.89/api/v2.0/BookOrder";
                curl_setopt($ch, CURLOPT_URL,  $url);
                curl_setopt($ch, CURLOPT_ENCODING, " ");
                curl_setopt($ch,  CURLOPT_TIMEOUT,  0);
                curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                  'Content-Type: application/json'
                ));
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
                  "CustomerID" => intval($customerId),
                    "PaymentMode" => "pickup",
                    "FixedDeliveryCharge" => 0,
                    "Vehicle" =>$carrier,
                
                    "IsProductOrder" => 0,
                    "BankCode" => " ",
                    "AccountNumber"=> " ",
                
                    "IsProductInsurance" => 0,
                    "InsuranceAmount" => 0,
                    
                    "PickUpContactName" => "$Owner_name",
                    "PickUpContactNumber" =>  "0"."$Owner_phone",
                    "PickUpGooglePlaceAddress" =>"$Owner_address1",
                    "PickUpLandmark" => "Mobile",
                    
                    "PickUpRequestedTime" => date("Y-m-d"),
                    "PickUpRequestedDate" => "06/29/2021",
                    "DeliveryRequestedTime" => "08 AM to 09 PM",
                          
                    "Packages" => [
                          array(
                            "DeliveryContactName" => "$fullname",
                            "DeliveryContactNumber" => "$tele",
                            "DeliveryGooglePlaceAddress" => "$city",
                            "DeliveryLandmark" => "Moblie",
                            "PackageDescription" => "$product_name qty('".array_sum(explode(',', $word))."')",
                            "ProductAmount" => "2000",
                          )
                    ],
                
                    "CustomerAuth"=> $customerAuth
                )));
                curl_setopt($ch, CURLOPT_HTTP_VERSION,  CURL_HTTP_VERSION_1_1);
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                 $response = curl_exec($ch);
                 $joker = json_decode($response, TRUE);
                 curl_close($ch);
                 if($joker['ResponseCode'] == '101' || $joker['ResponseCode'] == '400' || !isset($joker['OrderID'])){
                  echo json_encode($joker);
                  exit();
                 }else if($joker['ResponseCode'] == '100'){
                  echo json_encode($joker);
                 }
                   if (isset($joker['OrderID'])) {
                       $curl = curl_init();
                       $link = 'http://206.189.199.89/api/v2.0/TrackOrder';
                       curl_setopt($curl, CURLOPT_URL, $link);
                       curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                       curl_setopt($curl, CURLOPT_ENCODING, '');
                       curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
                       curl_setopt($curl, CURLOPT_TIMEOUT, 0);
                       curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                       curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                       curl_setopt($curl, CURLOPT_POST, true);
                       curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                     'Content-Type: application/json'
                   ));
                       curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
                    "CustomerID"=> intval($customerId),
                    "CustomerAuth"=> $customerAuth,
                    "OrderID"=> intval($joker['OrderID']),
                 )));
                       $res = curl_exec($curl);
                       $sam = json_decode($res, true);
                       if ($sam) {
                           for ($k=0; $k<count($code_filted); $k++) {
                               $sql_list = "SELECT * FROM rate WHERE product_id ='$code_filted[$k]' AND line_id='$line_id'";
                               $query_list = mysqli_query($conn, $sql_list);
                               $sub_list = mysqli_fetch_assoc($query_list);
                               $correct =   $sub_list['quantity']- $fig_filted[$k];
                               $item = array('productName'=>$good_filted[$k], 'amount'=>$fig_filted[$k],  'product_id'=>$code_filted[$k]);
                               array_push($singleProduct, $item);
                               $sql_up = "UPDATE rate set quantity='$correct' WHERE product_id='$code_filted[$k]' AND line_id='$line_id'";
                               mysqli_query($conn, $sql_up);
                              
                           }
                           $pushed = json_encode($singleProduct);
                           $sql_in = "INSERT INTO delly_man_order(line_id, product, Reference, dellymanid, OrderStatus ) values( '$line_id', '$pushed', '".$joker['Reference']."', '".$sam['OrderID']."', '".$sam['OrderStatus']."')";
                           mysqli_query($conn, $sql_in);
                       }
                   }
                    curl_close($curl);
           
                
?>