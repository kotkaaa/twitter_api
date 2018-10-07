<?php defined("APP_PATH") or die ("Restricted access");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TwiterApi;

/**
 * Description of ApiTweet
 *
 * @author oleksandr
 */
abstract class TweetPrototype {
    //put your code here
    protected $user;
    protected $tweet;
    protected $hashtag = [];

    abstract public function __clone();
    
    public function setUser(string $user) {
        $this->user = $title;
    }
    
    public function setTweet(string $tweet) {
        $this->tweet = $tweet;
    }
    
    public function setHashTag(string $hashtag) {
        $this->hashtag[] = $hashtag;
    }
}

class Tweet extends TweetPrototype {
    
    public function __construct(string $user) {
        $this->user = $user;
    }

    public function __clone() {
    }
}