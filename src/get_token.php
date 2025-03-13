<?php

require 'utils.php';

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

  echo htmlspecialchars($accessToken, ENT_QUOTES, 'UTF-8');
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
