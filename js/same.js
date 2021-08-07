let table = document.querySelector('tbody');
let authId = document.querySelector(".show");
let option = document.querySelector('.select');
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
let orders = ["Select Order"];
 let list = ["Select Carrier"];


async function delly() {
    try {
       let data = await fetch('./apicode/selectOrder.php'); 
       let all = await data.json();
       all.map((item)=>{
         orders.push(item.line_id)
       })
    console.log(orders)
    
      
    } catch (error) {
      console.log(error)  
    }
    
   
}
  


delly();