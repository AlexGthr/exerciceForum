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

<h1>Login !</h1>

<!-- Formulaire de connexion -->
<form action="index.php?ctrl=security&action=addLogin" method="POST">

    <label for="nickName">Pseudo</label>
    <input type="text" name="nickName" id="nickName" required><br>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required><br>
        
    <input type="submit" name="submit" value="Login">

</form>

<?php } ?>