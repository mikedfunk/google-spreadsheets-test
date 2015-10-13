# Example of using Google Spreadsheets API

This uses the
[php-google-spreadsheet-client](https://github.com/asimlqt/php-google-spreadsheet-client)
library along with the [official google php api
client](https://github.com/google/google-api-php-client). The example code is
in `index.php`.

## Setup

1. Create an app at the [Google developer console](https://console.developers.google.com/project)
3. Under *APIs & auth -> APIs* enable access to the APIs you need (Drive API) on that service account
2. Under *Credentials* create a [service account](https://developers.google.com/identity/protocols/OAuth2ServiceAccount)
3. Download the json for that to this project as `service_account.json`
3. Share your spreadsheet with that account with edit capability
6. [get composer](http://getcomposer.org) and `composer install`
7. Load `index.php` in the browser or on the command line
6. The code is just some sample stuff - use [the package
   docs](https://github.com/asimlqt/php-google-spreadsheet-client) along with
   [the google api
   docs](https://developers.google.com/google-apps/spreadsheets) if you need to
   do something different.
9. You can also use the Google Drive API directly but it does not provide
   abstractions to access the sheets api. You'd have to do that by assembling a
   curl request. :/
