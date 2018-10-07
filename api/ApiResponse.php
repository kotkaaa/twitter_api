<?php defined("APP_PATH") or die ("Restricted access");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TwiterApi;

/**
 * Description of Response
 *
 * @author oleksandr
 */
class Response {
    //put your code here
    public static function respond($data) {
        header('Content-Type: application/json');
        exit(json_encode($data));
    }
}
