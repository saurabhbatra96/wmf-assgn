# WMF Assignment

## Prerequisites
* PHP - 7.1.16
* MySQL - 5.6.41
* MySQL user `root` with pass `root`.
* A database named `test` in mysql.

## How to run
* Using database `test` (or change the DB name property in code in file `utils/DBWrapper.php`), create required table by running `sql/currency_rates_ddl.sql`.
* Run `$ php cron-job.php` to get data from the API and populate the DB table.
* Run `$ php main.php` to activate the CLI.

## Future improvement
* I've pointed out future improvements as inline comments in the code. Look for `Future me [TODO]: ...` comments.

## Time to complete
Took a bit more than 3 hours to complete the task (including writing documentation and uploading).
