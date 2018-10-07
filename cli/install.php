<?php define('APP_PATH', __DIR__.DIRECTORY_SEPARATOR);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

chdir(__DIR__);

shell_exec("mysql -u root -p 2c4uk915");

$smd =  "CREATE DATABASE api_test;".PHP_EOL.
        "USE api_test;".PHP_EOL.
        "CREATE TABLE users (id int(11) unsigned not null auto_increment, screen_name varchar(32) not null, name varchar(64) not null, primary key (id), unique key udx_name (screen_name));";
shell_exec($smd);

exit;