# Finixio Laravel PHP/Tech Test

## How to setup 

- Clone the project to your local environment
- Run the following command to start Laravel Sail
    ````
    ./vendor/bin sail up -d
    ````
- Execute the following command
   ````
  composer install
  ````
- Access the test welcome page at: 
  ````
  http://localhost
  ````
- Run the following commands once the environment is up and running

    ````
    php artisan migrate
    ````
    This will create the necessary database tables for the application to store the fetched cryptocurrencies.
## Usage

- To fetch the cryptocurrencies from the CompareCurrency API you need to run the following command

    ````
    php artisan crypto:fetch {uri=toplist} {limit=10} {currency=EUR}
    ````
    Available Params:
  
    - `uri` - specify the uri to access the API (default: toplist)
    - `limit` - set the number of top crypto currencies to fetch (default: 10)
    - `currency` - define the currency for the required prices
    
- To test the endpoint you can access the following url 

    ````
    http://127.0.0.1/crypto
    ````
  
    or perform a CURL request as follows:

    ````
    curl --request GET 'http://127.0.0.1/crypto'
    ````

## Testing

A few tests were added and can be executed by running the following command:

````
./vendor/bin/phpunit
````

## Files Added

- app/Console/Commands/CryptoFetchCommand.php 
- app/Http/Controllers/CryptoCurrencyController.php
- app/Http/Resources/CryptoCurrencyResource.php
- app/Http/Resources/CryptoCurrencyResourceCollection.php
- app/Models/CryptoCurrency.php
- app/Models/CryptoCurrencyPrice.php
- app/Services/CryptoCompareService.php
- config/cryptocompare.php
- database/migrations/2021_05_05_093322_create_crypto_currency_table.php
- database/migrations/2021_05_06_164924_create_crypto_currency_price_table.php
- tests/Feature/CryptoCompareServiceTest.php 
- tests/Unit/CryptoFetchTest.php

