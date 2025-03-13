<?php
require 'utils.php';

use BRI\Util\VarNumber;

header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
header('Content-Type: application/json'); // Ensure all responses are JSON

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
