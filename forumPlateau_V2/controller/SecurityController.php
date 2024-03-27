<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use App\Session;
use Model\Managers\UserManager;
use Model\Managers\TopicManager;

class SecurityController extends AbstractController{
    // contiendra les méthodes liées à l'authentification : register, login et logout

    // Affiche la vue du formulaire de registration
    public function register () {

        return [
            "view" => VIEW_DIR."security/register.php",
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
            $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);

            $regexUser = preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])$/', $nickName) ? true : false;
            
            $cheminfile = "./public/img/avatar/default.webp";

            // Je teste le regex pour m'assurer un pseudo correct de l'utilisateur
            if ($regexUser) {

                Session::addFlash("message", "This Nickname is not correct.");
                $this->redirectTo("security", "register");

            } elseif ($nickName && strlen($nickName) < 13 && !$regexUser && $pass1 && $pass2 && $email) {

                // Une fois le filtre vérifié, je check dans la BDD si un utilisateur possède déjà ce pseudo
                $verifyNickName = $userManager->findByNickName($nickName) ? $userManager->findByNickName($nickName) : false;

                $verifyEmail = $userManager->findByEmail($email) ? $userManager->findByEmail($email) : false;
                // Si c'est déjà pris, j'affiche une erreur et je renvoi sur la page Register
                if ($verifyNickName) {

                    Session::addFlash("message", "This Nickname already exists.");
                    $this->redirectTo("security", "register");
                    exit;

                    // Sinon, on passe à la suite
                } elseif ($verifyEmail) {

                    Session::addFlash("message", "This E-mail already exists.");
                    $this->redirectTo("security", "register");
                    exit;

                } else {
                        // Je teste des conditions pour le mot de passe : Si il correspond au pass2 et inversement, ainsi qu'un REGEX qui demande une majuscule/minuscule/chiffre/caractère special avec un minimum de 8 (12 prévu par la CNIL)
                    if ($pass1 === $pass2 && preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{3,}$/', $pass1)) {

                        // Je crée un tableau associatif avec les éléments que je souhaite enrengistrer 
                        $information = [
                            "nickName" => $nickName,
                            "avatar" => $cheminfile,
                            "password" => password_hash($pass1, PASSWORD_DEFAULT),
                            "role" => "user",
                            "ban" => 0,
                            "email" => $email
                        ];

                        // Puis je l'ajoute dans la BDD
                        $userManager->add($information);

                        // Je crée ensuite un message personnalisé en Session, pour confirmer l'inscription et je redirige vers le login
                        Session::addFlash("message", "Success !");
                        $this->redirectTo("security", "login");
                        exit;

                    // Si les mots de passes sont différent, message d'erreur
                    } elseif ($pass1 !== $pass2) {

                        Session::addFlash("message", "Your password is different !");
                        $this->redirectTo("security", "register");

                    // Si les mots de passes ne sont pas conforme au regex, message d'erreur
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


    // On affiche la vue du formulaire de Login
    public function login () {

        return [
            "view" => VIEW_DIR."security/login.php",
            "meta_description" => "Login form"
        ]; 

    }

    // Method pour la connexion d'un utilisateur
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


                // Si je trouve un utilisateur avec ce nickName je passe à la suite
                if ($user && !$user->getBan()) {

                    // Je récupère le hash du MDP
                    $checkPassword = $user->getPassword();
                    
                    // Je compare le hash du mdp au mdp donner par l'utilisateur grace à la function password_verify
                    if (password_verify($password, $checkPassword)) {

                        // Si c'est tout bon, alors j'ajoute l'utilisateur en session et je redirige vers l'accueil.
                        Session::setUser($user);

                        $this->redirectTo("index", "home");
                    }

                    // Si le password_verify n'est pas correct, message d'erreur.
                    Session::addFlash("message", "Password is not correct.");
                    $this->redirectTo("security", "login");

                } else if (!$user) {

                // Si le pseudo n'existe pas, message d'erreur.
                Session::addFlash("message", "This pseudo doesn't exist.");
                $this->redirectTo("security", "login");

                } else if ($user->getBan()) {

                // Si le pseudo n'existe pas, message d'erreur.
                Session::addFlash("message", "You are banned from this website.");
                $this->redirectTo("security", "login");
                }
            }

            Session::addFlash("message", "Problem with something. Try again.");
            $this->redirectTo("security", "login");

        }

        $this->redirectTo("security", "login");

    }

    // Method pour la deconnexion d'un utilisateur
    public function logout () {

        // Je retire les informations user de la session.
        unset($_SESSION["user"]);

        $this->redirectTo("index", "home");
    }


    public function listUsers() {

        if (!Session::isAdmin() && !Session::isModerator()) {

            $this->redirectTo("home", "index");

        } else { 

        $userManager = new UserManager();

        $users = $userManager->findAll();

        return [
            "title" => "Forum - list users",
            "view" => VIEW_DIR."security/listUsers.php",
            "meta_description" => "Update Post",
            "data" => [
                "users" => $users
                ]
            ];

    }
    }

    public function editUserAdmin($id) {

        if($_POST["submit"]) {

            if (!Session::isAdmin() && !Session::isModerator()) {

                $this->redirectTo("home", "index");

            } elseif ($id == 1) { 

                $this->redirectTo("home", "index");

            } else {

                $role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $ban = filter_input(INPUT_POST, "banned", FILTER_VALIDATE_INT);

                $userManager = new UserManager();

                $user = $userManager->findOneById($id);

                if ($role == null) {

                    $information = [
                        "ban" => $ban
                    ];

                } else {

                    $information = [
                        "role" => $role,
                        "ban" => $ban
                    ];
                }

                if ($user) {

                    $userManager->update($information, $id);

                    if ($userManager) {

                        Session::addFlash("message", "Success");
                        $this->redirectTo("security", "listUsers");

                    } else {
                        Session::addFlash("message", "Error on update");
                        $this->redirectTo("security", "listUsers");
                    }
                } else {

                    Session::addFlash("message", "User not found");
                    $this->redirectTo("security", "listUsers");

                }
            } 
        } else {

            $this->redirectTo("home", "index");

        }       
    }
}