<?php
// $conn = mysqli_connect('localhost', 'root', '', 'lawcrest');
// if(mysqli_errno($conn)){
// 	echo "failed the connect the DB".mysqli_errno($conn);
// 	mysqli_close($conn);
// }

// $shop = $_GET;
// echo print_r($shop);
// $sql = "SELECT * FROM shopity WHERE shop_url='".$shop['shop']."' LIMIT 1";
// $look = mysqli_query($conn, $sql);
// if(mysqli_num_rows($look) < 1){
//     header("Location:install.php?shop=".$shop['shop']);
//     exit();
// }else{
//     $search = mysqli_fetch_assoc($look);
//      $shop_url = $shop['shop'];
//      $token = $search['access_token'];
     
// }


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://2fc22670e98abe4f39bc94fbac789463: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@blinginglight.myshopify.com/admin/api/2021-07/users/current.json',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;



?>