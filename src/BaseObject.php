<?php
namespace Makcumka\OzonLogistics;

use Makcumka\OzonLogistics\Client;

class BaseObject
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function checkRequired(array $params, array $requiredParams): bool
    {
        if(empty($params) && !empty($requiredParams)) {
            throw new \Exception('Missing required params');
        }

        foreach($requiredParams AS $requiredParam) {
            $flag = false;
            foreach($params AS $key=>$param) {
                if($key == $requiredParam) $flag = true;
            }
            
            if($flag === false) {
                throw new \Exception('Missing required params "' . $requiredParam . '"'); 
            }
        }

        return true;
    }
}