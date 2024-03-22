<?php

use App\Session; ?>

 <!-- Si l'utilisateur est déjà connecté, je le redirige sur l'accueil -->
<?php if(App\Session::getUser()) { 
        header("Location: index.php"); exit;

} else { ?>

<!-- Message de session en cas d'erreur ou de success -->
<?php 
$session = new Session();
echo $session->getFlash("message");
 ?>

<h1>Sign Up !</h1>


<!-- Formulaire d'inscription -->
<form action="index.php?ctrl=security&action=addRegister" method="POST" enctype="multipart/form-data">

    <label for="nickName">Pseudo</label>
    <input type="text" name="nickName" id="nickName" required><br>

    <label for="pass1">Password</label>
    <input type="password" name="pass1" id="pass1" required><br>

    <label for="pass2">Confirm Password</label>
    <input type="password" name="pass2" id="pass2" required><br>

    <label for="file"> Avatar (Format : jpg, png, jpeg, webp - 1MO max): *</label>
        <input type="file" name="file"><br>
        
    <input type="submit" name="submit" value="Sign Up !">

</form>
<p> * : Not required </p>

<?php } ?>


<?php 

$noImg = true;

?>