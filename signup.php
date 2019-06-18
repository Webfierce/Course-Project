<?php
require 'header.php';
require 'includes/init.php';
// IF USER MAKING SIGNUP REQUEST
if(isset($_POST['username']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['phone'])
 && isset($_POST['date']) && isset($_POST['gender'])){
   //echo '<h1> yes </h1>';
  $result = $user_obj->singUpUser($_POST['username'],$_POST['firstname'],$_POST['lastname'],$_POST['email'],$_POST['phone'],$_POST['date'],$_POST['gender']);
}else{
   //echo '<h1> no </h1>';
}

// IF USER ALREADY LOGGED IN
if(isset($_SESSION['email'])){
  header('Location: home.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="css/signup.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
</head>
<body>
  <div class="wrapper">
    <div class="header">
      <h2 class="signHeader">Please Register...</h2>
    </div>
    <div class="errorBox">
    <?php
      if(isset($result['errorMessage'])){
        echo '<p class="errorMsg">'.$result['errorMessage'].'</p>';
      }
      if(isset($result['successMessage'])){
        echo '<p class="successMsg">'.$result['successMessage'].'</p>';
      }
    ?>
    </div>
    <form class="signup-form" id="form" method="post" enctype="multipart/form-data" novalidate>
      <div>
        <input id="userName" name="username" type="text" required>
        <label for="uid">Your Username</label>
      </div>
       <div>
         <input id="name" name="firstname" type="text" required>
         <label for="firstname">Your First Name</label>
       </div>
       <div>
         <input id="lastName" name="lastname" type="text" required>
         <label for="lastName">Your last Name</label>
       </div>
       <div>
         <input id="email" name="email" type="email" required>
         <label for="email">Your E-mail</label>
       </div>
       <div>
         <input id="number" name="phone" type="phone" required>
         <label for="phone">Primary Phone</label>
       </div>
       <div>
         <input id="date" name="date" type="date" required>
         <label for="date">Your Date of Birth</label>
       </div>
         <span class="gender">Gender:</span>
         <input type="radio" name="gender" value="m" checked/><span >Male</span>
         <input type="radio" name="gender" value="f"/><span >Female</span>
       <div>
         <input type="file" id="real-file" hidden name="image_file"/>
         <button type="button" id="custom-button">Upload Avatar</button>
         <span id="custom-text">No avatar chosen, yet.</span><br><br>
       </div>
       <button type="submit" value="Sign Up" class="registerBtn">Sign Up</button>
    </form>
   <div>
     <h4 class="signFooter">By clicking the 'Register Now' button, you agree to our <br>
    <a href="#"><font color="#ee2e24">Terms & Conditions</font></a>, and <a href="#"><font color="#ee2e24">Privacy Policy.</font></a></h4>
   </div>
 </div>
  <script src="js/signup.js" charset="utf-8"></script>
</body>
</html>
