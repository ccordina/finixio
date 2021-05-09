<?php

namespace Tests\Feature;

use App\Services\CryptoCompareService;
use Tests\TestCase;

class CryptoCompareServiceTest extends TestCase
{
    /**
     * @test
     */
    public function service_returns_json_response()
    {
        $service = new CryptoCompareService(config('cryptocompare.api.base_uri'));
        $service->setUri('toplist');
        $service->setQueryParams(['tsym' => 'EUR']);

        $json = $service->fetch();
        $this->assertJson($json->getContent());
    }
}
