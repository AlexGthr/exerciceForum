<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class PostManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Post";
    protected $tableName = "post";

    public function __construct(){
        parent::connect();
    }

    // Public function pour retrouver un post par son id
    public function findPostsByTopic($id) {

        $sql = "SELECT * 
                FROM ".$this->tableName." t 
                WHERE t.topic_id = :id";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
    }

    public function findFirstPost($id) {

        $sql = "SELECT *
                FROM ". $this->tableName." t
                WHERE t.topic_id = :id
                ORDER BY DATE_FORMAT(dateCreation, '%Y/%m/%d/%H/%i/%s')
                LIMIT 1";
        
        return $this->getOneOrNullResult(
                DAO::select($sql, ['id' => $id], false), 
                $this->className
        );
    }
}