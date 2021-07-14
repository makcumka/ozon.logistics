<?php
namespace Makcumka\OzonLogistics\Entity;

use Makcumka\OzonLogistics\BaseObject;

class Posting extends BaseObject
{
    private $pathURL = 'principal-integration-api/v1/posting/ticket';

    /*
    return PDF file
    */
    public function getTicket(int $postingId)
    {
        $url = $this->pathURL . '/?postingId=' . $postingId;

        $result = $this->getClient()->request($url, 'GET');

        if(!isset($result->barcode)) {
            throw new \Exception('Param "Barcode" not exist');
        }

        return base64_decode($result->barcode);
    }
}