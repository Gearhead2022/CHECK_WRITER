<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="views/img/JGC.png" type="image/x-icon">
<title>Login</title>
<style>
body ,html{font-family: Arial, Helvetica, sans-serif;;}
form{
    width:fit-content;
    padding: 60px;
    height: 400px;
    margin:0 auto;
    margin-top: 2%;
    background-color: #f9f9f9
    
}
/* Full-width input fields */
.form-control {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

/* Set a style for all buttons */
button{
  background-color: #4CAF50;
  color: white;
  border: none;
  cursor: pointer;
  width: 100%;
  margin: 5px auto;
  padding: 15px;
      box-shadow: 0px 5px 5px #ccc;
      border-radius: 5px;
      border-top: 1px solid #e9e9e9;
  display:block;
  text-align:center;
}
.signup{
    background-color:blue;
    margin-bottom:20px;
}
.login-box {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      padding: 15px;
      background-color: #fff;
      box-shadow: 0px 5px 5px #ccc;
      border-radius: 5px;
      border-top: 1px solid #e9e9e9;
    }
button:hover,#btn-signup:hover {
  opacity: 0.8;
}



/* Center the image and position the close button */
.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
  position: relative;
}

img.avatar {
  width: 40%;
  border-radius: 50%;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

h2,p{
    text-align:center;
}
#logo1{
    width:250px;
    height: 59px;
    margin-left: 100px;
    margin-top: 15px;
}.card {
    width: 500px;
    height: 569px;
    top: 50px;
    left: 30%;
    right: auto;
}.card-body {
    margin-top: -28px;
    height: 300px;
}



/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  
}

</style>

<script src="views/assets/plugins/sweetalert2/sweetalert2.all.js"></script>
  <script src="views/assets/plugins/clients.js"></script>
  <script src="views/js/users.js"></script>
  <script src="views/js/script.numeric_key_binding.js"></script>
  <script src="views/js/autologout.js"></script> 
  <link href="views/assets/css/bootstrap.min.css" rel="stylesheet"/>

</head>
<body>
<div class="container">
  <div class="card">
      <div class="card-header">
        <img id="logo1" src="views/img/JGC LOGO.png" alt="">
      
      </div>
      <div class="card-body">
        <form method="POST"  autocomplete="nope">
          <div class="nav">
          <label for="email"><b>Username</b></label>
          <input
            type="text"
            class="form-control"
            name = "email"
            id="email"
            placeholder="Enter your username" required>
                
          <label for="name"><b>Password</b></label>
          <input
            type="password"
            class="form-control"
            id="password"
            name = "password"
            placeholder="Enter your password"
                  minlength=""
                  required>
        
            <button type="submit" class="save" name="login">Login</button>
            <!-- <button type="button" onclick="window.location.href='views/modules/registration.php'" class="signup" >Sign Up </button> -->
            </div>
      </div>
  </div>
      </form>
       <?php
          $createAccount = new ControllerAccounts();
          $createAccount -> ctrCheckAccounts();
       ?>
    </div>

</body>
 

<!-- <script type="text/javascript">
  $(".submit").click(function(){
  window.open("Views/template.php","_blank");
})
</script> -->
</html>