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

## Tests

* use the genetated command to send monthly balance. This is a coron job that monthly mails the balances

```bash
  php artisan send:balance
```
## Postman

[Postman documentation](https://documenter.getpostman.com/view/10852019/Uz5AtKJA)

