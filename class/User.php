<?php

class User implements Action, JsonSerializable {

    private $id;
    private $name;
    private $surname;
    private $credits;
    private $address_id;
    
    private static $db;
    
    public function __construct($name = '', $surname= '', $credits = 0, $address_id = 0) {
        $this->id = -1;
        $this->name = $name;
        $this->surname = $surname;
        $this->credits = $credits;
        $this->address_id = $address_id;
    }
    
    public static function setDb(\Database $db) {
        self::$db = $db;
    }
    
    public static function load($id = null) {
        self::$db->query('SELECT * FROM User WHERE id=:id');
        self::$db->bind('id', $id);
        $userData = self::$db->single();
 
        if(!empty($userData)) {
            
            $user = new User();
            $user->id = $userData['id'];
            $user->name = $userData['name'];
            $user->surname = $userData['surname'];
            $user->credits = $userData['credits'];
            $user->address_id = $userData['address_id'];

            return $user;

        }
        else {
            return null;
        }
    }
    
    public static function loadAll() {
        self::$db->query('SELECT * FROM User');
        $usersData = self::$db->resultSet();

        if(!empty($usersData)) {
            $usersList = [];
            
            foreach($usersData as $userData) {
                $user = new User();
                $user->id = $userData['id'];
                $user->name = $userData['name'];
                $user->surname = $userData['surname'];
                $user->credits = $userData['credits'];
                $user->address_id = $userData['address_id'];
                
                $usersList[] = $user;
            }
            
            return $usersList;
        }
        else {
            return null;
        }
    }
    
    public function save() {
        self::$db->query("INSERT INTO User (name, surname, credits, address_id) VALUES (:name, :surname, :credits, :address_id)");
        self::$db->bind('name', $this->getName());
        self::$db->bind('surname', $this->getSurname());
        self::$db->bind('credits', $this->getCredits());
        self::$db->bind('address_id', $this->getAddress_id());
        
        $result = self::$db->execute();
        
        if($result !== false) {
            $this->id = self::$db->lastInsertId();
            return true;
        }
        return false;
    }
    
    public function update() {
        self::$db->query("Update User SET name=:name, surname=:surname, credits=:credits, address_id=:address_id WHERE id=:id");
        self::$db->bind('id', $this->getId());
        self::$db->bind('name', $this->getName());
        self::$db->bind('surname', $this->getSurname());
        self::$db->bind('credits', $this->getCredits());
        self::$db->bind('address_id', $this->getAddress_id());
        
        $result = self::$db->execute();
        
        if($result === true) {
            return true;
        }
        
        return false;
    }
    
    public function delete() {
        if($this->id !== -1) {
            self::$db->query('DELETE FROM User WHERE id=:id');
            self::$db->bind('id', $this->getId());
            $result = self::$db->execute();

            if($result === true) {
                $this->id = -1;
                return true;
            }
            return false;
        }
        return true;
    }
    
    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'credits' => $this->credits,
            'address_id' => $this->address_id
        ];
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getCredits() {
        return $this->credits;
    }

    public function getAddress_id() {
        return $this->address_id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
    }

    public function setCredits($credits) {
        $this->credits = $credits;
    }

    public function setAddress_id($address_id) {
        $this->address_id = $address_id;
    }

}