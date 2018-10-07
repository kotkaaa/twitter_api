<?php defined("APP_PATH") or die ("Restricted access");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TwiterApi;

use TwiterApi\Error,
    \Exception;

interface ConnectionInterface {
    public function connect();
    public static function getConnection();
}

/**
 * Description of Connection
 *
 * @author oleksandr
 */
class DbConnection implements \TwiterApi\ConnectionInterface {
    
    const DB_SETTINGS = [
        "db_name"     => "api_test", 
        "db_host"     => "127.0.0.1", 
        "db_user"     => "root", 
        "db_password" => "2c4uk915"];

    const TBL_USERS = "users";
    
    //put your code here
    protected $driver;
    
    public function connect() : \mysqli {
        try {
            $this->driver = (new DbConnectionBuilder())
                    ->setHost(self::DB_SETTINGS["db_host"])
                    ->setName(self::DB_SETTINGS["db_name"])
                    ->setUser(self::DB_SETTINGS["db_user"])
                    ->setPassword(self::DB_SETTINGS["db_password"])
                    ->build();
        } catch (Exception $e) {
            echo $e->getMessage();
        } return $this->driver;
    }
    
    public static function getConnection() {
        return (new self())->connect();
    }
}

class DbConnectionBuilder {
    
    protected $db_name;
    protected $db_host;
    protected $db_user;
    protected $db_password;

    public function build() : \mysqli {
        return new \mysqli($this->db_host, $this->db_user, $this->db_password, $this->db_name);
    }
    
    public function setName(string $name) {
        $this->db_name = $name;
        return $this;
    }
    
    public function setHost(string $host) {
        $this->db_host = $host;
        return $this;
    }
    
    public function setUser(string $user) {
        $this->db_user = $user;
        return $this;
    }
    
    public function setPassword(string $password) {
        $this->db_password = $password;
        return $this;
    }
}

class TwitterAPIConnection {

    private $oauth_access_token;
    private $oauth_access_token_secret;
    private $consumer_key;
    private $consumer_secret;
    private $query;
    
    protected $oauth;
    protected $url;

    public function __construct(array $settings) {
        if (!isset($settings['oauth_access_token']) or !isset($settings['oauth_access_token_secret']) or !isset($settings['consumer_key']) or !isset($settings['consumer_secret'])) {
            Error::msg(2);
        }
        $this->oauth_access_token        = $settings['oauth_access_token'];
        $this->oauth_access_token_secret = $settings['oauth_access_token_secret'];
        $this->consumer_key              = $settings['consumer_key'];
        $this->consumer_secret           = $settings['consumer_secret'];
    }

    public function setQuery($string) {
        $getparams = preg_replace('/^\?/', '', explode('&', $string));
        $params = array();
        foreach ($getparams as $field) {
            if ($field !== '') {
                list($key, $value) = explode('=', $field);
                $params[$key] = $value;
            }
        } $this->query = '?' . http_build_query($params, '', '&');
        return $this;
    }

    public function getQuery() {
        return $this->query;
    }

    public function buildOauth($url, $requestMethod = "GET") {
        $consumer_key              = $this->consumer_key;
        $consumer_secret           = $this->consumer_secret;
        $oauth_access_token        = $this->oauth_access_token;
        $oauth_access_token_secret = $this->oauth_access_token_secret;
        $oauth = array(
            'oauth_consumer_key' => $consumer_key,
            'oauth_nonce' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_token' => $oauth_access_token,
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0'
        );
        $query = $this->getQuery();
        if (!is_null($query)) {
            $query = str_replace('?', '', explode('&', $query));
            foreach ($query as $g) {
                $split = explode('=', $g);
                if (isset($split[1])) {
                    $oauth[$split[0]] = urldecode($split[1]);
                }
            }
        }
        $base_info = $this->buildBaseString($url, $requestMethod, $oauth);
        $composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
        $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
        $oauth['oauth_signature'] = $oauth_signature;
        $this->url   = $url;
        $this->oauth = $oauth;
        return $this;
    }

    public function prepareRequest($return = true, $curlOptions = array()) {
        $header  =  array($this->buildAuthorizationHeader($this->oauth), 'Expect:');
        $query   = $this->getQuery();
        $options = $curlOptions + array(
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_HEADER => false,
            CURLOPT_URL => $this->url.$query,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
        );
        $feed = curl_init();
        curl_setopt_array($feed, $options);
        $json = curl_exec($feed);
        if (($error = curl_error($feed)) !== '') {
            curl_close($feed);
            Error::msg(2);
        } curl_close($feed);
        return $json;
    }

    private function buildBaseString($baseURI, $method, $params) {
        $return = array();
        ksort($params);
        foreach($params as $key => $value) {
            $return[] = rawurlencode($key) . '=' . rawurlencode($value);
        } return $method . "&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $return));
    }

    private function buildAuthorizationHeader(array $oauth) {
        $return = 'Authorization: OAuth ';
        $values = array();
        foreach($oauth as $key => $value) {
            if (in_array($key, array('oauth_consumer_key', 'oauth_nonce', 'oauth_signature',
                'oauth_signature_method', 'oauth_timestamp', 'oauth_token', 'oauth_version'))) {
                $values[] = "$key=\"" . rawurlencode($value) . "\"";
            }
        } $return .= implode(', ', $values);
        return $return;
    }

    public function request($url, $method = 'get', $data = null, $curlOptions = array()) {
        $this->setQuery($data);
        return $this->buildOauth($url, $method)->prepareRequest(true, $curlOptions);
    }
}