<?php

namespace App\Http\Controllers;

use App\Http\Resources\CryptoCurrencyResource;
use App\Models\CryptoCurrency;

class CryptoCurrencyController extends Controller
{
    public function show() {
        return CryptoCurrencyResource::collection(
            CryptoCurrency::with('prices')->get()
        );
    }
}
