<?php
include("connect.php");

$search = "SELECT * FROM rate";
$query = mysqli_query($conn, $search);
$data = array();
while($fetch = mysqli_fetch_array($query)){
$data[] = $fetch;
}

 echo json_encode($data);

?>