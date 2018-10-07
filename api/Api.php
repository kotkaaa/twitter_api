<?php defined("APP_PATH") or die ("Restricted access");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace TwiterApi;

use TwiterApi\DbConnection,
    TwiterApi\ApiConnection,
    TwiterApi\Router,
    TwiterApi\Error,
    TwiterApi\Response;
/**
 * Description of Api
 *
 * @author oleksandr
 */

final class Api {
    //put your code here
    static $instance;
    /**
     * 
     * @return \TwiterApi\ApiInstance
     */
    public static function createInstance(): ApiInstance {
        if (null === static::$instance) {
            static::$instance = new ApiInstance();
        } return static::$instance;
    }
    
    private function __construct() {
    }

    private function __clone() {
    }

    private function __wakeup() {
    }
}

class ApiInstance {
    
    protected $DB;
    protected $Router;

    public function __construct() {
        $this->DB = \TwiterApi\DbConnection::getConnection();
    }
    
    public function __call(string $name, $arguments) {
        if (null !== $this->{$name} and !is_callable($this->{$name})) \TwiterApi\Error::msg(2); // 
        \TwiterApi\Error::msg(1);
    }
    
    
}