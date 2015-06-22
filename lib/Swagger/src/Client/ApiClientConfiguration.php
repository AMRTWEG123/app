<?php
/**
 *  Copyright 2015 SmartBear Software
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */

namespace Swagger\Client;

class ApiClientConfiguration {

  private static $defaultConfiguration = null;

  /**
   * Associate array to store API key(s)
   */
  protected $apiKeys = array();

  /**
   * Associate array to store API prefix (e.g. Bearer)
   */
  protected $apiKeyPrefixes = array();

  /**
   * Username for HTTP basic authentication
   */
  protected $username = '';

  /**
   * Password for HTTP basic authentication
   */
  protected $password = '';

  /**
   * default headers for requests this conf
   */
  protected $defaultHeaders = array();

  /**
   * The host
   */
  protected $host = 'http://localhost';

  /*
   * @var string timeout (second) of the HTTP request, by default set to 0, no timeout
   */
  protected $curlTimeout = 0;

  /*
   * @var string user agent of the HTTP request, set to "PHP-Swagger" by default
   */
  protected $userAgent = "PHP-Swagger";

  /**
   * Debug switch (default set to false)
   */
  protected $debug = false;

  /**
   * Debug file location (log to STDOUT by default)
   */
  protected $debugFile = 'php://output';

  /**
   * @param string $key
   * @param string $value
   * @return ApiClientConfiguration
   */
  public function setApiKey($key, $value) {
    $this->apiKeys[$key] = $value;
    return $this;
  }

  /**
   * @param $key
   * @return string
   */
  public function getApiKey($key) {
    return isset($this->apiKeys[$key]) ? $this->apiKeys[$key] : null;
  }

  /**
   * @param string $key
   * @param string $value
   * @return ApiClientConfiguration
   */
  public function setApiKeyPrefix($key, $value) {
    $this->apiKeyPrefixes[$key] = $value;
    return $this;
  }

  /**
   * @param $key
   * @return string
   */
  public function getApiKeyPrefix($key) {
    return isset($this->apiKeyPrefixes[$key]) ? $this->apiKeyPrefixes[$key] : null;
  }

  /**
   * @param string $username
   * @return ApiClientConfiguration
   */
  public function setUsername($username) {
    $this->username = $username;
    return $this;
  }

  /**
   * @return string
   */
  public function getUsername() {
    return $this->username;
  }

  /**
   * @param string $password
   * @return ApiClientConfiguration
   */
  public function setPassword($password) {
    $this->password = $password;
    return $this;
  }

  /**
   * @return string
   */
  public function getPassword() {
    return $this->password;
  }

  /**
   * add default header
   *
   * @param string $headerName header name (e.g. Token)
   * @param string $headerValue header value (e.g. 1z8wp3)
   * @return ApiClient
   */
  public function addDefaultHeader($headerName, $headerValue) {
    if (!is_string($headerName)) {
      throw new \InvalidArgumentException('Header name must be a string.');
    }

    $this->defaultHeaders[$headerName] =  $headerValue;
    return $this;
  }

  /**
   * get the default header
   *
   * @return array default header
   */
  public function getDefaultHeaders() {
    return $this->defaultHeaders;
  }

  /**
   * @param string $host
   * @return ApiClientConfiguration
   */
  public function setHost($host) {
    $this->host = $host;
    return $this;
  }

  /**
   * @return string
   */
  public function getHost() {
    return $this->host;
  }

  /**
   * set the user agent of the api client
   *
   * @param string $userAgent the user agent of the api client
   * @return ApiClient
   */
  public function setUserAgent($userAgent) {
    if (!is_string($userAgent)) {
      throw new \InvalidArgumentException('User-agent must be a string.');
    }

    $this->userAgent = $userAgent;
    return $this;
  }

  /**
   * get the user agent of the api client
   *
   * @return string user agent
   */
  public function getUserAgent() {
    return $this->userAgent;
  }

  /**
   * set the HTTP timeout value
   *
   * @param integer $seconds Number of seconds before timing out [set to 0 for no timeout]
   * @return ApiClient
   */
  public function setCurlTimeout($seconds) {
    if (!is_numeric($seconds) || $seconds < 0) {
      throw new \InvalidArgumentException('Timeout value must be numeric and a non-negative number.');
    }

    $this->curlTimeout = $seconds;
    return $this;
  }

  /**
   * get the HTTP timeout value
   *
   * @return string HTTP timeout value
   */
  public function getCurlTimeout() {
    return $this->curlTimeout;
  }

  /**
   * @param bool $debug
   * @return ApiClientConfiguration
   */
  public function setDebug($debug) {
    $this->debug = $debug;
    return $this;
  }

  /**
   * @return bool
   */
  public function getDebug() {
    return $this->debug;
  }

  /**
   * @param string $debugFile
   * @return ApiClientConfiguration
   */
  public function setDebugFile($debugFile) {
    $this->debugFile = $debugFile;
    return $this;
  }

  /**
   * @return string
   */
  public function getDebugFile() {
    return $this->debugFile;
  }

  /**
   * @return ApiClientConfiguration
   */
  public static function getDefaultConfiguration() {
    if (self::$defaultConfiguration == null) {
      return new ApiClientConfiguration();
    }

    return self::$defaultConfiguration;
  }

  public static function setDefaultConfiguration(ApiClientConfiguration $config) {
    self::$defaultConfiguration = $config;
  }
}
