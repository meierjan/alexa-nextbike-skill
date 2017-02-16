<?php
/**
 * Created by PhpStorm.
 * User: meier
 * Date: 16/02/2017
 * Time: 15:39
 */

namespace wtf\meier\settings;


use Dotenv\Dotenv;

class ApiSettings
{
    const ENV_BASE_URL = 'BASE_URL';
    const ENV_API_KEY = 'API_KEY';


    private $baseUrl;
    private $apiKey;

    private function __construct($baseUrl, $apiKey)
    {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {

        return $this->apiKey;
    }


    public static function createFromDotEnv(Dotenv $env)
    {
        $env->load();
        $env->required([
            ApiSettings::ENV_BASE_URL,
            ApiSettings::ENV_API_KEY
        ]);
        return new ApiSettings(
            $_ENV[ApiSettings::ENV_BASE_URL],
            $_ENV[ApiSettings::ENV_API_KEY]
        );
    }
}