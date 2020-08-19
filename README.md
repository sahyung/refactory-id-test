# SPE TEST PHP DEVELOPER
Test for PHP Developer position at PT. Solusi Pembayaran Elektronik.

## Quickstart
```
$ git clone
$ cp .env.example .env
$ composer install
$ php artisan migrate --seed
$ php artisan serve
```

## Challenge
1. Create endpoint which handle `request` below
```json
{
    "customer_id": "string",
    "trx_id": "string",
    "trx_amount": "float",
    "trx_date_time": "date_time",
}
```

return `response` below
```json
{
    "customer_id": "string",
    "trx_id": "string",
    "trx_amount": "float",
    "trx_date_time": "date_time",
    "disc": "bool",
    "disc_rate": "integer | percentage of the discount for this transaction",
    "disc_amount": "float | how much discount for this transaction ",
    "payment_amout": "float | amount needs to be paid",
}
```

2. Create endpoint for CRUD tier system for `disc_rate` based on `trx_amount` value, example:
   - Tier 1: 
     - start from 0 to 100.000
     - disc_rate: 10%
     - disc_prob: 90%
   - Tier 2: 
     - start from 100.000 to 200.000
     - disc_rate: 20%
     - disc_prob: 45%

the price range cannot overlap with other tier

3. Create logging system, minimum for this items:
   - request time
   - request values
   - response time
   - response values

4. add security, minimum for CRUD tier system