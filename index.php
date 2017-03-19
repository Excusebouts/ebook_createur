<?php
  require_once('services/services.php');

  //verificationConnexion();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>E-book créateur connection</title> 
  <link rel="stylesheet" href="/assets/css/PopUpStyle.css">  
</head>
<body>
  <div class="login-page">
    <div class="form">
    
  	<!-- Eventuelle évolution : création de compte -->
  	
      <!--<form class="register-form">
        <input type="text" placeholder="name"/>
        <input type="password" placeholder="password"/>
        <input type="text" placeholder="email address"/>
        <button>create</button>
        <p class="message">Already registered? <a href="#">Sign In</a></p>
      </form>-->
  	
      <form method="post" class="login-form" action="/services/services.php">
        <input type="hidden" name="connexion" value="connexion">
        <input name="pseudo" type="text" placeholder="identifiant"/>
        <input name="mot_de_passe" type="password" placeholder="password"/>
        <button type="submit">Connection</button>
        <!--<p class="message">Not registered? <a href="#">Create an account</a></p>-->
      </form>
    </div>
  </div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="/assets/js/index.js"></script>
</body>
</html>
