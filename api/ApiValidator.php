<?php defined("APP_PATH") or die ("Restricted access");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TwiterApi;

use TwiterApi\Error;

/**
 * Description of Validator
 *
 * @author oleksandr
 */
class Validator {
    
    const ID_LENGTH = 23; // длина параметра ID

    /**
     * Проверка длины параметра ID
     * 
     * @param string $id
     * @return bool
     */
    private static function checkIdLength (string $id) : bool {
        return (strlen($id) == self::ID_LENGTH);
    }

    /**
     * Валидация secret
     * 
     * @param string $id
     * @param string $user
     * @param string $secret
     * @return bool
     */
    public static function checkSecret (string $id, string $user, string $secret) : bool {
        if (sha1($id.$user)!=$secret) {
            Error::msg(5);
        } return TRUE;
    }
}
