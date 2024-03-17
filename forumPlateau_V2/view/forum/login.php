<?php

use App\Session; ?>

<?php if(App\Session::getUser()) { 
        header("Location: index.php"); exit;

} else { ?>

<?php 
$session = new Session();
echo $session->getFlash("message");
 ?>

<h1>Login !</h1>

<form action="index.php?ctrl=security&action=addLogin" method="POST">

    <label for="nickName">Pseudo</label>
    <input type="text" name="nickName" id="nickName" required><br>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required><br>
        
    <input type="submit" name="submit" value="Login">

</form>

<?php } ?>