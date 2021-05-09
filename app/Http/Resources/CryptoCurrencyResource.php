<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CryptoCurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $prices = $this->prices()->orderBy('created_at', 'DESC')->first();

        return [
            $this->name => [
                'name' => $this->name,
                'fullName' => $this->fullname,
                'currentPrice' => $prices->currPrice,
                'currentPriceFormatted' => $prices->currPriceFormatted,
                'openingPrice' => $prices->openPrice,
                'openingPriceFormatted' => $prices->openPriceFormatted,
                'priceIncrease' => $prices->priceChange,
                'priceIncreaseFormatted' => $prices->priceChangeFormatted,
                'priceIncreasePercentage' => round((($prices->priceChange / $prices->openPrice) * 100), 2),
                'priceIncreasePercentageFormatted' => round((($prices->priceChange / $prices->openPrice) * 100), 2) . '%',
                'lastRetrievedAt' => $prices->created_at->format('Y-m-d H:i:s')
            ]
        ];
    }
}
