<?php
// $conn = mysqli_connect('localhost', 'root', '', 'lawcrest');
// if(mysqli_errno($conn)){
// 	echo "failed the connect the DB".mysqli_errno($conn);
// 	mysqli_close($conn);
// }

$shop = $_GET;
echo print_r($shop);
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




?>