<?php defined("APP_PATH") or die ("Restricted access");

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

require 'Api.php';
require 'ApiRouter.php';
require 'ApiConnection.php';
require 'ApiResponse.php';
require 'ApiValidator.php';
require 'ApiError.php';
require 'ApiTweet.php';

$Api = \TwiterApi\Api::createInstance();