<?php define('APP_PATH', __DIR__.DIRECTORY_SEPARATOR);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
chdir(__DIR__);

$Api = require FCPATH . '../api/bootstrap.php';

$Api->run();