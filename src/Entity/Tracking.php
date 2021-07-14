<?php
namespace Makcumka\OzonLogistics\Entity;

use Makcumka\OzonLogistics\BaseObject;

class Tracking extends BaseObject
{
    private $pathURL = 'principal-integration-api/v1/tracking';

    public function getTrackNumber(int $orderNumber)
    {
        $url = $this->pathURL . '/bypostingnumber/?postingNumber=' . $orderNumber;

        $result = $this->getClient()->request($url, 'GET');

        return $result;
    }
}