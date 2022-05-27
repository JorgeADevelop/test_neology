
# Test Backend developer Neology


## Technologies

| Technologie   | version                                                             |
| ------------- | ------ |
| PHP | 8.1 |
| Laravel | 9 |
| Composer | 2.3.5 |
| MySQL | 8.1 |


## Installation

* use composer to run the next command.

```bash
  composer install
  php artisan migrate --seed
```

* generate the database with a database administrator or mail the script located in the root of the project.

* configure the .env file with your own database properties and email properties (use mailtrap)


## Description
 * Login as admin or checker with (/login - POST) path
 * Register new checkers with (/user - POST) path
 * Register a delivery or departure with (/car_binacle - POST) path. Set true or false one of properties
 * Update a car type with (/car - PUT) path.
 * Create new car types with (/car-type - POST) path
 * Print a balance with (/print-binnacle - POST) path. Set the start and end of dates.
 * Cron job created to start the month
 * Cron job created to send monthly balance
 * And more paths to use 🎯

## Tests

* use the genetated command init a new month. This is a coron job that monthly delete the official cars binnacle.

```bash
  php artisan init:month

* use the genetated command to send monthly balance. This is a coron job that monthly mails the balances

```bash
  php artisan send:balance
```
## Postman

[Postman documentation](https://documenter.getpostman.com/view/10852019/Uz5AtKJA)