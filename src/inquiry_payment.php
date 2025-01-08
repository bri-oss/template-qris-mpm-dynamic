<?php
require 'utils.php';

use BRI\Util\VarNumber;

// url path values
$baseUrl = 'https://sandbox.partner.api.bri.co.id'; //base url

try {
  list($clientId, $clientSecret, $privateKey) = getCredentials();

  list($accessToken, $timestamp) = getAccessToken(
    $clientId,
    $privateKey,
    $baseUrl
  );

  $partnerId = ''; //partner id
  $channelId = ''; // channel id
  $originalReferenceNo = (string) (new VarNumber())->generateVar(13);
  $serviceCode = '';
  $terminalId = '';

  $validateInputs = sanitizeInput([
    'partnerId' => $partnerId,
    'channelId' => $channelId,
    'originalReferenceNo' => $originalReferenceNo,
    'serviceCode' => $serviceCode,
    'terminalId' => $terminalId
  ]);

  $body = [
    'originalReferenceNo' => $validateInputs['originalReferenceNo'],
    'serviceCode' => $validateInputs['serviceCode'],
    'additionalInfo' => (object) [
      'terminalId' => $validateInputs['terminalId']
    ]
  ];

  $response = fetchInquiryPayment(
    $clientSecret,
    $partnerId,
    $baseUrl,
    $accessToken,
    $channelId,
    $timestamp,
    $body
  );

  echo $response;

} catch (Exception $e) {
  error_log('Error: ' . $e->getMessage());
  exit(1);
}
