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

$partnerReferenceNo = (string) (new VarNumber())->generateVar(14);
$value = '123456.00';
$currency = 'IDR';
$merchantId = '000001019000014';
$terminalId = '10071096';

$body = [
  'partnerReferenceNo' => $partnerReferenceNo,
  'amount' => (object) [
    'value' => $value,
    'currency' => $currency,
  ],
  'merchantId' => $merchantId,
  'terminalId' => $terminalId
];

$response = $generateQR->generateQR(
  $clientSecret,
  $partnerId,
  $baseUrl,
  $accessToken,
  $channelId,
  $timestamp,
  $body
);

echo $response;
