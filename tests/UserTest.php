<?php

use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\Framework\TestCase;

require_once __DIR__.'/../config.php';
require_once __DIR__.'/../vendor/autoload.php';

class UserTest extends TestCase {
    
    use TestCaseTrait;
    
    public function getConnection() {
        $pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD']);
        return $this->createDefaultDBConnection($pdo, $GLOBALS['DB_NAME']);
    }
    
    public function getDataSet() {
        return $this->createFlatXMLDataSet(__DIR__.'/../datasets/user.xml');
    }
    
    public function testSetters() {
        $user = new User(-1, 'Joetest', 'Doetest', 200, 10);
        
        $user->setName('Joe');
        $user->setSurname('Doe');
        $user->setCredits(600);
        $user->setAddress_id(15);
        
        $this->assertAttributeEquals('Joe', 'name', $user);
        $this->assertAttributeEquals('Doe', 'surname', $user);
        $this->assertAttributeEquals(600, 'credits', $user);
        $this->assertAttributeEquals(15, 'address_id', $user);
    }
    
    public function testGetters() {
         $user = new User('Joe', 'Doe', 800, 20);
         
         $this->assertEquals(-1, $user->getId());
         $this->assertEquals('Joe', $user->getName());
         $this->assertEquals('Doe', $user->getSurname());
         $this->assertEquals(800, $user->getCredits());
         $this->assertEquals(20, $user->getAddress_id());
    }
    
    public function testJsonSerialize() {
        $user = User::load(2);
        $array = $user->jsonSerialize();
        
        $this->assertCount(5, $array);
    }
    
    public function testLoadAll() {
        $this->assertEquals(5, count(User::loadAll()));
    }
    
    public function testLoadWtihExistingUser() {
        $user = User::load(2);
        $this->assertAttributeEquals(2, 'id', $user);
    }
    
    public function testLoadWithNonExistingUser() {
        $this->assertNull(User::load(12));
    }
    
    public function testLoadWithEmptyUserDataBase() {
        $users = User::loadAll();
        foreach($users as $user) {
            $user->delete();
        }
        
        $this->assertNull(User::loadAll());
    }
    
    public function testSaveUser() {
        $dataSet = $this->getConnection()->createDataSet();
         
        $user = new User('Joetest', 'Doetest', 200, 10);
        $result = $user->save();
        $this->assertTrue($result);
        
        $row = $dataSet->getTable('User')->getRow(5);
        
        $this->assertEquals(6, $row['id']);
        $this->assertEquals('Joetest', $row['name']);
        $this->assertEquals('Doetest', $row['surname']);
        $this->assertEquals(200, $row['credits']);
        $this->assertEquals(10, $row['address_id']);
    }
    
    public function testUpdateUser() {
        
        $user = User::load(4);
        
        $user->setName('Newjoetest');
        $user->setSurname('Newdoetest');
        $user->setCredits(400);
        
        $result = $user->update();
        
        $this->assertTrue($result);
        $this->assertEquals(4, $user->getId());
        $this->assertEquals('Newjoetest', $user->getName());
        $this->assertEquals('Newdoetest', $user->getSurname());
        $this->assertEquals(400, $user->getCredits());
        $this->assertEquals(4, $user->getAddress_id());
        
    }
    
    public function testDeleteUser() {
        
        $user = User::load(5);
        
        $deleteResult = $user->delete();
        
        $this->assertTrue($deleteResult);
        $this->assertAttributeEquals(-1, 'id', $user);
    }
    
    public function testDeleteNonExistingUser() {
        
        $user = new User('Joetest', 'Doetest', 200, 10);
        
        $deleteResult = $user->delete();
        
        $this->assertTrue($deleteResult);
        $this->assertAttributeEquals(-1, 'id', $user);
    }
    
    public static function setUpBeforeClass() {
        parent::setUpBeforeClass();
        
        $connectionToDB = new DBmysql();
        User::setDb($connectionToDB);
    }
    
    public static function tearDownAfterClass() {
        
        $connectionToDB = null;
        parent::tearDownAfterClass();
    }
}
