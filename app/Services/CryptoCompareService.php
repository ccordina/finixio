<?php

namespace App\Services;

use App\Models\CryptoCurrency;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CryptoCompareService
 * @package App\Services
 */
class CryptoCompareService
{

    /**
     * @var Client
     */
    private $http;

    /**
     * @var
     */
    private $uri;

    /**
     * @var array
     */
    private $params;


    /**
     * CryptoCompareService constructor.
     * @param string $baseUri
     */
    public function __construct(string $baseUri)
    {
        $this->http = new Client([
            'base_uri' => $baseUri,
        ]);
    }

    /**
     * @param string $uri
     */
    public function setUri(string $uri)
    {
        $this->uri = $uri;
    }

    /**
     * @param array $params
     */
    public function setQueryParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetch()
    {
        try {
            $request = $this->http->get($this->uri, [
                'query' => $this->params
            ]);
        } catch (ConnectException $e) {
            // This is will catch all connection timeouts
            return response()->json([ 'status' =>$e->getResponse()->getStatusCode()]);
        } catch (ClientException $e) {
            // This will catch all 400 level errors.
            return response()->json([ 'status' =>$e->getResponse()->getStatusCode()]);
        }

        return response()->json([
            'status' => $request->getStatusCode(),
            'data'   => $request->getBody()->getContents()
        ]);
    }
}
