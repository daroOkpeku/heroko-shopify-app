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
 let customerId = params.id;
let customerAuth = params.auth;
let shop = params.shop;
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
