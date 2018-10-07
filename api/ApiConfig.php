<?php defined("APP_PATH") or die ("Restricted access");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TwiterApi;

/**
 * Description of ApiConfig
 *
 * @author oleksandr
 */
class ApiConfig {
    //put your code here
    protected $request;
    protected $params;
    protected $method;

    public function __construct() {
        $this->request = new \ArrayObject($_REQUEST);
        
    }
    
    public function __destruct() {
        $_REQUEST = [];
    }
}

class ApiConfigParams {
    
    protected $id;
    protected $user;
    protected $secret;
    
    public function __construct($re) {
    }
}