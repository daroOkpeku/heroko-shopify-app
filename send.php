<?php
$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;
// Connect to DB
$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

$line_id = $_REQUEST['line_id'];
$product_code = $_REQUEST['product_code'];
$carrier = $_REQUEST['carrier'];
$product_name = $_REQUEST['product_name'];
$word = $_REQUEST['word'];
$customerId = $_REQUEST['customerId'];
$customerAuth = $_REQUEST['customerAuth'];
$shop = $_REQUEST['shop'];
$search = "SELECT * FROM shopity WHERE shop_url='$shop'";
$query = mysqli_query($conn, $search);
$discovery = mysqli_fetch_assoc($query);
$access_token = $discovery['access_token'];
 $shop_url = $discovery['shop_url'];
$fullname = '';
$tele = '';
$city = '';
$fulladdress = '';
$singleProduct =[];
$api_key = '2fc22670e98abe4f39bc94fbac789463';
$token = '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';

$link = "https://$api_key:$access_token@$shop_url/admin/api/2021-04/locations.json";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $link);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$feed = curl_exec($ch);
 curl_close($ch); 
  $food  = json_decode($feed, true);
 
  $Owner = [];
  $Owner_name=" ";
  $Owner_address1='';
  $Owner_phone='';

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
 //$sub['state'];

$fullname = $sub['firstname']." ".$sub['lastname'].',';
$tele =   substr($sub['phone'], 4);
$fulladdress = $sub['address'].' '.$sub['city'];
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
                            "DeliveryContactNumber" => '0'."$tele",
                            "DeliveryGooglePlaceAddress" => "$fulladdress",
                            "DeliveryLandmark" => "$city",
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
                          $sql_in = "INSERT INTO delly_man_order(line_id, product, Reference, dellymanid, OrderStatus, store, update_time) values( '$line_id', '$pushed', '".$joker['Reference']."', '".$sam['OrderID']."', '".$sam['OrderStatus']."', '$shop', '".date('Y-m-d')."')";
                           mysqli_query($conn, $sql_in);
                       }
                   }
                    curl_close($curl);
           
                
?>
