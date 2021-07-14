<?php
namespace Makcumka\OzonLogistics\Entity;

use Makcumka\OzonLogistics\BaseObject;

class Document extends BaseObject
{
    private $pathURL = 'principal-integration-api/v1/document';

    public function createDocument(array $postingIds)
    {
        $url = $this->pathURL . '/create';
        $result = $this->getClient()->request($url, 'POST', ['postingIds' => $postingIds]);
        return $result;
    }

    public function getDocument(int $documentId, string $type='Act')
    {
        $params = [
            'id' => $documentId,
            'type' => $type
        ];

        $result = $this->getClient()->request($this->pathURL . '?' . http_build_query($params), 'GET');

        if(!isset($result->documentBytes)) {
            throw new \Exception('Param "documentBytes" not exist');
        }

        return base64_decode($result->documentBytes);
    }
}