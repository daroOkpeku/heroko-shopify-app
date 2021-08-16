<?php
include("connect.php");
$search = "SELECT * FROM shopity";
$query_se = mysqli_query($conn, $search);
$discovery = mysqli_fetch_assoc($query_se);
 $shop_url = $discovery['shop_url'];

$find = "SELECT * FROM rate WHERE vendor='$shop_url' ";
$query_f = mysqli_query($conn, $find);

$data = array();
while($fetch = mysqli_fetch_array($query_f)){
$data[] = $fetch;
}

 echo json_encode($data);

?>