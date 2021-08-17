<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style.css?v=<?php echo time(); ?>"/>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <title>dellyman</title>
<!-- <script defer  src="./js/same.js"></script>
  <script src="./js/jquery-3.5.1.js"></script>  -->
<!-- <script defer src="./js/man.js"> </script> -->
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
  <script type="text/javascript">
 let table = document.querySelector('tbody');
let authId = document.querySelector(".show");
let option = document.querySelector('.online');
let inbox = document.querySelector(".inbox");
let aID = authId.getAttribute("data-id");
let on = document.querySelector(".on");
let submit = document.querySelector(".submit");
let within = document.querySelector(".within");
let overlay = document.querySelector(".overlay");
let overlay2 = document.querySelector(".overlay2");
let van = document.querySelector('.boxOne');
let form = document.querySelector(".whole");
let  order = document.querySelector(".order");
let pages = document.querySelector(".pages");

const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());
 let customerId = params.ID;
let customerAuth = params.auth;
let shopLink = params.shop

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

let orders = ["Select Order"];
 let list = ["Select Carrier"];
 let summer = [];
 let pname = [];
   let id   = [];
 let sumbit_array = [];
order.addEventListener('click', function(e){
  window.location.href='order.php?auth='+customerAuth+'&id='+customerId+'&shop='+shopLink;
})
async function delly() {
    try {
       let data = await fetch('./apicode/selectOrder.php'); 
       let all = await data.json();
       let userUrl = all.filter((item)=>item.vendor.toLowerCase() == shopLink.toLowerCase());
       userUrl.map((item)=>{
         orders.push(item.line_id);
       })
      
     let door = [...new Set(orders.map(one=>one))]
       door.map(item=>{
         option.innerHTML +=`<option>${item}</option>`;
       })
       option.addEventListener("change", function(e){
          
            let select = e.target.options[e.target.selectedIndex].innerText;
           
            
          let drama = userUrl.filter((item)=>item.line_id == select)
          localStorage.setItem("filters", JSON.stringify(drama));
         

       let jamb = drama.map((one)=>{
            let{id, firstname, lastname, line_id, product, quantity, amount, product_id} = one 
            if(quantity == 0){
              return `
            <tr>
            <td><p>${product} </p>
            <div class='goat'> 
           <p>empty quantity</p>
            </div>
            </td>
             <td>${product_id}</td>
             <td>${quantity}</td>
           </tr>

         <hr/>`;
            }else if(quantity !== 0){
              return `
            <tr>
            <td><p>${product} </p>
            <div class='goat'>
               <p><button type="button" class="magic">
            <span></span>
            <span class="switch"></span>
           <span></span>
            </button></p>
        <p> <input type="number" id="${product_id}" class="qty"  data-number="${product}"   placeholder="Quantity" />
        <p class="err"></p>
         <button type="button" class="second"  name="${product_id}">Update</button></p>
        </div>
            </td>
             <td>${product_id}</td>
             <td>${quantity}</td>
           </tr>

         <hr/>`;

            }
           

          })
          table.innerHTML = jamb.join(' ');
          let buttons = [...document.querySelectorAll(".magic")]
        let yoyo = [...document.querySelectorAll(".goat")];
        
        
         yoyo.forEach(one=>{
         let watch = one.querySelector(".switch");
         let input = one.querySelector(".qty");
         let err = one.querySelector(".err"); 
         let check = one.querySelector(".second");
         
         input.style.display ="none";
       
          steve(err);
          check.setAttribute('disabled', true);
          check.style.backgroundColor  =`#9d214262`;
          input.style.display ="none";
        watch.addEventListener("click", function(e){
           if (!watch.classList.contains("slide")) {
                 check.removeAttribute('disabled')
                  check.style.backgroundColor  =`#9D2143`; 
                    watch.classList.add("slide")
                    input.style.display="block";
                    if(watch.classList.contains("slide") == true){
                     
                        check.addEventListener("click", e=>{
                         let name =  input.getAttribute("id");
                         var result_array = summer.filter((item) => item == name);
                         if(result_array.length == 0) {
                           summer.push(name);
                           
                         }
                           })
                            
                         
                          
                          //summer.push(input.value);
                         
                         
      
                    }
                } else {
                    watch.classList.remove("slide")
                    input.style.display="none";
                    input.value=" ";
                    err.innerText = " "
                    check.setAttribute('disabled', true);
                   check.style.backgroundColor  =`#9d214262`;
                } 
         })




          let second = one.querySelector('.second');
           second.addEventListener("click", function (e) {
            e.preventDefault();
               let con = document.querySelectorAll('.qty');

                  let come = localStorage.getItem('filters')?JSON.parse(localStorage.getItem('filters')):[];
                let purchasedQuantity = come.map(item => item.quantity)
              
                function func() {
                    var cole = [];
                    for (var i = 0; i <= con.length- 1; i++) {
                        cole.push(con[i].value);
                          
                    }
                

                     
                    if (cole > purchasedQuantity) {
                        on.setAttribute('disabled', true)
                       
                        err.innerText = `quantity(es) ${input.value} is greater than order `
                        err.style.color = `red`;
                         submit.setAttribute('disabled', true);
                        submit.style.backgroundColor  =`#9d214262`;
                    }
                    else if (cole <= purchasedQuantity) {
                        on.removeAttribute('disabled')
                      
                        err.innerText = `${input.value} quantity(es) will be shipped `
                        err.style.color = `green`;
                    }
                }
                func();
               if (input.value == 0) {
                    err.innerText = ` 0 quantity(es)  can't  be shipped `
                    input.style.border = "1px solid red";
                    on.setAttribute('disabled', true)
                    err.style.color = `red`;
                    submit.setAttribute('disabled', true);
                    submit.style.backgroundColor  =`#9d214262`;
                }
                if (input.value < 0) {
                    err.innerText = `negative quantity(es) can't  be shipped `
                    err.style.color = `red`
                    input.style.border = "1px solid red";
                    on.setAttribute('disabled', true)
                }


           })
         
        })

       })

      
    } catch (error) {
      console.log(error)  
    }

   
}

