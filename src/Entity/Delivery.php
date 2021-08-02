<?php
namespace Makcumka\OzonLogistics\Entity;

use Makcumka\OzonLogistics\BaseObject;

class Delivery extends BaseObject
{
    private $pathURL = 'principal-integration-api/v1/delivery';

    public function getCities(): array
    {
        $result = $this->getClient()->request($this->pathURL . '/' . 'cities', 'GET');
        return isset($result->data) ? $result->data : $result;
    }

    public function getVariants(array $params)
    {
        $url = $this->pathURL . '/variants?' . http_build_query($params);

        $result = $this->getClient()->request($url, 'GET');

        if(!isset($result->data)) {
            throw new \Exception('Param "data" not found');
        }

        return $result;
    }

    public function getVariantsByAddress(array $params)
    {
        $requiredParams = [
            'deliveryType',
            'address',
            'radius',
            'packages'
        ];
        $this->checkRequired($params, $requiredParams);

        if(!in_array($params['deliveryType'], 
            ['Courier', 'PickPoint', 'Postamat']
        )) {
            throw new \Exception('Incorrect value of the "deliveryType" parameter');
        }

        $result = $this->getClient()->request($this->pathURL . '/variants/byaddress', 'POST', $params);
        
        if(!isset($result->data)) {
            throw new \Exception('Param "data" not found');
        }

        return $result->data;
    }

    public function calcAmount(array $params)
    {
        $requiredParams = [
            'deliveryVariantId',
            'weight',
            'fromPlaceId'
        ];
        $this->checkRequired($params, $requiredParams);

        $url = $this->pathURL . '/' . 'calculate?' . http_build_query($params);

        $result = $this->getClient()->request($url, 'GET');

        if(!isset($result->amount)) {
            throw new \Exception('Param "amount" not found');
        }

        return $result->amount;
    }

    public function calcTime(array $params)
    {
        $requiredParams = [
            'fromPlaceId',
            'deliveryVariantId'
        ];
        $this->checkRequired($params, $requiredParams);

        $url = $this->pathURL . '/' . 'time?' . http_build_query($params);

        $result = $this->getClient()->request($url, 'GET');

        if(!isset($result->days)) {
            throw new \Exception('Param "days" not found');
        }

        return $result->days;
    }

    public function getFromPlaces()
    {
        $result = $this->getClient()->request($this->pathURL . '/' . 'from_places', 'GET');
        return isset($result->places) ? $result->places : $result;
    }
}