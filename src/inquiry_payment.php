<?php
require __DIR__ . '/../vendor/autoload.php';

Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/..' . '')->load();

require __DIR__ . '/../../briapi-sdk/autoload.php';

use BRI\QrisMPMDynamic\QrisMPMDynamic;
use BRI\TransferCredit\InterbankTransfer;
use BRI\Util\GetAccessToken;
use BRI\Util\VarNumber;

$interbankTransfer = new InterbankTransfer();

// env values
$clientId = $_ENV['CONSUMER_KEY']; // customer key
$clientSecret = $_ENV['CONSUMER_SECRET']; // customer secret
$pKeyId = $_ENV['PRIVATE_KEY']; // private key

// url path values
$baseUrl = 'https://sandbox.partner.api.bri.co.id'; //base url

$partnerId = '456077'; //partner id
$channelId = '12345'; // channel id

$getAccessToken = new GetAccessToken();

[$accessToken, $timestamp] = $getAccessToken->get(
  $clientId,
  $pKeyId,
  $baseUrl
);

$generateQR = new QrisMPMDynamic();

$originalReferenceNo = (string) (new VarNumber())->generateVar(13);
$serviceCode = '17';
$terminalId = '100492';

$body = [
  'originalReferenceNo' => $originalReferenceNo,
  'serviceCode' => $serviceCode,
  'additionalInfo' => (object) [
    'terminalId' => $terminalId
  ]
];

$response = $generateQR->inquiryPayment(
  $clientSecret,
  $partnerId,
  $baseUrl,
  $accessToken,
  $channelId,
  $timestamp,
  $body
);

echo $response;
