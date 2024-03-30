<?php

use App\Session; ?>

 <!-- Si l'utilisateur est déjà connecté, je le redirige sur l'accueil -->
<?php if(App\Session::getUser()) { 
        header("Location: index.php"); exit;

} else { ?>


<section class="register_user">


    <div class="session_info">
        <div class="box_session">
            <!-- Message de session en cas d'erreur ou de success -->
            <?php 
                $session = new Session();

                echo "<span class='value_session'>" . $session->getFlash("message") . "</span>";
            ?>
 

        </div>
    </div>

    <div class="register_card">
        <div class="card_register">

            <h1>Sign Up !</h1>


                    <!-- Formulaire d'inscription -->
            <form action="index.php?ctrl=security&action=addRegister" method="POST" enctype="multipart/form-data">

                <div class="register_input">
                    <input type="text" name="nickName" id="nickName" required><br>
                    <label for="nickName">Pseudo</label>
                    <i class="fa-solid fa-user"></i>
                </div>

                <div class="register_input">
                    <input type="email" name="email" id="email" required><br>
                    <label for="email">E-mail</label>
                    <i class="fa-solid fa-envelope"></i>
                </div>

                <div class="register_input">
                    <input type="password" name="pass1" id="pass1" required><br>
                    <label for="pass1">Password</label>
                    <i class="fa-solid fa-lock"></i>
                </div>

                <div class="register_input">
                    <input type="password" name="pass2" id="pass2" required><br>
                    <label for="pass2">Confirm Password</label>
                    <i class="fa-solid fa-lock"></i>
                </div>


                <div class="register_submit">
                    <input class="register_buttonSubmit" type="submit" name="submit" value="Sign Up !">
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

<div class="have_account">
    <p> Already have an account ? <br>
        <a href="index.php?ctrl=security&action=login">
            <span class="rose_color">Log in ! </span>
        </a>
    </p>
</div>

</section>

<?php 

$noImg = true;
$noFireStat = true;
$noContact = true;
$css = "register.css";

?>