<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\UserManager;

class ForumController extends AbstractController implements ControllerInterface{

    public function index() {
        
        // créer une nouvelle instance de CategoryManager
        $categoryManager = new CategoryManager();
        // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
        $categories = $categoryManager->findAll(["name", "DESC"]);

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [
            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [
                "categories" => $categories
            ]
        ];
    }

    public function listTopicsByCategory($id) {

        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        $topics = $topicManager->findTopicsByCategory($id);

        return [
            "view" => VIEW_DIR."forum/listTopics.php",
            "meta_description" => "Liste des topics par catégorie : ".$category,
            "data" => [
                "category" => $category,
                "topics" => $topics
            ]
        ];
    }

    public function findPostsByTopic($id) {

        $topicManager = new TopicManager();
        $userManager = new UserManager();
        $postManager = new PostManager();

        $topics = $topicManager->findOneById($id);
        $users = $userManager->findOneById($id);
        $posts = $postManager->findPostsByTopic($id);

        return [
            "view" => VIEW_DIR."forum/postsTopic.php",
            "meta_description" => "Posts du topic",
            "data" => [
                "posts" => $posts,
                "topics" => $topics,
                "users" => $users
            ]
        ];
    }

    public function newTopic() {

        $categoryManager = new CategoryManager();

        $category = $categoryManager->findAll();

        return [
            "title" => "Forum - New topic",
            "view" => VIEW_DIR."forum/formTopic.php",
            "meta_description" => "Add new topic !",
            "data" => [
                "category" => $category
            ]
        ];
    }

    public function addTopic($id) {

        $idUser = Session::getUser()->getId();

        if($id == $idUser) {

            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $post = filter_input(INPUT_POST, "post", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $category = filter_input(INPUT_POST, "category", FILTER_VALIDATE_INT);

            if (empty($title)) {

                Session::addFlash("message", "You cannot have an empty title...");
                $this->redirectTo("forum", "newTopic");
                
            } elseif (empty($post)) {

                Session::addFlash("message", "You cannot have an empty post...");
                $this->redirectTo("forum", "newTopic");

            } elseif (empty($category)) {

                Session::addFlash("message", "You cannot have an empty category...");
                $this->redirectTo("forum", "newTopic");

            } else {

                $categories = new CategoryManager();
                $categorie = $categories->findOneById($category); 

                if ($categorie != false) {

                    $newTopic = new TopicManager();
                    $newPost = new PostManager();

                    $informationTopic = [
                        "title" => $title,
                        "closed" => 0,
                        "user_id" => $id,
                        "category_id" => $category
                    ];

                    $idNewTopic = $newTopic->add($informationTopic);

                    $informationPost = [
                        "post" => $post,
                        "topic_id" => $idNewTopic,
                        "user_id" => $idUser
                    ];

                    $newPost->add($informationPost);

                    Session::addFlash("message", "Success");
                    $this->redirectTo("forum", "findPostsByTopic", $idNewTopic);

                } else {

                    Session::addFlash("message", "You trying something wrong...");
                    $this->redirectTo("forum", "newTopic");

                }
                
            }

        } else {

            Session::addFlash("message", "You trying something wrong...");
            $this->redirectTo("forum", "newTopic");

        }
    }
}