delly();

function steve(err){
     err.innerHTML = " ";
                                          
 }
async function listen(){
try {
    let vehicle = await fetch('./apicode/vehicle.php');
    let nibble = await vehicle.json();
   nibble.forEach(one=>{  
     list.push(one.Name)
   })
   list.forEach((one)=>{
  on.innerHTML +=`<option>${one}</option>`;
})
} catch (error) {
 console.log(error) 
}
}

on.addEventListener("change", function(e){
      console.log(e.currentTarget)
      let select = e.target.options[e.target.selectedIndex].innerText;
     if(select == "Select Carrier"){
        submit.setAttribute('disabled', true);
        submit.style.backgroundColor  =`#9d214262`; 
     }else if(select !== "Select Carrier"){
       submit.removeAttribute('disabled')
        submit.style.backgroundColor  =`#9D2143`; 
     }
     
     })


listen()
submit.addEventListener('click', e=>{
      e.preventDefault()
    overlay.classList.add('hide-overlay')
  let ear = localStorage.getItem("filters")?JSON.parse(localStorage.getItem("filters")):[];
          summer.map(item=>{
            let soon =  document.getElementById(""+item).value
            if(soon){ 
              id.push(item);  
              //one.product_id == item
             let king = ear.filter(one=>{
               if(one.product_id == item){
               
                 pname.push(one.product);
               }
             })
          
               
              
            sumbit_array.push(soon);
            }
        })  
        
       
        })
        let setTimer = localStorage.getItem('Login')?JSON.parse(localStorage.getItem('Login')):[]
        let futureDay = new Date().getDate();
      
             console.log(futureDay)
             
             if(parseInt(setTimer.time) != futureDay){
               setTimeout(()=>{
                localStorage.removeItem("Login");
                window.location.href='View.php?'
               },2000)

             }

within.addEventListener('click', (e) => {
  let team = [...form.querySelectorAll(".qty")]
 
    if (e.target.innerText == "Yes") {
        window.scrollTo(0, 0);
    
        console.log(e.target.innerText)                 
            let formData = new FormData();

            formData.append(`customerId`, customerId);
            formData.append(`customerAuth`, customerAuth);
            formData.append(`word`, sumbit_array);
            formData.append(`product_code`, id);
            formData.append(`carrier`, on.value);
            formData.append(`product_name`, pname)
            formData.append(`line_id`, option.value)
            url = 'send.php';

            fetch(url, {
                method: "POST",
                body: formData
            }).then(Response => {
                return Response.json()
                //   console.log(Response)

            }).then(res => {
                //console.log(res)
               
                      let {ResponseCode, ResponseMessage, Reference} = res;
                       if(ResponseCode == '101' ||  ResponseCode =='400'){
                           show.innerHTML = `${ResponseMessage}`;
                           show.style.color = `red`;
                           show.style.border = "1px solid  red";
                           overlay2.classList.remove('hide-overlay2');
                           summer.splice(0,summer.length)
                           sumbit_array.splice(0,summer.length)
                                          team.forEach(one=>{
                                            one.value = "";
                                          })
                          }else if (ResponseCode == '100'){
                            show.innerHTML = `${ResponseMessage},YOUR ORDERID:${Reference}`;
                            show.style.color = `green`;
                            show.style.border = "1px solid  green";
                            overlay2.classList.remove('hide-overlay2');
                            summer.splice(0,summer.length)
                            sumbit_array.splice(0,summer.length)
                                          team.forEach(one=>{
                                            one.value = "";
                                          })
                          }



                setTimeout(() => {

                    show.innerText = ``;
                    show.style.border = "";
                    show.style.color = ""
                }, 14000);
            })
                .catch(err => {
                   // console.log(err)
                })


       

        overlay.classList.remove('hide-overlay')
        overlay2.classList.add('hide-overlay2')
      //   setTimeout(() => {
      //       overlay2.classList.remove('hide-overlay2')
      //   }, 3000)
    } else if (e.target.innerText == "No") {
        overlay.classList.remove('hide-overlay')
    }

})



pages.addEventListener("change", function(event){
    let select = event.target.options[event.target.selectedIndex].innerText;
    if(select == 'View order'){
      window.location.href='order.php?auth='+customerAuth+'&id='+customerId;
    }else if(select == 'Log-Out'){
      window.location.href='View.php?'
      localStorage.removeItem("Login");
    }
   });
  </script>
</html>
