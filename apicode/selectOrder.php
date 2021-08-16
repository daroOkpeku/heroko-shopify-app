<?php
include("connect.php");
$find = "SELECT * FROM rate  ";
$query_f = mysqli_query($conn, $find);
$data = array();
while($fetch = mysqli_fetch_array($query_f)){
$data[] = $fetch;
}
 echo json_encode($data);

?>