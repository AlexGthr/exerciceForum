<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?= $meta_description ?>">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/brands.min.css" integrity="sha512-8RxmFOVaKQe/xtg6lbscU9DU0IRhURWEuiI0tXevv+lXbAHfkpamD4VKFQRto9WgfOJDwOZ74c/s9Yesv3VvIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />        
        <link rel="stylesheet" href="<?= PUBLIC_DIR ?>/css/style.css">
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
                                    <li><a href="#">Contact</a></li>
                                    <li><a href="index.php?ctrl=security&action=logout">Logout</a></li>
                                
                                 <!-- Si l'utilisateur n'est pas connecté, on affiche ce menu -->
                                <?php } else { ?>

                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="index.php?ctrl=security&action=register">Sign Up</a></li>
                                    <li><a href="index.php?ctrl=security&action=login">Login</a></li>
                                    <li><a href="#">Contact</a></li>

                                <?php } ?>

                                 <!-- Si l'utilisateur est un Admin, on ajoute ces pages  -->
                                <?php if(App\Session::isAdmin() || App\Session::isModerator()) { ?>

                                    <li><a href="index.php?ctrl=security&action=listUsers">List Users</a></li>
                                
                                <?php } ?>

                                <li><img class="nav_logo" src="./public/img/gamepad.svg" title="logo menu"></li>
                            </ul>                        
                            <div id="icons"></div>
                        </div>

                            <div class="nav_title">
                                <a href="index.php">
                                    <img src="./public/img/gamepad.svg" title="gamepad title">
                                    <h1> Forum </h1>
                                </a>
                            </div>

                            <div class="avatar_user">

                                    <!-- Si l'utilisateur est connecté, on affiche son avatar -->
                            <?php if(App\Session::getUser()) { ?>

                                <a href="index.php?ctrl=home&action=profile">
                                    <img class="nav_avatar" src="<?= App\Session::getUser()->getAvatar(); ?>" title="avatar user">
                                </a>

                                    <!-- Si l'utilisateur n'est pas connecté, on affiche un avatar par default -->                           
                            <?php } else { ?>
                                
                                <a href="index.php?ctrl=security&action=login">
                                    <img class="nav_avatar" src="./public/img/avatar/default.webp" title="avatar visitor">
                                </a>
                                
                            <?php } ?>
                            </div>
                        </div>
                    </nav>

                    <!-- Image en dessous de la nav -->
                    <?php if (!isset($noImg)) {?>
                        <figure class="img_topMobile">
                            <img src="./public/img/img-top-mobile.webp" title="image top mobile">
                        </figure>
                    <?php } ?>

                </header>
                
                <main id="forum">

                                    <!-- Image en dessous de la nav -->
                    <?php if (!isset($noFireStat)) {?>
                        <section class="fire_stat">

                            <!-- Barre de recherche -->
                        <div class="searchBar">

                            <form action="#" method="post" enctype="multipart/form-data"> <!-- Formulaire pour envoyer un produit -->

    
                                <input type="search" class="research" name="research" placeholder="Research">
                                <button type="submit" name="submit" class="fa-mobile"><i class="fa-solid fa-magnifying-glass"></i></button>

                            </form>

                        </div>


                        <div class="best_stat">
                            <i class="fa-solid fa-fire"></i>
                            <p>Number of Topics : 555</p>
                        </div>

                        <div class="best_stat">
                            <i class="fa-solid fa-fire"></i>
                            <p>Number of messages : 555 </p>
                        </div>

                        <div class="best_stat">
                            <i class="fa-solid fa-fire"></i>
                            <p>Number of members : 643 </p>
                        </div>

                    </section>
                    <?php } ?>

                        <?= $page ?>

                    <?php if (!isset($noContact)) {?>
                        <section class="contact">

                            <div class="title_popularTopic">
                                <h1> Contact </h1>
                                <hr class="after_titlePink" />    
                            </div>

                            <div class="info_contact">
                                <p> <span class="rose_color"> NEWSLETTER </span> </p>

                            <!-- Barre de recherche -->
                            <div class="searchBar">

                                <form action="#" method="post" enctype="multipart/form-data"> <!-- Formulaire pour envoyer un produit -->


                                    <input type="search" class="research" name="research" placeholder="Research">
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
    </body>
</html>