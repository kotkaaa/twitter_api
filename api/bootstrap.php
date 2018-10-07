<?php defined("APP_PATH") or die ("Restricted access");

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require 'Api.php';
require 'ApiConfig.php';
require 'ApiConnection.php';
require 'ApiError.php';
require 'ApiResponse.php';

$Api = \TwiterApi\Api::createInstance();