<?php
require __DIR__ . '/../vendor/autoload.php';

Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/..' . '')->load();

require __DIR__ . '/../../briapi-sdk/autoload.php';

use BRI\QrisMPMDynamic\QrisMPMDynamic;
use BRI\TransferCredit\InterbankTransfer;
use BRI\Util\GetAccessToken;

$interbankTransfer = new InterbankTransfer();

// env values
$clientId = $_ENV['CONSUMER_KEY']; // customer key
$clientSecret = $_ENV['CONSUMER_SECRET']; // customer secret
$pKeyId = $_ENV['PRIVATE_KEY']; // private key

// url path values
$baseUrl = 'https://sandbox.partner.api.bri.co.id'; //base url

$partnerId = ''; //partner id
$channelId = ''; // channel id

$getAccessToken = new GetAccessToken();

[$accessToken, $timestamp] = $getAccessToken->get(
  $clientId,
  $pKeyId,
  $baseUrl
);

$generateQR = new QrisMPMDynamic();

$originalReferenceNo = '';
$serviceCode = '';
$terminalId = '';

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
