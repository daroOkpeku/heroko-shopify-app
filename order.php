<!doctype html>
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

if(!isset($_REQUEST['auth']) && !isset($_REQUEST['id']) && !isset($_REQUEST['shop'])){
  echo "<script> var storage = !!localStorage.getItem('Login')
  let nibble ={};
  if(storage == true){
nibble = JSON.parse(localStorage.getItem('Login'))
console.log(nibble)
  }
console.log(nibble);
var data = 'order.php?auth='+nibble.CustomerAuth+'&id='+nibble.CustomerID+'&shop='+nibble.shop;
storage?window.location.href=data:window.location.href='View.php';
</script>";
}else{
  $auth = $_REQUEST['auth'];
  $consumerid = $_REQUEST['id'];
    $whole = [];
    $sql_all ='SELECT * FROM delly_man_order';
    $query_all = mysqli_query($conn, $sql_all);
    while ($arr_list = mysqli_fetch_assoc($query_all)) {
        array_push($whole, $arr_list);
    }
    for ($s=0; $s<count($whole); $s++) {
        $id = $whole[$s]['id'];
        $line_id =  $whole[$s]['line_id'];
        $dellyid = $whole[$s]['dellymanid'];
        $OrderStatus = $whole[$s]['OrderStatus'];
        $is_trackback =  $whole[$s]['is_trackback'];
        //    = $whole[$s]['product'];
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
                   "CustomerID"=> intval($consumerid),
                   "CustomerAuth"=> $auth,
                   "OrderID"=> intval($dellyid),
                )));
        $res = curl_exec($curl);
        $follow = json_decode($res, true);
        $con_good = json_decode($whole[$s]['product'], true);
        curl_close($curl);
      
      
        foreach ($con_good as $con_list) {
            // echo json_encode($con_list);
            $product_id  =  $con_list['product_id'];
            $sql_sec ="SELECT * FROM rate WHERE product_id='$product_id'  AND line_id='$line_id' ";
            $query_sec = mysqli_query($conn, $sql_sec);
            $fetch_sec = mysqli_fetch_assoc($query_sec);
            $correction  = intval($con_list['amount']) + intval($fetch_sec['quantity']??"");
            $whole[$s]['OrderStatus'] =  $follow['OrderStatus'];
            if ($whole[$s]['OrderStatus'] == 'CANCELLED' && $whole[$s]['is_trackback'] == 0) {
                $sql_num = "UPDATE rate set quantity='$correction' WHERE product_id='$product_id' AND line_id='$line_id'";
                mysqli_query($conn, $sql_num);
                $sql_track = "UPDATE delly_man_order set is_trackback=1, OrderStatus='".$whole[$s]['OrderStatus']."' WHERE dellymanid='$dellyid'";
                mysqli_query($conn, $sql_track);
            }
        }
    } 

include('./Apart.php');
}
?>
