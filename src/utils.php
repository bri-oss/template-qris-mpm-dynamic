<?php

require __DIR__ . '/../vendor/autoload.php';

Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/..' . '')->load();

require __DIR__ . '/../../briapi-sdk/autoload.php';

use BRI\Util\GetAccessToken;
use BRI\QrisMPMDynamic\QrisMPMDynamic;
use BRI\Util\ExecuteCurlRequest;
use BRI\Util\PrepareRequest;

function getCredentials(): array {
  $clientId = $_ENV['CONSUMER_KEY'] ?? null; // customer key
  $clientSecret = $_ENV['CONSUMER_SECRET'] ?? null; // customer secret
  $privateKey = $_ENV['PRIVATE_KEY'] ?? null; // private key

  return [
    $clientId,
    $clientSecret,
    $privateKey
  ];
}

function getAccessToken(
  string $clientId,
  string $privateKey,
  string $baseUrl
): array {
  $getAccessToken = new GetAccessToken();

  [$accessToken, $timestamp] = $getAccessToken->get(
    $clientId,
    $privateKey,
    $baseUrl
  );

  return [$accessToken, $timestamp];
}

// Sanitize input parameters
function sanitizeInput(array $inputs): array {
  $sanitized = [];
  foreach ($inputs as $key => $value) {
      $sanitized[$key] = filter_var($value, FILTER_SANITIZE_STRING);
      if (empty($sanitized[$key])) {
          throw new Exception("Invalid input parameter for $key");
      }
  }
  return $sanitized;
}

function fetchGenerateQR(
  string $clientSecret,
  string $partnerId,
  string $baseUrl,
  string $accessToken,
  string $channelId,
  string $timestamp,
  array $body
): string {
  $executeCurlRequest = new ExecuteCurlRequest();
  $prepareRequest = new PrepareRequest();

  $generateQR = new QrisMPMDynamic(
    $executeCurlRequest,
    $prepareRequest
  );

  $response = $generateQR->generateQR(
    $clientSecret,
    $partnerId,
    $baseUrl,
    $accessToken,
    $channelId,
    $timestamp,
    $body
  );

  return $response;
}

function fetchInquiryPayment(
  string $clientSecret,
  string $partnerId,
  string $baseUrl,
  string $accessToken,
  string $channelId,
  string $timestamp,
  array $body
): string {
  $executeCurlRequest = new ExecuteCurlRequest();
  $prepareRequest = new PrepareRequest();

  $generateQR = new QrisMPMDynamic(
    $executeCurlRequest,
    $prepareRequest
  );

  $response = $generateQR->inquiryPayment(
    $clientSecret,
    $partnerId,
    $baseUrl,
    $accessToken,
    $channelId,
    $timestamp,
    $body
  );

  return $response;
}
