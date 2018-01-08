<?php

class ApiHelper{

    /**
     * Display dump of the argument given
     *
     * @param Type $var
     */
    static function dump($arg) {
    	echo "<pre>";
    	var_dump($arg);
    	echo "</pre>";
    }

    /**
     * Encode a string in base64
     *
     * @param String $str
     * @return String
     */
    static function strEncode($str){
        return base64_encode($str);
    }

    /**
     * Decode a string in base64
     *
     * @param String $str
     * @return String
     */
    static function strDecode($str){
        return base64_decode($str, true);
    }

    /**
     * Create customer cookie for saving data
     *
     * @param Object $customer
     * @return void
     */
    static function saveCookie($cookieName, $cookieData){
        session_start();
        $_SESSION[$cookieName] = $cookieData;
        //setcookie($cookieName, json_encode($cookieData)); // 86400 = 1 day
    }

    /**
     * Read cookie selected by name
     *
     * @param Object $customer
     * @return String
     */
    static function getCookie($cookieName){
        session_start();
        // if(!isset($_COOKIE[$cookieName])) {
        //   return 'Cookie with name "' . $cookieName . '" does not exist';
        // } else {
        //   return $_COOKIE[$cookieName];
        // }
        return $_SESSION[$cookieName];
    }

    /**
     * Delete cookie by name
     *
     * @param Object $customer
     * @return void
     */
    static function deleteCookies($cookieName){
        session_start();
        if($cookieName == 'all'){
            unset($_SESSION);
        }else{
            unset($_SESSION[$cookieName]);
        }
        // unset($_COOKIE[$cookieName]);
        // // empty value and expiration one hour before
        // $res = setcookie($cookieName, '', time() - 3600);
    }

}
