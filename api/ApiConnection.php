<?php defined("APP_PATH") or die ("Restricted access");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TwiterApi;

use TwiterApi\Error;

interface ConnectionInterface {
    public function connect();
    public function getConnection();
}

/**
 * Description of Connection
 *
 * @author oleksandr
 */
class DbConnection implements \TwiterApi\ConnectionInterface {
    
    const DB_SETTINGS = [
        "db_name"     => "api_test", 
        "db_host"     => "127.0.0.1", 
        "db_user"     => "root", 
        "db_password" => "2c4uk915"];

    //put your code here
    protected $PDO;
    
    private function connect() {
        try {
            $this->PDO = (new DbConnectionBuilder())
                    ->setHost(self::DB_SETTINGS["db_host"])
                    ->setName(self::DB_SETTINGS["DB_NAME"])
                    ->setUser(self::DB_SETTINGS["db_user"])
                    ->setPassword(self::DB_SETTINGS["db_password"])
                    ->build();
        } catch (PDOException $e) {
            \TwiterApi\Error::msg(1);
        }
    }
    
    public static function getConnection() : \TwiterApi\ConnectionInterface {
        return (new self())->connect();
    }
}

class DbConnectionBuilder {
    
    protected $db_name;
    protected $db_host;
    protected $db_user;
    protected $db_password;
    
    public function __construct() {
        ;
    }

    public function build() : \PDO {
        return new PDO("mysql:{$this->db_name};host={$this->db_host}", $this->db_user, $this->db_password);
    }
    
    public function setName(string $name) {
        $this->db_name = $name;
        return $this;
    }
    
    public function setHost(string $host) {
        $this->db_host = $host;
        return $this;
    }
    
    public function setUser(string $user) {
        $this->db_user = $host;
        return $this;
    }
    
    public function setPassword(string $password) {
        $this->db_password = $password;
        return $this;
    }
}

class ApiConnection implements \TwiterApi\ConnectionInterface {
    
    const API_URL = "https://api.twitter.com/1.1/statuses/user_timeline.json";
    
    protected $CH;

    private function connect() {
        $this->CH = curl_init();
    }
    
    public function getConnection() : \TwiterApi\ConnectionInterface {
        return (new self())->connect();
    }
    
    public function __destruct() {
        curl_close($this->CH);
    }
}

class ApiConnectionBuilder {
    
    protected $url;
    protected $returntransfer;
    protected $params;
}