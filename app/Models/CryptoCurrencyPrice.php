<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CryptoCurrencyPrice
 * @package App\Models
 */
class CryptoCurrencyPrice extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
       'currPrice',
       'currPriceFormatted',
       'openPrice',
       'openPriceFormatted',
       'priceChange',
       'priceChangeFormatted',
       'crypto_currency_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(CryptoCurrency::class);
    }
}
