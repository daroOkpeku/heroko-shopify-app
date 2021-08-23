<?php
include("connect.php");
$total =[];
$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;
// Connect to DB
$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

$shop = $_REQUEST['shop'];
$search = "SELECT * FROM shopity WHERE shop_url='$shop'";
$query = mysqli_query($conn, $search);
$discovery = mysqli_fetch_assoc($query);
$access_token = $discovery['access_token'];
 $shop_url = $discovery['shop_url'];

 $api_key = '2fc22670e98abe4f39bc94fbac789463';
$token = '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';
$url = "https://$api_key:$access_token@$shop_url/admin/api/2021-07/orders.json";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
curl_setopt($curl, CURLOPT_ENCODING, '');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl,  CURLOPT_MAXREDIRS, 10);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($curl, CURLOPT_TIMEOUT, 0);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
$response = curl_exec($curl);
 $jack = json_decode($response, true);

curl_close($curl);
// $data = array();

foreach($jack as $key => $jack_data){
   foreach($jack_data as $item){
	     $date = $item['created_at'];
	  // echo json_encode($item['order_status_url']);
	 $address1  =  $item['customer']['default_address']['address1'];
	 $city  =  $item['customer']['default_address']['city'];
	 $province = $item['customer']['default_address']['province'];
	$id = $item['id'];
	$first_name = $item['customer']['first_name'];
	    $last_name = $item['customer']['last_name'];
		$phone = $item['customer']['phone'];
        $email = $item['customer']['email'];
	   $order_id  =	$item['customer']['last_order_id']?$item['customer']['last_order_id']:'undefined';
	  if(!empty($item['line_items'])){
		$answer = $item['line_items'];
         
          foreach($item['line_items'] as $item_list){
			 $vendor = $item_list['vendor'].".myshopify.com";
			 $product_id =  $item_list['product_id'];
			$quantity = $item_list['quantity'];   
			 $price = $item_list['price_set']['presentment_money']['amount'];
			         $product_name = $item_list['title'];
					 $sku = $item_list['sku'];
			$arr = array('line_id'=>$id,'firstname'=>$first_name, 'lastname'=>$last_name, 'phone'=>$phone, 'email'=>$email, 'order_id'=>$order_id, 'quantity'=>$quantity, 'price'=>$price, 'productname'=>$product_name, 'sku'=>$sku, 'product_id'=>$product_id, 'address'=>$address1, 'city'=>$city, 'province'=>$province, 'vendor'=>$vendor,  'date'=>$date);
			array_push($total, $arr);
    
		  }
	  }
   }
}


 
for($i =0; $i<count($total); $i++){

	$product_id = $total[$i]['product_id'];
	$line_id = $total[$i]['line_id'];
	$sql_in = "SELECT * FROM rate WHERE line_id='$line_id' AND product_id='$product_id' ";
	$query_in = mysqli_query($conn, $sql_in);
     $num_in = mysqli_num_rows($query_in);
    if($num_in > 0){
    //  return false;
	}else{
		$sql_send = "INSERT INTO rate(firstname, lastname, phone, email, orderid, quantity, amount, product, sku, line_id, product_id, address, city,  vendor, created_date) values( '".$total[$i]['firstname']."', '".$total[$i]['lastname']."', '".$total[$i]['phone']."', '".$total[$i]['email']."', '".$total[$i]['order_id']."', '".$total[$i]['quantity']."', '".$total[$i]['price']."', '".$total[$i]['productname']."', '".$total[$i]['sku']."', '".$total[$i]['line_id']."', '".$total[$i]['product_id']."', '".$total[$i]['address']."', '".$total[$i]['city']."',  '".$total[$i]['vendor']."', '".$total[$i]['date']."')";
		 $query = mysqli_query($conn, $sql_send);
	}
}

 

?>
