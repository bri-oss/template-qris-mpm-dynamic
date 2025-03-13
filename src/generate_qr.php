<?php

require 'utils.php';

header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
header('Content-Type: application/json'); // Ensure all responses are JSON

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
} catch (InvalidArgumentException $e) {
  // Return a generic error message to the client
  http_response_code(400); // Bad Request

  // Log the error for debugging
  error_log('InvalidArgumentException: ' . $e->getMessage());
} catch (RuntimeException $e) {
  // Return a generic error message to the client
  http_response_code(500); // Internal Server Error

  // Log the error for debugging
  error_log('RuntimeException: ' . $e->getMessage());
} catch (Exception $e) {
  // Return a generic error message to the client
  http_response_code(500); // Internal Server Error

  // Log any other unexpected errors for debugging
  error_log('UnexpectedException: ' . $e->getMessage());
}
