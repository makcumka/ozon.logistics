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

    public function getTrackByOrderNumber(string $orderNumber)
    {
        if ($orderNumber === null) {
            throw new \InvalidArgumentException('orderNumber is empty');
        }

        $url = $this->pathURL . '/byordernumber/?orderNumber=' . $orderNumber;

        return $this->getClient()->request($url, 'GET');
    }

    public function getTrackByList(array $list)
    {
        $params['articles'] = $list;
        return $this->getClient()->request($this->pathURL . '/list', 'POST', $params);
    }
}