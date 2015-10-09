<?php

require __DIR__ . '/vendor/autoload.php';

use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;
use Google\Spreadsheet\SpreadsheetService;
use Google\Spreadsheet\Exception as SpreadsheetException;

// load env vars from .env
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();
$accessToken = getEnv('accessToken');

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
