<?php

namespace Tests\Unit;

use App\Console\Commands\CryptoFetchCommand;
use App\Models\CryptoCurrencyPrice;
use LifeShine\Models\Make;
use LifeShine\Models\Model;
use Tests\TestCase;

class CryptoFetchTest extends TestCase
{
    /**
     * @test
     */
    public function crypto_fetch_command_exists()
    {
        $this->assertTrue(class_exists(CryptoFetchCommand::class));
    }

    /**
     * @test
     */
    public function crypto_fetch_command_executes_successfully()
    {
        $this->artisan('crypto:fetch')
            ->expectsOutput('Imported all crypto currencies successfully!')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function crypto_fetch_command_creates_10_cryptocurrencies_in_EUR()
    {
        $this->artisan('migrate:fresh');
        $this->artisan('crypto:fetch', [
            'limit' => '10',
            'currency' => 'EUR',
        ]);

        $this->assertDatabaseCount(app(CryptoCurrencyPrice::class)->getTable(), 10);
    }

}
