<?php define('APP_PATH', __DIR__.DIRECTORY_SEPARATOR);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * http://twitter.api/add/?id=WBYX1TLPRWJ7NSV36LCPP2OZFH6AE6LM&user=elonmusk&secret=3dfb3e37b62f0f13ceca0dfa87a860b007a29e73
 * http://twitter.api/add/?id=WBYX1TLPRWJ7NSV36LCPP2OZFH6AE6LM&user=realdonaldtrump&secret=d4cabab8365316012d44f35935d245c2745caef5
 * http://twitter.api/add/?id=WBYX1TLPRWJ7NSV36LCPP2OZFH6AE6LM&user=cristiano&secret=42f747249eb372f2a1123f05845f248b8c8b060f
 * 
 * http://twitter.api/remove/?id=WBYX1TLPRWJ7NSV36LCPP2OZFH6AE6LM&user=elonmusk&secret=3dfb3e37b62f0f13ceca0dfa87a860b007a29e73
 * http://twitter.api/remove/?id=WBYX1TLPRWJ7NSV36LCPP2OZFH6AE6LM&user=realdonaldtrump&secret=d4cabab8365316012d44f35935d245c2745caef5
 * http://twitter.api/remove/?id=WBYX1TLPRWJ7NSV36LCPP2OZFH6AE6LM&user=cristiano&secret=42f747249eb372f2a1123f05845f248b8c8b060f
 * 
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `screen_name` varchar(32) NOT NULL DEFAULT '',
  `name` varchar(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `udx_name` (`screen_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 * 
 */

require APP_PATH . 'api/bootstrap.php';

$Api->run();