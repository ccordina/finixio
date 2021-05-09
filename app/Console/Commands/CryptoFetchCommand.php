<?php

namespace App\Console\Commands;

use App\Models\CryptoCurrency;
use App\Models\CryptoCurrencyPrice;
use App\Services\CryptoCompareService;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Symfony\Component\Console\Input\InputArgument;

class CryptoFetchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypto:fetch {limit=10} {currency=EUR} {uri=toplist}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch a predefined number of top cryptocurrencies from CryptoCompare.com and store them in the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $uri = $this->argument('uri');
        if (Arr::exists(config('cryptocompare.api.api_uri'), $uri)) {
            $uri = config('cryptocompare.api.api_uri')[$uri];
        } else {
            $uri = 'toplist';
        }

        $this->info("Performing API call...");
        $cryptoService = new CryptoCompareService(config('cryptocompare.api.base_uri'));
        $cryptoService->setQueryParams(
            [
                'limit' => $this->argument('limit'),
                'tsym' => $this->argument('currency')
            ]
        );
        $cryptoService->setUri($uri);
        $response = $cryptoService->fetch();

        if ($response->getData()->status !== 200) {
            $this->error('API call failed');
            return;
        }

        $data = json_decode($response->getData()->data, true);

        if (Arr::exists($data,'Response') && Arr::get($data,'Response', '') == 'Error') {
            $this->error(Arr::get($data, 'Message',''));
            return;
        }

        foreach ($data['Data'] as $currency) {
            $cryptoCurrency = CryptoCurrency::firstOrNew([
                'name' => Arr::get($currency, 'CoinInfo.Name', ''),
            ]);
            $cryptoCurrency->fill([
                'fullname' => Arr::get($currency, 'CoinInfo.FullName', '')
            ])->save();

            $this->info("Created/Updated Currency {$cryptoCurrency->name}-{$cryptoCurrency->fullname}!");

            CryptoCurrencyPrice::create([
                'currPrice' => Arr::get($currency, 'RAW.' . $this->argument('currency') . '.PRICE', ''),
                'currPriceFormatted' => Arr::get($currency, 'DISPLAY.' . $this->argument('currency') . '.PRICE', ''),
                'openPrice' => Arr::get($currency, 'RAW.' . $this->argument('currency') . '.OPENDAY', ''),
                'openPriceFormatted' => Arr::get($currency, 'DISPLAY.' . $this->argument('currency') . '.OPENDAY', ''),
                'priceChange' => Arr::get($currency, 'RAW.' . $this->argument('currency') . '.CHANGEDAY', ''),
                'priceChangeFormatted' => Arr::get($currency, 'DISPLAY.' . $this->argument('currency') . '.CHANGEDAY', ''),
                'crypto_currency_id' => $cryptoCurrency->id
            ])->save();
        }

        $this->info('Imported all crypto currencies successfully!');
    }
}
