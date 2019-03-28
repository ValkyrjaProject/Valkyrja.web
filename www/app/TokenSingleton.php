<?php
/**
 * Created by PhpStorm.
 * User: spytec
 * Date: 3/28/19
 * Time: 10:11 AM
 */

namespace App;


final class TokenSingleton
{
    /**
     * @var {\League\OAuth2\Client\Token\AccessToken}
     */
    static protected $token;

    /**
     * @param {\League\OAuth2\Client\Token\AccessToken} $token
     */
    public static function setToken($token)
    {
        self::$token = $token;
    }

    /**
     * @return \League\OAuth2\Client\Token\AccessToken
     */
    public static function getToken()
    {
        return self::$token;
    }

    /**
     * Private ctor so nobody else can instantiate it
     */
    private function __construct()
    {

    }
}
