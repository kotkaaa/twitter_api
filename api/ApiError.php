<?php defined("APP_PATH") or die ("Restricted access");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TwiterApi;

use TwiterApi\Response;

/**
 * Description of Error
 *
 * @author oleksandr
 */
class Error {
    //put your code here
    const MSG_CONNECTION = "Connection error";
    const MSG_INTERNAL   = "Internal error";
    const MSG_PARAMS     = "Missing parameter";
    const MSG_METHOD     = "Unkown api method";
    const MSG_ACCESS     = "Access denied";
    const MSG_NOT_FOUND  = "User not found";
    
    static $errors = [
        1 => self::MSG_CONNECTION, // ошибка соединения
        2 => self::MSG_INTERNAL, // внутренняя ошибка
        3 => self::MSG_PARAMS, // отсутствует необходимый параметр
        4 => self::MSG_METHOD, // неизвестный метод
        5 => self::MSG_ACCESS, // ошибка доступа
        6 => self::MSG_NOT_FOUND, // ошибка доступа
    ];
    
    public static function msg(int $code) {
        \TwiterApi\Response::respond([
            "error" => self::$errors[$code]
        ]);
    }
}
