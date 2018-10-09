<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TwiterApi;

use \TwiterApi\Error;
/**
 * Description of Router
 *
 * @author oleksandr
 */
class Router {
    //put your code here
    protected $method;
    protected $params;
    
    public function __construct() {
        $this->setMethod();
        $this->setParams();
    }

    private function setMethod() {
        $uri = explode("/", \TwiterApi\Request::uri());
        $this->method = $uri[1];
    }
    
    private function setParams() {
        $this->params = \TwiterApi\Request::get();
    }
    
    public function getMethod() {
        return $this->method;
    }
    
    public function getParams() {
        return $this->params;
    }
    
    public function getParam(string $key) : string {
        if (!isset($this->params[$key])) {
            \TwiterApi\Error::msg(3);
        } return $this->params[$key];
    }
}

class Request {
    
    public static function request() {
        return $_REQUEST;
    }
    
    public static function get() {
        return $_GET;
    }
    
    public static function post() {
        return $_POST;
    }
    
    public static function uri() {
        return $_SERVER["REQUEST_URI"];
    }
    
    public static function query() {
        return $_SERVER["QUERY_STRING"];
    }
}
