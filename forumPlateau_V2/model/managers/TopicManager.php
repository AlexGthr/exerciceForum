<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class TopicManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Topic";
    protected $tableName = "topic";

    public function __construct(){
        parent::connect();
    }

    // récupérer tous les topics d'une catégorie spécifique (par son id)
    public function findTopicsByCategory($id) {

        $sql = "SELECT topic.*, COUNT(post.id_post) AS nbPosts
                FROM topic
                LEFT JOIN post ON topic.id_topic = post.topic_id
                WHERE topic.category_id = :id
                GROUP BY id_topic
                ORDER BY DATE_FORMAT(creationDate, '%Y/%m/%d/%H/%i/%s') DESC";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }

    public function findAllByDate(){

        $sql = "SELECT topic.*, COUNT(post.id_post) AS nbPosts
                FROM topic
                LEFT JOIN post ON topic.id_topic = post.topic_id
                GROUP BY id_topic
                ORDER BY DATE_FORMAT(creationDate, '%Y/%m/%d/%H/%i/%s') DESC
                LIMIT 3";

        return $this->getMultipleResults(
            DAO::select($sql), 
            $this->className
        );
    }

    public function findAllByNbPost() {

        $sql = "SELECT topic.*, COUNT(post.id_post) AS nbPosts
                FROM topic
                LEFT JOIN post ON topic.id_topic = post.topic_id
                GROUP BY id_topic
                ORDER BY nbPosts DESC
                LIMIT 3";

        return $this->getMultipleResults(
            DAO::select($sql), 
            $this->className
        );
    }

    public function findOneByNbPost($id) {

        $sql = "SELECT topic.*, COUNT(post.id_post) AS nbPosts
                FROM topic
                LEFT JOIN post ON topic.id_topic = post.topic_id
                WHERE topic.id_topic = :id";

        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return $this->getOneOrNullResult(
            DAO::select($sql, ['id' => $id], false), 
            $this->className
    );
    }


    public function findTopicByNumber() {

        $sql = "SELECT *, COUNT(category_id) AS nbTopic
                FROM topic
                GROUP BY id_topic
                ORDER BY nbPost
                LIMIT 3";
        
        return $this->getMultipleResults(
            DAO::select($sql), 
            $this->className
        );
    }
    
}