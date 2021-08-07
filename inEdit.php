   <?php
   $conn = mysqli_connect('localhost', 'root', '', 'lawcrest');
     if (mysqli_errno($conn)) {
         echo "failed the connect the DB".mysqli_errno($conn);
         mysqli_close($conn);
     }
  
  if(isset($_REQUEST['id']) && isset($_REQUEST['rat'])){
       $id = $_REQUEST['id'];
      $rat = $_REQUEST['rat'];
   
   $Search = "SELECT * FROM ordershopify WHERE id=$id";
      $query = mysqli_query($conn, $Search);
      $fetch = mysqli_fetch_assoc($query);
   $purchasedItem = $fetch['purchasedItem'];
     $purchasedQuantity = $fetch['purchasedQuantity'];
   $consumerName = $fetch['consumerName'];
     $houseAddress =  $fetch['houseAddress'];
    $city = $fetch['city'];
    $order_id = $fetch['order_id'];
      $id = $fetch['id'];
     $sql = "SELECT * FROM consumer WHERE C_name='$rat'";
     $sound = mysqli_query($conn, $sql);
     $shake = mysqli_fetch_assoc($sound);
      $Consumer_phone =  $shake['C_phone'];

     
  }
  ?>