<?php 

namespace Services;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\UserManager;

abstract class Statistique {

    public static function statTopic() {
        $topicManager = new TopicManager();
        $nbTopic = $topicManager->count();

        // var_dump($nbTopic); die;
        return $nbTopic;

    }


public static function statPost() {
    $postManager = new PostManager();
    $nbPost = $postManager->count();

    // var_dump($nbTopic); die;
    return $nbPost;

}


public static function statUser() {
    $userManager = new UserManager();
    $nbUser = $userManager->count();

    // var_dump($nbTopic); die;
    return $nbUser;

}

public function nbTopicCategory($id) {

    $categoryManager = new CategoryManager();
    $nbTopic = $categoryManager->nbTopicByCategory($id);

    return $nbTopic;

    
}

}

?>