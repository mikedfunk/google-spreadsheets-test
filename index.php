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
    $serviceRequest = new DefaultServiceRequest($accessToken);
    ServiceRequestFactory::setInstance($serviceRequest);
    $spreadsheetService = new SpreadsheetService();

    // get the spreadsheet
    $spreadsheetFeed = $spreadsheetService->getSpreadsheets();
    $spreadsheet = $spreadsheetFeed->getByTitle('PostTest');

    // get the worksheet
    $worksheetFeed = $spreadsheet->getWorksheets();
    $worksheet = $worksheetFeed->getByTitle('Sheet1');

    // get the rows that match a columnName / value
    // can also call getListFeed() for all rows
    /** @var Google\Spreadsheet\ListFeed */
    $listFeed = $worksheet->getListFeed(['sq' => 'email = "test1fdsdf@test.com"']);

    // insert if not exists
    if (count($listFeed->getEntries()) === 0) {
        $data = [
            'email' => 'test123' . rand() . '@test.com',
            'acceptedterms' => 'TRUE',
        ];
        $listFeed->insert($data);
        var_dump('DONE'); exit;
    }
    var_dump('ALREADY THERE'); exit;

    // get associative array of values in each row
    // var_dump($listFeed); exit;
    // var_dump($listFeed->getEntries()); exit;
    // /** @var Google\Spreadsheet\ListEntry */
    // foreach ($listFeed->getEntries() as $row) {
        // var_dump($row->getValues()); exit;
    // }

} catch (SpreadsheetException $e) {
    var_dump($e->getMessage()); exit;
}
