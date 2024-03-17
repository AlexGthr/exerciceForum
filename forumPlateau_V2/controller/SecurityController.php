<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use App\Session;
use Model\Managers\UserManager;

class SecurityController extends AbstractController{
    // contiendra les méthodes liées à l'authentification : register, login et logout

    public function register () {

        return [
            "view" => VIEW_DIR."forum/register.php",
            "meta_description" => "Register form"
        ]; 

    }

    public function addRegister () { // Function pour ajouter une utilisateur qui viens de s'incrire

        // Si je reçois des éléments via un formulaire en POST :
        if (isset($_POST["submit"])) { 

            // Je crée un nouvel objet UserManager qui servira plus bas
            $userManager = new UserManager();

            // Je filtre mes éléments
            $nickName = filter_input(INPUT_POST, "nickName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $nickName = ucfirst($nickName);
            $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $regexUser = preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])$/', $nickName) ? true : false;

            // Je gère le cas ou l'utilisateur à envoyé un avatar :
            if(isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                // Je récupère l'image reçu
                $tmpName = $_FILES['file']['tmp_name'];
                $nameImg = $_FILES['file']['name'];
                $size = $_FILES['file']['size'];
                $erreur = $_FILES['file']['error'];

                // Je sépare le nom de l'extension
                $tabExtension = explode('.', $nameImg);
                // Je met l'extension en minuscule
                $extension = strtolower(end($tabExtension));
                // Je crée un tableau pour accepter UNIQUEMENT ce genre d'extension
                $extensions = ['jpg', 'png', 'jpeg', 'webp'];
                // Et je crée une condition pour la taille MAX d'une image (1 MO ici)
                $maxSize = 1000000;
        
                $uniqueName = uniqid('', true);

                if ($size >= $maxSize) { // Si la taille de l'image n'est pas correct
                                
                    Session::addFlash("message", "Problem with size image.(size max : 1mo)");
                    $this->redirectTo("security", "register");

                } elseif ($erreur > 0) { // Si l'image à une erreur

                    Session::addFlash("message", "Erreur upload file.");
                    $this->redirectTo("security", "register");

                } else {

                    //uniqid génère quelque chose comme ca : 5f586bf96dcd38.73540086
                    $file = $uniqueName.".".$extension;
                    move_uploaded_file($tmpName, './public/img/avatar/'.$file);

                    // Je récupère mon image dans le dossier
                    $image = imagecreatefromstring(file_get_contents('./public/img/avatar/' . $file));
                    // Je prépare ma nouvelle image
                    $webpPath = "./public/img/avatar/" . $uniqueName . ".webp";
                    // Je convertie en webP
                    imagewebp($image, $webpPath);
                    // Et je supprime mon ancienne image
                    unlink('./public/img/avatar/'.$file);

                    // Je définie le chemin pour le BDD
                    $cheminfile = $webpPath;
                }
            } else { // Si pas d'avatar, alors avatar par defaut.
                $cheminfile = "./public/img/avatar/default.webp";
            }

            // Je teste le regex pour m'assurer un pseudo correct de l'utilisateur
            if ($regexUser) {

                Session::addFlash("message", "This Nickname is not correct.");
                $this->redirectTo("security", "register");

            } elseif ($nickName && strlen($nickName) < 13 && !$regexUser && $pass1 && $pass2) {

                // Une fois le filtre vérifié, je check dans la BDD si un utilisateur possède déjà ce pseudo
                $verifyNickName = $userManager->findByNickName($nickName) ? $userManager->findByNickName($nickName) : false;

                // Si c'est déjà pris, j'affiche une erreur et je renvoi sur la page Register
                if ($verifyNickName) {

                    Session::addFlash("message", "This Nickname already exists.");
                    $this->redirectTo("security", "register");
                    exit;

                    // Sinon, on passe à la suite
                } else {
                        // Je teste des conditions pour le mot de passe : Si il correspond au pass2 et inversement, ainsi qu'un REGEX qui demande une majuscule/minuscule/chiffre/caractère special avec un minimum de 8 (12 prévu par la CNIL)
                    if ($pass1 === $pass2 && preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{3,}$/', $pass1)) {

                        // Je crée un tableau associatif avec les éléments que je souhaite enrengistrer 
                        $information = [
                            "nickName" => $nickName,
                            "avatar" => $cheminfile,
                            "password" => password_hash($pass1, PASSWORD_DEFAULT),
                            "role" => "user",
                            "ban" => 0
                        ];

                        // Puis je l'ajoute dans la BDD
                        $userManager->add($information);

                        // Je crée ensuite un message personnalisé en Session, pour confirmer l'inscription et je redirige vers le login
                        Session::addFlash("message", "Sign Up success !");
                        $this->redirectTo("security", "login");
                        exit;
                    } elseif ($pass1 !== $pass2) {

                        Session::addFlash("message", "Your password is different !");
                        $this->redirectTo("security", "register");

                    } elseif (!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $pass1)) {
                        Session::addFlash("message", "Your password is not correct !");
                        $this->redirectTo("security", "register");
                    }
                }

            } else {
                $this->redirectTo("security", "register");
            }
            
        } else {
            $this->redirectTo("security", "register");
        }
    }


    public function login () {

        return [
            "view" => VIEW_DIR."forum/login.php",
            "meta_description" => "Login form"
        ]; 

    }

    public function addLogin () {

        if($_POST["submit"]) { 

            // Je crée un nouvel objet UserManager qui servira plus bas
            $userManager = new UserManager;

            // Filtrage de la saisie du formulaire (faille XSS)
            $nickName = filter_input(INPUT_POST, "nickName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            
            if ($nickName && $password) { 
                // Une fois le filtre vérifié, je check dans la BDD si un utilisateur avec ce pseudo existe
                $user = $userManager->findByNickName($nickName);

                if ($user) {

                    $checkPassword = $user->getPassword();
                    
                    if (password_verify($password, $checkPassword)) {
                        Session::setUser($user);

                        $this->redirectTo("index", "home");
                    }

                    Session::addFlash("message", "Password is not correct.");
                    $this->redirectTo("security", "login");

                }

                Session::addFlash("message", "This pseudo doesn't exist.");
                $this->redirectTo("security", "login");

            }

            Session::addFlash("message", "Problem with something. Try again.");
            $this->redirectTo("security", "login");

        }

        $this->redirectTo("security", "login");

    }

    public function logout () {

        unset($_SESSION["user"]);

        $this->redirectTo("index", "home");
    }
}