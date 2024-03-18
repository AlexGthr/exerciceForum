<?php
    use App\Session;

    $user = $result["data"]['user']; 
?>

 <!-- Si l'utilisateur est connectés, alors affiche le profil, sinon direction la page de connexion. -->
<?php if(App\Session::getUser()) { ?>

<!-- Message de session en cas de success/erreur -->
<?php 
$session = new Session();
echo $session->getFlash("message");
?>

<div class="display_profil">

    <h1> <?= $user->getNickName() ?> profile </h1><br>

    <p> Avatar </p>
    <img src="<?= $user->getAvatar() ?>" title="Avatar user">
    <a href="#">Change avatar</a><br>

    <p>Date creation account : <?= $user->getDateRegistration()->format("d/m/Y") ?><br>

    <a href="#"> DELETE MY ACCOUNT </a>


</div>






<?php } else {
        header("Location: index.php"); exit;
} ?>