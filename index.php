<?php
/**
 * Google spreadsheet api example
 *
 * @license MIT
 * @author Mike Funk <mike@mikefunk.com>
 */
require __DIR__ . '/vendor/autoload.php';

use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;
use Google\Spreadsheet\SpreadsheetService;
use Google\Spreadsheet\Exception as SpreadsheetException;

// load env vars from .env
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();
$accessToken = getEnv('accessToken');

// use a google client to get the access token
$client = new Google_Client();
if (!file_exists(__DIR__ . '/service_account.json')) {
    throw new RuntimeException(
        'First download your service account json from the google developer ' .
        'console into service_account.json'
    );
}
$credentials = $client->loadServiceAccountJson(
    __DIR__ . '/service_account.json',
    $scopes = ['https://spreadsheets.google.com/feeds']
);
$client->setAssertionCredentials($credentials);
if ($client->getAuth()->isAccessTokenExpired()) {
    $client->getAuth()->refreshTokenWithAssertion();
}
$accessToken = $client->getAuth()->getAccessToken();
// var_dump($accessToken); exit;

try {
    // bootstrap
    $service = new Google_Service_Drive($client);

    // get the spreadsheet
    $fileId = '1JTqyNLK2X1nWb6cLsOVEGDukRhMlbXiIG4AlQt9EuY0';
    // @throws Google_Service_Exception insufficient permission. Assume this
    // is because the service account is not the owner of the doc.
    $file = $service->files->get($fileId);

    // beyond this you have to send raw curl requests, or create your own
    // abstraction. yuck.

} catch (Google_Service_Exception $e) {
    var_dump($e->getMessage()); exit;
}
