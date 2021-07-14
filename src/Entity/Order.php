<?php
namespace Makcumka\OzonLogistics\Entity;

use Makcumka\OzonLogistics\BaseObject;

class Order extends BaseObject
{
    private $pathURL = 'principal-integration-api/v1/order';

    public function createOrder(array $params)
    {
        $requiredParams = [
            'orderNumber',
            'buyer',
            'recipient',
            'payment',
            'deliveryInformation',
            'packages',
            'orderLines'
        ];
        $this->checkRequired($params, $requiredParams);

        $result = $this->getClient()->request($this->pathURL, 'POST', $params);
        return $result;
    }

    public function cancelOrder(array $params)
    {
        if(empty($params)) {
            throw new \Exception('Param "Ids" is empty');
        }

        $result = $this->getClient()->request($this->pathURL . '/status/canceled', 'PUT', ['ids' => $params]);
        return $result;
    }

    public function getOrder(string $id)
    {
        if(empty($id)) {
            throw new \Exception('Param "Id" is empty');
        }

        $result = $this->getClient()->request($this->pathURL . '/' . $id, 'GET');

        return $result;
    }
}