# Template QRIS MPM Dynamic

This is a simple template for QRIS MPM Dynamic SNAP BI using PHP.

module:
- [Get Token](https://developers.bri.co.id/en/snap-bi/api-account-inquiry-external-interbank-transfer#Transfer)
- [Generate QR](https://developers.bri.co.id/en/snap-bi/api-account-inquiry-internal-intrabank-transfer-v11)
- [Inquiry Payment](https://developers.bri.co.id/en/snap-bi/api-transaction-status-inquiry)

## List of Content
- [Instalasi](#instalasi)
  - [Prerequisites](#prerequisites)
  - [How to Setup Project](#how-to-setup-project)
  - [Get Token](#interbank-transfer-inquiry)
  - [Generate QR](#interbank-transfer-transfer)
  - [Inquiry Payment](#intrabank-transfer-inquiry)
- [How to get CONSUMER_KEY and CONSUMER_SECRET](#how-to-get-consumer_key-and-consumer_secret)
- [How to get Private Key](#how-to-get-private-key)
- [.ENV Example](#env-example)
- [Caution](#caution)
- [Disclaimer](#disclaimer)

## Instalasi

### Prerequisites
- php
- composer

### How to Setup Project

```bash
1. run command `cd briapi-template-qris-mpm-dynamic-php` to change directory
2. copy .env file by typing 'cp .env.example .env' in the terminal
3. fill the .env file with the required values
4. run composer install to install all dependencies
```

### Get Token
```bash
1. run command `php src/get_token.php serve`
```

### Generate QR
```bash
1. fill variable $partnerId, eg: '456077'
2. fill variable $channelId, eg: '12345'
3. fill variable $partnerReferenceNo, eg: '12345678901213'
4. fill variable $value, eg: '123456.00'
5. fill variable $currency, eg: 'IDR'
6. fill variable $merchantId, eg: '000001019000014'
7. fill variable $terminalId, eg: '10071096'
8. run command `php src/generate_qr.php serve`
```

### Inquiry Payment
```bash
1. fill variable $partnerId, eg: '456077'
2. fill variable $channelId, eg: '12345'
3. fill variable $originalReferenceNo, Transaction identification number in the service provider's system	, eg: '1234567890110'
4. fill variable $serviceCode, Transaction type indicator (service code of the original request transaction), only have length 2, eg: '17'
5. fill variable $terminalId, Details of the contents of the additionalInfo object are in the table below	, eg: '100492'
```

## How to get CONSUMER_KEY and CONSUMER_SECRET
1. Go to https://developers.bri.co.id/en then login
2. Click menu  My Apps
3. select app
4. copy Consumer Key and Consumer Secret
![alt text](assets/image.png)

## How to get Private Key
1. Go to https://developers.bri.co.id/en then login
2. Click menu  My Apps
3. Click Manage Snap Key
4. Click Add Snap Key
5. Generate RSA key with https://cryptotools.net/rsagen (recomended)
6. Save your private key and fill your public key in Snap key then save
![alt text](assets/image-1.png)

## .ENV Example
```bash
CONSUMER_KEY=pqYYBsSc6rHwCqp6o4R8ExmBRubEpqtY 

CONSUMER_SECRET=idbaNFh0mGSZ7xol 

PRIVATE_KEY="-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQCOkAAcgCOTpZPgmxQKovWho6G3GJmxet6kYqi1wj5jTFuB8lLe
QhppR8ppYIxdvM1mnn2MTJFpHQr1zXwshpsT5YiaFIRxN/VMUi5QPBpgO8BMCBKc
wTL6Kq1pSaeTbdRdtRYNZjidxNWyvWVVbbbVmzH6edelT03YrO/r0aUKYQIDAQAB
AoGAa5D5lIeW0GuplVpNl+z3Wzvk5Ar6xHBKF0ydsW7btf7CON1Ha44C8ZcKgdIo
dv3jGV/SqQ6I1P/l6iteWxZBYXIInrNERaA5l6afUcHES8LBWKwDr6kBpAVXaCaV
yjdzknKMbN2PBNURbL3+O4v3Al8bCp1/e9EwBd99jkSYcMECQQDaEq+Q2ybw7tKi
bW7OEe1p7kMkF73sBW4p8gHRM53WJEfDh1X9DDKsgQqpqm0RASo1kGXIM9D1i7Ip
lcxKZs+pAkEAp1tX+SjnruA1DE8U9OEe83x7U9AReepRS5G8mhv59J3zdruMLWex
jJCDvLgz07YuKIoykgnqBK34UMvBaKH3+QJBAMxQWYFkcpWljF92HCyiC0gGXY2B
WQW7CL3v6dfxfl3V3A7Ly7qsJQYOWMkhzdHyv3Mz+MicE5ka6y+fE6pZrRECQACO
gzpm8m5YfJSv5qfx38J7lYVv2b8IEoEn2PLCSRCRPfAVK6AzChonmOiVzEZWAs1L
uGNX+RlO4taR9vC8KTECQQCLe+kQ/k24bH8RC5cCmvxMaPnYN3mXIoPZYCchxjPv
UHUebON90WEIiQazoXugkCkyRVsXHnglLXUm7CpDjFXt 
-----END RSA PRIVATE KEY-----"
```

## Caution

Please delete the .env file before pushing to github or bitbucket

## Disclaimer

Please note that this project is just a template on the use of BRI-API php sdk and may have bugs or errors.
