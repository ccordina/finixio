<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoCurrencyPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_currency_prices', function (Blueprint $table) {
            $table->id();
            $table->decimal('currPrice');
            $table->string('currPriceFormatted');
            $table->decimal('openPrice');
            $table->string('openPriceFormatted');
            $table->decimal('priceChange');
            $table->string('priceChangeFormatted');
            $table->foreignId('crypto_currency_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crypto_currency_prices');
    }
}
