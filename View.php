<!Doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style2.css?v=<?php echo time(); ?>"/>
    <title>Dellyman</title>
  </head>
  <body>
  <nav>
  <h2>Dellyman</h2>
  </nav>
<section class="ayo">
<aside id="err"></aside>
<div class="details">
<form method="POST" class="all">
  <div class="each">
    <label>
      <span>e-mail</span>
    </label>
    <input type="text" id="email" class="text" name="email" id="email" placeholder="delly@gmail.com" required/> 
  </div>

  <div class="each">
    <label>
    <span>Shopify store url</span>
    </label>
    <input type="text" class="text" name="store" id="store"  placeholder="example.myshopify.com" required/>
  </div>



<div class="each">
    <label>
    <span>  password</span>
    </label>
    <input type="password" class="text" name="password" id="password"  placeholder="******" required/>
  </div>

  <div class="zack">
    <button type="submit" id="btn" name="btn" data-id="delly">Login</button>
  </div>
</form>
</div>
 </section>
  </body>
<script type="text/javascript" >
let password = document.getElementById("password")
let email = document.getElementById("email")
let store = document.getElementById("store")
let all = document.getElementById('btn');
let error = document.getElementById("err")
all.addEventListener("click", function(e){
  e.preventDefault();
  
let formData = new FormData();
            formData.append('store', store.value)
            formData.append('password', password.value)
            formData.append('email', email.value)
            
            url = 'Login.php';

            fetch(url, {
                method: "POST",
                body: formData
            }).then(Response => {
                return Response.json()
                //   console.log(Response)

            }).then(res => {
              
               if(res.ans){
                  error.innerHTML = `${res.ans}`;
                  error.style.color =`red`
                  error.style.padding = `1 rem`
                  error.style.border =`1px solid red`
                 }
                let oneDay = new Date().getDate();
                let some =  {...res, time:`${oneDay}`};
                
                let {ResponseCode, ResponseMessage, Reference, shop} = res;
                       if(ResponseCode == '101' ||  ResponseCode =='400'){
                             error.innerHTML = `${ResponseMessage}`;
                             error.style.color =`red`
                             error.style.padding = `1 rem`
                              error.style.border =`1px solid red`
                          }else if (ResponseCode == '100'){
                            localStorage.setItem('Login',JSON.stringify(some))
                            window.location.href='index.php?auth='+res.CustomerAuth+'&ID='+res.CustomerID+'&shop='+res.shop;
                          }
          
                   
            })
                .catch(err => {
                   // console.log(err)
                })
              })
</script>
</html>
