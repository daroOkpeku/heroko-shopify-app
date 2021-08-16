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
// include("connect.php");
function clean($string){
  $string = stripslashes($string);
  $string  = strip_tags($string);
  $string = trim($string);
  return $string;
}
// if (isset($_POST['btn'])) {
    $email = $_REQUEST['email'];
    $pass = $_REQUEST['password'];
    $link = $_REQUEST['store'];
    $email = mysqli_real_escape_string($conn, $email);
    $pass = mysqli_real_escape_string($conn, $pass);
    $email = clean($email);
    $pass = clean($pass);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $pass = preg_replace("/[^A-Za-z0-9]/", " ", $pass);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
 
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
    //  echo print_r($joker);
    if($joker['ResponseCode'] == '400' || $joker['ResponseCode'] == '101'){
      $output .=  $joker['ResponseMessage'];
    }else{
      $sql = "SELECT * FROM shopity WHERE shop_url='$link'";
      $query_link = mysqli_query($conn, $sql);
      $num = mysqli_num_rows($query_link);
      list("ResponseMessage" => $ResponseMessage,'Email'=>$Email, 'Name'=>$Name, 'PhoneNumber'=>$PhoneNumber, 'CustomerAuth'=>$CustomerAuth, 'CustomerID'=>$CustomerID) = $joker;
      if($num == 0){
        $zoom = "please insert the correct shopify store url";
        echo json_encode($zoom);
      }else{
     $fetch_all = mysqli_fetch_assoc($query_link);
     $joker['shop'] =$fetch_all['shop_url'];
     echo json_encode($joker);
     
      }
     
      // $sql = "REPLACE INTO delly(Email, Name, PhoneNumber, CustomerAuth, CustomerID, upadta_time ) values('$Email', '$Name', '$PhoneNumber', '$CustomerAuth', '$CustomerID', NOW() )";
      //  $query = mysqli_query($conn, $sql);
    // echo json_encode($joker);
        // header("Location:index.php?auth=$CustomerAuth&ID=$CustomerID");
        
         
    }
?>
