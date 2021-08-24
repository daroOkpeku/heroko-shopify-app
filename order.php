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
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400&display=swap" rel="stylesheet">
</head>
<body>
<div class="above">
 

     </div>
<div class="card">
    <section>
 <section class="both">
  <h2> View orders</h2>
    <span> search <input type="text" class="search"  placeholder="Dellyman orderId or Date"/><button type="button">filter</button> </span>
   </section>
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
                <th> Date</th>
              </tr>
            </thead>
              <tbody>
              </tbody>
      </table>
<section class="sunny"> 
       <button class="previous" data-btn="previous">previous</button>
        <div class="in"></div>
       <button class="next" data-btn="next">next</button>
      </section>
  </div>
</body>
<script>
let pages = document.querySelector(".pages");
let table = document.querySelector("tbody");
 let sunny = document.querySelector(".sunny");
let filterBtn = document.querySelector(".both button")
const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());
 let customerId = params.id;
let customerAuth = params.auth;
let shop = params.shop;
window.addEventListener('beforeunload', function (e) {
 let currentUrl = document.URL;
localStorage.setItem('currentUrl', JSON.stringify(currentUrl))
});

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
  shop = nibble.shop;
    }

}
let output = "";
async function delly(){
    let data = await fetch('./apicode/delly.php');
    let mega = await data.json();
    let fetchAll = mega.filter(item=>item.store == shop);
       
    filterBtn.addEventListener("click", (e)=>{
 let input = search.value;
  if(input.length > 0){
    let change = fetchAll.filter(one=>one.Reference.toLowerCase() == input.toLowerCase())
 var cool = change.map(item=>{
        let{line_id, dellymanid, Reference, OrderStatus, product} = item;
        let good = JSON.parse(product);
        //productName, amount
           return `<tr class="border_bottom">
              <td>${line_id}</td>
              <td><p >${good.map(item=>item.productName+' x'+item.amount+'Qty'+'<br/>')}</p></td>
              <td>${Reference}</td>
              <td>${OrderStatus}</td>
              </tr> `;  
              
    })
    table.innerHTML = cool.join(' ')
  }
 

})
 
 
 
 
 
setUp(table, fetchAll, all_rows)
instruction(table, fetchAll, current_page, all_rows);  
}
delly();
 

var current_page = 1;
    let all_rows = 4;
    let forBtn = 1;
    function instruction(table, fetchAll, current_page, all_rows){
    
     current_page--;
 
     let start = all_rows * current_page;
     let end = start + all_rows;
     let pagina = fetchAll.slice(start, end);
    
     for(var i =0; i < pagina.length; i++ ){
      var product = JSON.parse(pagina[i]['product']);
          table.innerHTML += `<tr class="border_bottom">
              <td>${pagina[i]['line_id']}</td>
              <td><p >${product.map(item=>item.productName+' x'+item.amount+'Qty'+'<br/>')}</p></td>
               <td>${pagina[i]['Reference']}</td>
               <td>${pagina[i]['OrderStatus']}</td>
               </tr> `;
     }
    
    }


     let foot = document.querySelector(".in");
    function setUp(table, fetchAll, all_rows){
      
      let page = Math.ceil(fetchAll.length / all_rows);
      
      for(var f = 1; f < page + 1; f++){
         foot.innerHTML += `<button type="button" data-id="${f}"class="click">${f}</button>`;
        

       }
       let click = document.querySelector(".in");
    click.addEventListener("click", function(e){
       let num = parseInt(e.target.dataset.id)
           current_page = num
          deleteRows();
           instruction(table, fetchAll, current_page, all_rows)
    })
    function deleteRows(){
     let row = document.querySelector("tbody");
     row.innerHTML = " ";
             
            }
 
    }
 
 
 
 

pages.addEventListener("change", function(event){
    let select = event.target.options[event.target.selectedIndex].innerText;
    if(select == 'Make an order'){
      window.location.href='index.php?auth='+customerAuth+'&ID='+customerId+'&shop='+shop;
      localStorage.removeItem("currentUrl");
    }else if(select == 'Login'){
      window.location.href='View.php'
      localStorage.clear();
    }

   });
</script>
</html>
<?php
}
?>
