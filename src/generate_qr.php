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
  $partnerReferenceNo = (string) (new VarNumber())->generateVar(14);
  $value = '';
  $currency = '';
  $merchantId = '';
  $terminalId = '';

  $validateInputs = sanitizeInput([
    'partnerId' => $partnerId,
    'channelId' => $channelId,
    'partnerReferenceNo' => $partnerReferenceNo,
    'value' => $value,
    'currency' => $currency,
    'merchantId' => $merchantId,
    'terminalId' => $terminalId
  ]);

  $body = [
    'partnerReferenceNo' => $validateInputs['partnerReferenceNo'],
    'amount' => (object) [
      'value' => $validateInputs['value'],
      'currency' => $validateInputs['currency'],
    ],
    'merchantId' => $validateInputs['merchantId'],
    'terminalId' => $validateInputs['terminalId']
  ];

  $response = fetchGenerateQR(
    $clientSecret,
    $partnerId,
    $baseUrl,
    $accessToken,
    $validateInputs['channelId'],
    $timestamp,
    $body
  );

  echo $response;
} catch (Exception $e) {
  error_log('Error: ' . $e->getMessage());
  exit(1);
}
