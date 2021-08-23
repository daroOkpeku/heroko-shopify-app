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
$output = " ";

$email = $_REQUEST['email'];
$pass = $_REQUEST['password'];
$link = $_REQUEST['store'];

 
    $ch = curl_init();

    $url = "http://206.189.199.89/api/v2.0/Login";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_ENCODING, " ");
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json"
));
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
  "Email" => "$email",
    "Password"=> "$pass"
)));
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2TLS);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    
    $err = curl_error($ch);
    curl_close($ch);
    // if ($err) {
    //     echo "cURL Error #:" . $err;
    // }
     $joker = json_decode($response, TRUE);
    
    if($joker['ResponseCode'] == '400' || $joker['ResponseCode'] == '101'){
      $output .=  $joker['ResponseMessage'];
       echo json_encode($joker);
    }else{
      $sql = "SELECT * FROM shopity WHERE shop_url='$link'";
      $query_link = mysqli_query($conn, $sql);
      $num = mysqli_num_rows($query_link);
      list("ResponseMessage" => $ResponseMessage,'Email'=>$Email, 'Name'=>$Name, 'PhoneNumber'=>$PhoneNumber, 'CustomerAuth'=>$CustomerAuth, 'CustomerID'=>$CustomerID) = $joker;
      if($num == 0){
         $zoom =   array('ans'=>"please insert the correct shopify store url");
        echo json_encode($zoom);
      }else{
     $fetch_all = mysqli_fetch_assoc($query_link);
   
     $joker['shop'] =$fetch_all['shop_url'];
     echo json_encode($joker);
      }      
    }
?>
