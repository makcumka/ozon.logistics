<?php
require_once 'vendor/autoload.php';

use Makcumka\OzonLogistics\Client;
use Makcumka\OzonLogistics\Entity\Delivery;
use Makcumka\OzonLogistics\Entity\Order;
use Makcumka\OzonLogistics\Entity\Posting;
use Makcumka\OzonLogistics\Entity\Document;

$client = new Client([
    'clientId' => 'ApiTest_11111111-1111-1111-1111-111111111111',
    'clientSecret' => 'SRYksX3PBPUYj73A6cNqbQYRSaYNpjSodIMeWoSCQ8U=',
    'grantType' => 'client_credentials',
    'test' => true,
    'tokenPath' => __DIR__
]);

//$document = new Document($client);

/*
print_r($document->getDocument('900000111902000'));
*/

/*
print_r($document->createDocument([900000098639000]));
*/

/*
$Posting = new Posting($client);
$Posting->getTicket('900000098639000');
*/

//$order = new Order($client);

/*
print_r($order->createOrder([
    'orderNumber' => '9991',
    'buyer' => (object)[
        'name' => 'Иванов Иван Иванович',
        'phone' => '+79005240000',
        'email' => 'test@gmail.com',
        'type' => 'LegalPerson',
        'legalName' => 'ИП Иванов Иван Иванович'
    ],
    'recipient' => (object)[
        'name' => 'Иванов Иван Иванович',
        'phone' => '+79005240000',
        'email' => 'test@gmail.com',
        'type' => 'NaturalPerson'
    ],
    'payment' => (object)[
        'type' => 'FullPrepayment',
        'prepaymentAmount' => 300,
        'recipientPaymentAmount' => 0,
        'deliveryPrice' => 200,
        'deliveryVat' => (object)[
            'rate' => 20,
            'sum' => 40
        ]
    ],
    'deliveryInformation' => (object)[
        'deliveryVariantId' => '17555210692000',
        'address' => 'ул. Ленина, 102'
    ],
    'packages' => [
        (object)[
            'packageNumber' => "1",
            'dimensions' => [
                'weight' => 2,
                'length' => 10,
                'height' => 20,
                'width' => 20
            ]
        ]
    ],
    'orderLines' => [
        (object)[
            'lineNumber' => '1',
            'articleNumber' => '123457',
            'name' => 'Товар №1',
            'weight' => 1200,
            'sellingPrice' => 100,
            'estimatedPrice' => 100,
            'quantity' => 1,
            'vat' => (object)[
                'rate' => 20,
                'sum' => 20
            ],
            'resideInPackages' => ["1"]
        ]
    ]
]));
*/
/*
print_r($order->cancelOrder(['11111']));
*/

/*
print_r($order->getOrder('1'));
*/


//$delivery = new Delivery($client);


/*
print_r($delivery->getCities());
*/

/*
print_r($delivery->getVariants([
    'deliveryType' => 'PickPoint',
    'address' => 'Курган',
    'radius' => 50,
    'packages' => [
        (object)[
            'count' => 1,
            'dimensions' => [
                'weight' => 2,
                'length' => 10,
                'height' => 20,
                'width' => 20
            ],
            'price' => 5000
        ]
    ]
]));
*/

/*
print_r($delivery->calcAmount([
    'deliveryVariantId' => '17555210692000',
    'weight' => '300',
    'fromPlaceId' => '8534308470000'
]));
*/

/*
print_r($delivery->calcTime([
    'deliveryVariantId' => '17555210692000',
    'fromPlaceId' => '8534308470000'
]));
*/

/*
print_r($delivery->getFromPlaces());
*/