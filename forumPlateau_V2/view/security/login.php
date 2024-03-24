<?php

use App\Session; ?>

 <!-- Si l'utilisateur est déjà connecté, je le redirige sur l'accueil -->
<?php if(App\Session::getUser()) { 
        header("Location: index.php"); exit;

} else { ?>

<section class="login_User">


<div class="session_info">
    <div class="box_session">
<!-- Message de session en cas d'erreur ou de success -->
<?php 
$session = new Session();

echo "<span class='value_session'>" . $session->getFlash("message") . "</span>";
 ?>
 </div>
 </div>

<div class="box_Card">
    <div class="card_Login">
<h1>LOGIN</h1>

<!-- Formulaire de connexion -->
<form action="index.php?ctrl=security&action=addLogin" method="POST">

<div class="input-group">
    <input type="text" name="nickName" id="nickName" required><br>
    <label for="nickName">Username </label>
    <i class="fa-solid fa-user"></i>
    
</div>
<div class="input-group">
    <input type="password" name="password" id="password" required><br>
    <label for="password">Password</label>
    <i class="fa-solid fa-lock"></i>
</div>  
<div class="button_submit">
    <p> <span class="forgot_password">Forgot password ?</span> </p>
    <input class="button__submit" type="submit" name="submit" value="LOG IN">
</div>
</form>

<div class="social_media">
    <a href="#"> <i class="fa-brands fa-square-x-twitter"></i> </a>
    <a href="#"> <i class="fa-brands fa-facebook"></i> </a>
    <a href="#"> <i class="fa-brands fa-linkedin"></i> </a>
</div>

<?php } ?>

</div>
</div>

<div class="no_account">
    <p> Don't have an account ? <br>
        <a href="index.php?ctrl=security&action=register">
            <span class="rose_color">Register ! </span>
        </a>
    </p>
</div>

</section>

<?php 

$noImg = true;
$noFireStat = true;
$noContact = true;

?>