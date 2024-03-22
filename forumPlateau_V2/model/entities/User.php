<?php
namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class User extends Entity{

    private $id;
    private $nickName;
    private $avatar;
    private $password;
    private $role;
    private $dateRegistration;
    private $ban;
    private $email;

    public function __construct($data){         
        $this->hydrate($data);        
    }

    /**
     * Get the value of id
     */ 
    public function getId(){
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id){
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of nickName
     */ 
    public function getNickName(){
        return $this->nickName;
    }

    /**
     * Set the value of nickName
     *
     * @return  self
     */ 
    public function setNickName($nickName){
        $this->nickName = $nickName;
        
        return $this;
    }
    
    /**
     * Get the value of avatar
     */ 
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set the value of avatar
     *
     * @return  self
     */ 
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of dateRegistration
     */ 
    public function getDateRegistration()
    {
        return $this->dateRegistration;
    }

    /**
     * Set the value of dateRegistration
     *
     * @return  self
     */ 
    public function setDateRegistration($dateRegistration)
    {
        $this->dateRegistration = new \DateTime($dateRegistration);

        return $this;
    }

    /**
     * Get the value of ban
     */ 
    public function getBan()
    {
        return $this->ban;
    }

    /**
     * Set the value of ban
     *
     * @return  self
     */ 
    public function setBan($ban)
    {
        $this->ban = $ban;

        return $this;
    }

        /**
     * Get the value of ban
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of ban
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function __toString() {
        return $this->nickName;
    }

    // Method pour vérifier le role de l'utilisateur
    public function hasRole($role) {
        if ($this->getRole() === $role) {
            return true;
        } else {
            return false;
        }
    }
}