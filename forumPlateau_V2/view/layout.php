<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?= $meta_description ?>">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
        <link rel="stylesheet" href="<?= PUBLIC_DIR ?>/css/style.css">
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
                                    <li><a href="index.php?ctrl=security&action=profile">My profile</a></li>
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
                                <?php if(App\Session::isAdmin()) { ?>

                                    <li><a href="index.php?ctrl=security&action=users">List Users</a></li>
                                
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

                            <?php if(App\Session::getUser()) { ?>

                                <img class="nav_avatar" src="<?= App\Session::getUser()->getAvatar(); ?>" title="avatar user">
                            
                            <?php } else { ?>

                                <i class="fa-regular fa-right-to-bracket"></i>

                            <?php } ?>
                        </div>
                    </nav>
                </header>
                
                <main id="forum">
                    <?= $page ?>
                </main>
            </div>
            <footer>
                <p>&copy; <?= date_create("now")->format("Y") ?> - <a href="#">Règlement du forum</a> - <a href="#">Mentions légales</a></p>
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