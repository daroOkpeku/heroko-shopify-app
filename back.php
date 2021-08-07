<?php
include('./apicode/connect.php');
$ans ='';
function clean($string){
  $string = stripslashes($string);
  $string  = strip_tags($string);
  $string = trim($string);
  return $string;
}

if(isset($_POST['btn'])){
$newName = $_POST['name'];
$newPhoneNumber = $_POST['PhoneNumber'];
$newItem = $_POST['Item'];
$newAddress = $_POST['Address'];
$newcity = $_POST['city'];
$newQuantity = $_POST['Quantity'];
$newGold = $_POST['gold'];
$newName = clean($newName);
$newName = preg_replace("/[^A-Za-z]/", " ", $newName);
$newName = filter_var($newName, FILTER_SANITIZE_STRING);
$newName = mysqli_real_escape_string($conn, $newName);
// $answer = $newQuantity - $purchasedQuantity;

$newPhoneNumber = clean($newPhoneNumber);
$newPhoneNumber = preg_replace("/[^0-9]/", " ", $newPhoneNumber);
$newPhoneNumber = filter_var($newPhoneNumber, FILTER_SANITIZE_NUMBER_INT);
$newPhoneNumber = mysqli_real_escape_string($conn, $newPhoneNumber);

$newItem = clean($newItem);
$newItem = preg_replace("/[^A-Za-z]/", " ", $newItem);
$newItem = filter_var($newItem, FILTER_SANITIZE_STRING);
$newItem = mysqli_real_escape_string($conn, $newItem);

$newAddress = clean($newAddress);
$newAddress = preg_replace("/[^A-Za-z]/", " ", $newAddress);
$newAddress = filter_var($newAddress, FILTER_SANITIZE_STRING);
$newAddress = mysqli_real_escape_string($conn, $newAddress);

$newcity = clean($newcity);
$newcity = preg_replace("/[^A-Za-z]/", " ", $newcity);
$newcity = filter_var($newcity, FILTER_SANITIZE_STRING);
$newcity = mysqli_real_escape_string($conn, $newcity);

$newQuantity  = clean($newQuantity );
$newQuantity  = preg_replace("/[^0-9]/", " ", $newQuantity );
$newQuantity  = filter_var($newQuantity, FILTER_SANITIZE_NUMBER_INT);
$newQuantity = mysqli_real_escape_string($conn, $newQuantity);

if($newQuantity > $purchasedQuantity){
 echo $ans =   "you can only reduce the Quantity";
  echo $answer;
}else if($newQuantity < $purchasedQuantity){
    //less
    
   $update = "UPDATE ordershopify SET purchasedItem='$newItem',  consumerName='$newName', houseAddress='$newAddress', city='$newcity', purchasedQuantity='$newQuantity', vehicle='$newGold', status='incomplete', forward='$answer' WHERE id='$id' ";
   $query = mysqli_query($conn, $update);
    // $ans = $newQuantity - $purchasedQuantity;
    echo $ans = "it is less";
}else{
    //equal
    echo $ans = "it is equal no remaining";
}
}

?>