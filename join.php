<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.css?v=<?php echo time(); ?>"/>
  <link rel="preconnect" href="https://fonts.gstatic.com">
    <title>dellyman</title>
<!-- <script defer  src="./js/same.js"></script>
  <script src="./js/jquery-3.5.1.js"></script>  -->
  <script defer src="./js/man.js"> </script>
  </head>
  <body>
 <section class="overlay"> 
    <div class="within">
     <h2>Are you sure you want to ship these items</h2>
     <aside>
       <button>Yes</button> <button>No</button>
     </aside>
    </div>
  </section>
   <section class="overlay2"> 
     <div class="snow">
       <div class="loader"></div>
        <h2>Please wait.</h2>
     </div>
  </section>
  
  <section class="main">
    <div class="above">
  <select class="pages">
    <option>Page</option>
     <option>View order</option>
     <option>Log-Out</option>
   </select>
    <span><h3 class="top">Send  Pickup Request to Dellyman </h3></span>
   <button type="button"  class="order"> <i class="fa fa-hourglass" aria-hidden="true"></i> view orders</button>
     </div>
     <div class="show" id="show"  ></div>
  <form class="whole"  method="POST">
  <div class='box'>
 <h4> Step 1: Select order </h4>
 <p>Only orders with the payment status of PAID and fulfulment status of AWAITING PROCESSING or PROCESSING will be listed below</p>
 <aside>
 <select class="online">
 </select>
 </aside>
  </div>

   <div class='boxOne'>
 <h4> Step 2: Pick products from the order to ship </h4>
 <p class="xo">Select an order above,  enable you pick products to ship</p>
  <section class="cool">
     <div class="inbox"> 
       <table style="width:100%;">
       <thead>
           <tr>
         
           <th>PRODUCT NAME</th>
           <th>PRODUCT CODE</th>
           <th>Quantity</th>
           </tr>
           </thead>
           <tbody>
           </tbody>
           </table>
  </section>
  </div>


     <div class='boxTwo'>
 <h4> Step:3 Select a carrier </h4>
  <section class="cool">
     <div class="inbox"> 
    <select class="on" id="on" disabled>
            
         
    </select>
 
  </section>
  <button type="submit" class="submit" disabled>Submit</button>
  </div>
  </form>
 
</section>

  </body>
</html>