<?php 
include("./apicode/Login.php");
?>
<!Doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/style2.css?v=<?php echo time(); ?>"/>
    <title>dellyman</title>
  </head>
  <body>
  <nav>
  <h2>dellyman</h2>
  </nav>
<section class="ayo">
<aside id="err"></aside>
<div class="details">
<form method="POST">
  <div class="each">
    <label>
      <span>e-mail</span>
    </label>
    <input type="text" id="email" class="text" name="email" id="email" placeholder="delly@gmail.com" required/> 
  </div>

<div class="each">
    <label>
    <span>  password</span>
    </label>
    <input type="password" id="password" class="text" name="password" id="password"  placeholder="******" required/>
  </div>

  <div class="zack">
    <button type="submit" id="btn" name="btn" data-id="delly">Login</button>
  </div>
</form>
</div>
 </section>
  </body>
    
</html>