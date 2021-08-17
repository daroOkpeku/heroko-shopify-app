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
 echo "<script type='text/javascript'> 
  var orderStorage = !!localStorage.getItem('Login')
  let nibble ={};
  if(orderStorage == true){
nibble = JSON.parse(localStorage.getItem('Login'))
  }
var data = 'order.php?auth='+nibble.CustomerAuth+'&ID='+nibble.CustomerID+'&shop='+nibble.shop;
orderStorage?window.location.href=data:window.location.href='View.php';
</script>";
}else{
  $auth = $_REQUEST['auth'];
  $consumerid = $_REQUEST['ID'];
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
?>

<!doctype html>
<html>
<head>
<link rel="stylesheet" href="./css/order.css?v=<?php echo time(); ?>"/>
</head>
<body>
<div class="above">
 

     </div>
<div class="card">
    <section>
  <h2> View orders</h2>
  <select class="pages" >
    <option>Page</option>
   <option>Make an order</option>
     <option>Login</option>
   </select>
   </section>
    <table >
          <thead>
              <tr>
                <th>lineId</th>
                <th>Products</th>
                <th>Dellyman order id</th>
                <th>OrderStatus</th>
                <!-- <th> Date</th> -->
              </tr>
            </thead>
              <tbody>
              </tbody>
      </table>

  </div>
</body>
<script>
let pages = document.querySelector(".pages");
let table = document.querySelector("tbody");
const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());
window.addEventListener('beforeunload', function (e) {
  let currentUrl = document.URL;
localStorage.setItem('currentUrl', JSON.stringify(currentUrl))
   return 'are you sure';
});
 let customerId = params.id;
let customerAuth = params.auth;
let shop = params.shop;
if(customerAuth && customerId){
//debugger
}else{
    //debugger
    var storage = !!localStorage.getItem('Login')
    let nibble ={};

    if(storage == true){
  nibble = JSON.parse(localStorage.getItem('Login'));
  customerid = nibble.CustomerID
  customerAuth = nibble.CustomerAuth
  console.log("this is me ", customerid+""+customerAuth)
    }

}
let output = "";
async function delly(){
    let data = await fetch('./apicode/delly.php');
    let mega = await data.json();
    mega.map(item=>{
        let{line_id, dellymanid, Reference, OrderStatus, product} = item;
        let good = JSON.parse(product);
        //productName, amount
        table.innerHTML += `
              <tr class="border_bottom">
              <td>${line_id}</td>
              <td><p >${good.map(item=>item.productName+' x'+item.amount+'Qty'+'<br/>')}</p></td>
              <td>${Reference}</td>
              <td>${OrderStatus}</td>
              </tr>
        `;
    })
}
delly();

pages.addEventListener("change", function(event){
    let select = event.target.options[event.target.selectedIndex].innerText;
    if(select == 'Make an order'){
      window.location.href='index.php?auth='+customerAuth+'&ID='+customerId+'&shop='+shop;
    }else if(select == 'Login'){
      window.location.href='View.php'
    }

   });
</script>
</html>
<?php
}
?>
