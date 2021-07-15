<?php
namespace Makcumka\OzonLogistics;

use GuzzleHttp\Psr7;
use GuzzleHttp\Client AS GuzzleClient;
use GuzzleHttp\Exception\RequestException;

class Client
{
    public $clientId;
    public $clientSecret;
    public $grantType = 'client_credentials';
    public $tokenPath;

    private $hostURLTest = 'https://api-stg.ozonru.me';
    private $hostURLProduction = 'https://xapi.ozon.ru';

    private $test = false;

    private $token;

    private $httpClient;

    public function __construct(array $params=[])
	{
        if(!isset($params['clientId'])) {
            throw new \Exception('Param "clientId" is required');
        }
        if(!isset($params['clientSecret'])) {
            throw new \Exception('Param "clientSecret" is required');
        }

        $this->clientSecret = $params['clientSecret'];
        $this->clientId = $params['clientId'];

        if(isset($params['test']) && !is_bool($params['test'])) {
            throw new \Exception('Param "test" type is not boolean');
        }
        $this->test = $params['test'];

        if(isset($params['grantType'])) $this->grantType = $params['grantType'];
        if(isset($params['tokenPath'])) $this->tokenPath = $params['tokenPath'];

		$this->httpClient = new GuzzleClient();
	}

    public function getURL(string $path='')
    {
        return ($this->test === true ? $this->hostURLTest : $this->hostURLProduction) . '/' . $path;
    }

    public function request(string $URL, string $method, array $postBody=[])
    {
        $headers['Content-Type'] = "application/json";

        $token = $this->getToken();
        if($token != '') {
            $headers['authorization'] = 'Bearer ' . $token;
        }

        if(!empty($headers)) {
            $opts['headers'] = $headers;
        }

        if(!empty($postBody)) {
            $opts['json'] = $postBody;
        }

        try {
            $request = $this->httpClient->request($method, $this->getURL($URL), $opts);
        } catch(RequestException $e) {
            if ($e->hasResponse() === false) {
                throw new \Exception(Psr7\Message::toString($e->getRequest()));
            }
            throw new \Exception(Psr7\Message::toString($e->getResponse()));
        }

        if($request->getStatusCode() != 200) {
            throw new \Exception($request->getReasonPhrase(), $request->getStatusCode());
        }

        $body = json_decode($request->getBody());

        if(is_null($body)) {
            throw new \Exception('Error JSON decode');
        }

        return $body;
    }

    private function getToken()
    {
        if(!is_null($this->token)) {
            return $this->token;
        }

        $filename = $this->getTokenFilename();
        if(!file_exists($filename)) {
            return $this->auth();
        }

        $string = @file_get_contents($filename);
        if($string === false) {
            return $this->auth();
        }

        $json = json_decode($string);
        if(is_null($json)) {
            return $this->auth();
        }

        if(
            !isset($json->access_token) || 
            !isset($json->expires_in) ||
            $json->access_token == '' ||
            $json->expires_in == ''
        ) {
            return $this->auth();
        }
        
        if(time() < $json->expires_in) {
            $this->token = $json->access_token;
            return $this->token;
        }

        return $this->auth();
    }

    private function auth()
    {
        $params = [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => $this->grantType
        ];

        $request = $this->httpClient->post($this->getURL('principal-auth-api/connect/token'), ['form_params' => $params]);
        if ($request->getStatusCode() != 200) {
            throw new \Exception($request->getReasonPhrase(), $request->getStatusCode());
        }

        $body = json_decode($request->getBody());

        if (is_null($body)) {
            throw new \Exception('Error JSON decode');
        }

        if(isset($body->error)) {
            throw new \Exception($body->error);
        }

        if(!isset($body->access_token)) {
            throw new \Exception('access_token not found');
        }

        if(!isset($body->expires_in)) {
            throw new \Exception('expires_in not found');
        }

        $this->token = $body->access_token;

        file_put_contents($this->getTokenFilename(), json_encode([
            'access_token' => $body->access_token,
            'expires_in' => (time() + (int)$body->expires_in)
        ]));

        return $body->access_token;
    }

    private function getTokenFilename()
    {
        if (is_null($this->tokenPath)) {
            $this->tokenPath = sys_get_temp_dir();
        }
        if (!file_exists($this->tokenPath)) {
            throw new \Exception("Path {$this->tokenPath} not found");
        }
        if (substr($this->tokenPath, -1) != '/') {
            $this->tokenPath .= '/';
        }
        return $this->tokenPath . 'token.txt';
    }
}