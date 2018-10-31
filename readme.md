#Currency Converter in Laravel 5.7
##Installation

####CMD
- composer install
- cp .env.example .env
- cp .env.example .env.testing

####FILES
- Modify .env file and set up database settings
- Modify  .env.testing file and set up database settings for phpunit
- Default converter response precision can be set as CONVERTER_PRECISION=

####CMD
- php artisan key:generate
- php artisan key:generate --env=testing

#####If you need migration and db seed:
- php artisan migrate
- php artisan db:seed

- php artisan migrate --env=testing


##Application
###GET /api/v1/converter
#### Responses

#####- 200 OK
/api/v1/converter?base_currency=pln&dest_currency=eur&amount=21


```json
{
    "data": {
        "type": "currency-converter",
        "amount_to_convert": 2.23,
        "currencies": "PLN / EUR",
        "exchange_rate": 4.2887,
        "exchange_rate_date": "2018-06-18",
        "converted_amount": 9.5638
    }
}
```

#####- 422 Unprocessable Entity
/api/v1/converter?base_currency=jpy&dest_currency=eur&exchange_rate=abc
```
{
    "errors": {
        "dest_currency": [
            "Not found exchange rate for given currency codes."
        ],
        "exchange_rate": [
            "The exchange rate must be a number."
        ]
    }
}
```

##Tests
If testing environment is set up you can use phpunit and run tests.
###CMD
- phpunit