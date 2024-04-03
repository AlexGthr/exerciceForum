<?php 

use Services\Statistique;

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?= $meta_description ?>">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/brands.min.css" integrity="sha512-8RxmFOVaKQe/xtg6lbscU9DU0IRhURWEuiI0tXevv+lXbAHfkpamD4VKFQRto9WgfOJDwOZ74c/s9Yesv3VvIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />        
        
                    <!-- LINK CSS -->
        <link rel="stylesheet" href="<?= PUBLIC_DIR ?>/css/style.css">
        <link rel="stylesheet" href="<?= PUBLIC_DIR ?>/css/<?= $css ?>">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />
        
        <script src="https://kit.fontawesome.com/a34c2ac31d.js" crossorigin="anonymous"></script>
        <title>FORUM</title>
    </head>
    <body>
        <div id="wrapper"> 
            <div id="mainpage">

                <!-- c'est ici que les messages (erreur ou succès) s'affichent-->
                <h3 class="message" style="color: red"><?= App\Session::getFlash("error") ?></h3>
                <h3 class="message" style="color: green"><?= App\Session::getFlash("success") ?></h3>
                <header>
                    <nav>
                        <div class="nav_mobile">

                        <div class="nav_burger">
                            <ul class="nav_liste">

                                 <!-- Si l'utilisateur est connecté, on affiche ce menu -->
                                <?php if(App\Session::getUser()) { ?>

                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="index.php?ctrl=home&action=profile">My profile</a></li>
                                    <li><a href="#contact">Contact</a></li>
                                    <li><a href="index.php?ctrl=security&action=logout">Logout</a></li>
                                    <li>
                                        <div class="darkmode">
                                            <button aria-label="darkLightMode" class="btn-toggle"><i class="fa-regular fa-moon lightAndDarkMode"></i></button>
                                        </div>
                                    </li>

                                
                                 <!-- Si l'utilisateur n'est pas connecté, on affiche ce menu -->
                                <?php } else { ?>

                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="index.php?ctrl=security&action=register">Sign Up</a></li>
                                    <li><a href="index.php?ctrl=security&action=login">Login</a></li>
                                    <li><a href="#contact">Contact</a></li>
                                    <li>
                                        <div class="darkmode">
                                            <button aria-label="darkLightMode" class="btn-toggle"><i class="fa-regular fa-moon lightAndDarkMode"></i></button>
                                        </div>
                                    </li>

                                <?php } ?>

                                 <!-- Si l'utilisateur est un Admin, on ajoute ces pages  -->
                                <?php if(App\Session::isAdmin() || App\Session::isModerator()) { ?>

                                    <li><a href="index.php?ctrl=security&action=listUsers">List Users</a></li>
                                
                                <?php } ?>

                                        <!-- Logo dans la navBar -->
                                <li><img class="nav_logo" src="./public/img/gamepad.svg" title="logo menu"></li>
                            </ul>                        
                            <div id="icons"></div>
                        </div>

                                        <!-- Icone forum + texte Forum -->
                            <div class="nav_title">
                                <a href="index.php">
                                    <img src="./public/img/gamepad.svg" title="gamepad title">
                                    <h1> Forum </h1>
                                </a>
                            </div>


                                    <!-- Si l'utilisateur est connecté, on affiche son avatar, son pseudo et un lien de logout -->
                            <?php if(App\Session::getUser()) { ?>

                                <div class="User_Content">

                                        <!-- Pseudo + lien logout -->
                                    <div class="logout_avatar">

                                        <p> <?= App\Session::getUser() ?> </p>
                                        <p><a href="index.php?ctrl=security&action=logout">Logout</a></p>

                                    </div>

                                            <!-- Avatar de l'utilisateur -->
                                    <div class="avatar_user">

                                        <a href="index.php?ctrl=home&action=profile">
                                            <img class="nav_avatar" src="<?= App\Session::getUser()->getAvatar(); ?>" title="avatar user">
                                        </a>


                                    <!-- Si l'utilisateur n'est pas connecté, on affiche un avatar par default et un texte "Visitor" -->                           
                            <?php } else { ?>

                                <div class="User_Content">
                                    <div class="logout_avatar">
                                        <p> Visitor </p>
                                    </div>
                                    <div class="avatar_user">
                                
                                <a href="index.php?ctrl=security&action=login">
                                    <img class="nav_avatar" src="./public/img/avatar/default.webp" title="avatar visitor">
                                </a>
                                
                            <?php } ?>
                            </div>
                            </div>
                        </div>
                    </nav>

                    <!-- Image en dessous de la nav -->
                    <?php if (!isset($noImg)) {?>
                        <figure class="img_topMobile">
                            <img id="imgTopScreen" src="./public/img/img-top-mobile.webp" title="image top mobile">
                        </figure>
                    <?php } ?>

                </header>
                
                <main id="forum">

                                <!-- Section statistique et barre de recherche -->
                    <?php if (!isset($noFireStat)) {?>
                        <section class="fire_stat">

                            <!-- Barre de recherche -->
                        <div class="searchBar">

                            <form action="#" method="post" enctype="multipart/form-data"> <!-- Formulaire pour envoyer un produit -->

    
                                <input type="search" class="research" name="research" placeholder="Research">
                                <button type="submit" name="submit" class="fa-mobile"><i class="fa-solid fa-magnifying-glass"></i></button>

                            </form>

                        </div>

                          <!-- Statistique -->
                        <div class="boxBestStat">
                            <div class="best_stat">
                                <i class="fa-solid fa-fire"></i>
                                <p>Number of Topics : <?= Statistique::statTopic(); ?> </p>
                            </div>
    
                            <div class="best_stat">
                                <i class="fa-solid fa-fire"></i>
                                <p>Number of messages : <?= Statistique::statPost(); ?> </p>
                            </div>
    
                            <div class="best_stat">
                                <i class="fa-solid fa-fire"></i>
                                <p>Number of members : <?= Statistique::statUser(); ?> </p>
                            </div>
                        </div>

                    </section>
                    <?php } ?>

                        <?= $page ?>


                        <!-- Partie "contact" -->
                    <?php if (!isset($noContact)) {?>
                        <section id="contact" class="contact">

                            <div class="title_popularTopic">
                                <h1> Contact </h1>
                                <hr class="after_titlePink" />    
                            </div>

                            <div class="info_contact">
                                <p> <span class="rose_color"> NEWSLETTER </span> </p>

                            <!-- Barre de recherche -->
                            <div class="searchBar">

                                <form action="#" method="post" enctype="multipart/form-data"> <!-- Formulaire pour envoyer un produit -->


                                    <input type="search" class="researchContact" name="research" placeholder="Research">
                                    <button type="submit" name="submit" class="fa-mobile"><i class="fa-solid fa-magnifying-glass"></i></button>

                                </form>

                            </div>
                                <p> Do You find a bug ? <br>
                                    Do you have a problem on the site? </p>
                                <p> Contact us : </p>
                                <p> <i class="fa-solid fa-envelope-circle-check"></i> <span class="rose_color"> forum@forum.com </span> </p>
                            </div>

                        </section>
                    <?php } ?>

                </main>
            </div>
            <footer>
                <p>&copy; <?= date_create("now")->format("Y") ?> - 
                    <a href="#"><span class="link_yellow">Règlement du forum </span></a> | 
                    <a href="#"><span class="link_yellow">Mentions légales</span></a></p>
            </footer>
        </div>
        <script
            src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
            crossorigin="anonymous">
        </script>
        <script>
            $(document).ready(function(){

                $(document).ready( function () {
                    $('#myTable').DataTable();
                } );

                $(".message").each(function(){
                    if($(this).text().length > 0){
                        $(this).slideDown(500, function(){
                            $(this).delay(3000).slideUp(500)
                        })
                    }
                })
                $(".delete-btn").on("click", function(){
                    return confirm("Etes-vous sûr de vouloir supprimer?")
                })
                tinymce.init({
                    selector: '.post',
                    menubar: false,
                    plugins: [
                        'advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks code fullscreen',
                        'insertdatetime media table paste code help wordcount'
                    ],
                    toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                    content_css: '//www.tiny.cloud/css/codepen.min.css'
                });
            })
        </script>
        <script src="<?= PUBLIC_DIR ?>/js/script.js"></script>
        <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    </body>
</html>