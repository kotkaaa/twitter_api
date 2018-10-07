<?php defined("APP_PATH") or die ("Restricted access");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace TwiterApi;

use TwiterApi\DbConnection,
    TwiterApi\ApiConnection,
    TwiterApi\Router,
    TwiterApi\Error,
    TwiterApi\Response,
    TwiterApi\Validator,
    TwiterApi\Tweet,
    TwiterApi\TwitterAPIExchange;
/**
 * Description of Api
 *
 * @author oleksandr
 */

final class Api {
    //put your code here
    static $instance;
    /**
     * 
     * @return \TwiterApi\ApiInstance
     */
    public static function createInstance(): ApiInstance {
        if (null === static::$instance) {
            static::$instance = new ApiInstance();
        } return static::$instance;
    }
    
    private function __construct() {
    }

    private function __clone() {
    }

    private function __wakeup() {
    }
}

class ApiInstance {
    
    const API_SETTINGS = [
        "oauth_access_token"        => "1962472824-9G8o7HMJw8fpYHLsSc9rCLREH95UYuD9DfHtTYS",
        "oauth_access_token_secret" => "h4Qcjs1lQG9WS1sfibx9NxfT63mqi9KFUETtmmps",
        "consumer_key"              => "jPzCivxf4gh6EaeF63PUyQ",
        "consumer_secret"           => "3elSGvQpy2wNE4Ok4hRQilAKMNKQ1n8THenLvC5qnI",
    ];

    private $shuffleTweets = true; // выводить твиты всех пользователей в перемешку или нет

    protected $json;
    protected $DB;
    protected $Router;
    protected $Api;

    public function __construct() {
        $this->DB  = DbConnection::getConnection();
        $this->Router = new Router();
        $this->Api = new TwitterAPIConnection(self::API_SETTINGS);
        $this->json = [];
    }
    
    /**
     * Обработка ошибки вызова несуществующего метода
     * 
     * @param string $name
     * @param mixed $arguments
     */
    public function __call(string $name, $arguments) {
        Error::msg(4);
    }
    
    /**
     * Запуск метода из Url
     */
    public function run() {
        $this->{$this->Router->getMethod()}();
    }
    
    /**
     * Добавление пользователя в БД
     */
    private function add() {
        $id     = $this->Router->getParam("id");
        $user   = $this->Router->getParam("user");
        $secret = $this->Router->getParam("secret");
        if (Validator::checkSecret($id, $user, $secret)) {
            try {
                $raw = json_decode($this->Api->setQuery('?screen_name='.$user)->buildOauth('https://api.twitter.com/1.1/users/show.json', "GET")->prepareRequest());
            } catch (Exception $e) {
                Error::msg (6);
            }
            if (!empty($raw)) {
                $result = $this->DB->query("INSERT IGNORE INTO `".DbConnection::TBL_USERS."` (`screen_name`, `name`) VALUES ('{$user}', '{$raw->name}')");
                if (!$result) Error::msg (2);
            } 
        } exit;
    }
    
    /**
     * Удаление пользователя из БД
     */
    private function remove() {
        $id     = $this->Router->getParam("id");
        $user   = $this->Router->getParam("user");
        $secret = $this->Router->getParam("secret");
        if (Validator::checkSecret($id, $user, $secret)) {
            $result = $this->DB->query("DELETE FROM `".DbConnection::TBL_USERS."` WHERE `screen_name`='$user'");
            if (!$result) Error::msg (2);
        } exit;
    }
    
    /**
     * Вывод твитов добавленных пользователей
     */
    private function feed() {
        $id     = $this->Router->getParam("id");
        $secret = $this->Router->getParam("secret");
        $result = $this->DB->query("SELECT * FROM `".DbConnection::TBL_USERS."`");
        if (!$result) Error::msg (2);
        $this->json["feed"] = [];
        while ($user = $result->fetch_object()) {
            $raw = json_decode($this->Api->setQuery('?screen_name='.$user->screen_name.'&count=5')->buildOauth('https://api.twitter.com/1.1/statuses/user_timeline.json')->prepareRequest());
            if (empty($raw)) continue; // если нет постов - пропускаем
            $tweet = null;
            foreach ($raw as $post) {
                if (!$tweet instanceof Tweet) $tweet = new Tweet($post->user->name);
                else $tweet = clone $tweet;
                $tweet->setTweet($post->text);
                if (!empty($post->entities->hashtags)) {
                    foreach ($post->entities->hashtags as $tag) $tweet->setHashTag($tag->text);
                } array_push($this->json["feed"], (array) $tweet);
            }
        } if ($this->shuffleTweets) shuffle ($this->json["feed"]);
        Response::respond($this->json);
    }
}

