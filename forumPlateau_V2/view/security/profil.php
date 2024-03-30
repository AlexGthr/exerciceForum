<?php
    use App\Session;

    $user = $result["data"]['user']; 
?>

 <!-- Si l'utilisateur est connectés, alors affiche le profil, sinon direction la page de connexion. -->
<?php if(App\Session::getUser()) { ?>
    <section class="wrapper_profil">
<!-- Message de session en cas de success/erreur -->
<?php 
$session = new Session();
echo $session->getFlash("message");
?>

<div class="title_popularTopic">
        <h1> Topic of <?= $user->getNickName() ?> </h1>
        <hr class="after_titlePink" />
</div>

<div class="display_profil">


    <p> Avatar </p>
    
    <img src="<?= $user->getAvatar() ?>" class="img_showEdit" title="Avatar user">

    <div class="show_boxPostAvatar">

        <p><span class="addActiveAvatar"> Edit avatar </span></p>

        <div class="show_editAvatar">
        <div class="form_editAvatar">
    
            <form action="index.php?ctrl=home&action=editAvatar&id=<?= $user->getId()?>" method="POST" enctype="multipart/form-data">
    
                <label for="file">
                    Edit Avatar <br> (Format : jpg, png, jpeg, webp - 1MO max)
                </label>
                    
                <input type="file" name="file">
    
                <div class="button_addPost">
                    <input class="button__addPost" type="submit" name="submit" value="Submit">
                </div>
            </form>
    
        </div>
        </div>

    </div>

    <div class="show_boxPostPassword">

        <p><span class="addActivePassword"> Edit password </span></p>

    </div>

    <div class="show_editPassword">
        <div class="form_editPassword">
    
            <form action="index.php?ctrl=home&action=editPassword&id=<?= $user->getId()?>" method="POST">
    
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required><br>

                <label for="pass1">New Password</label>
                <input type="password" name="pass1" id="pass1" required><br>

                <label for="pass2">Confirm new Password</label>
                <input type="password" name="pass2" id="pass2" required><br>
    
                <div class="button_addPost">
                    <input class="button__addPost" type="submit" name="submit" value="Validate">
                </div>
            </form>
    
        </div>
        </div>



    <p>Date creation account : <?= $user->getDateRegistration()->format("d/m/Y") ?><br>

    <a href="#"> DELETE MY ACCOUNT </a>


</div>
</section>




<?php } else {
        header("Location: index.php"); exit;
} ?>

<?php 


$noFireStat = true;
$noContact = true;
$css = "profil.css";

?>