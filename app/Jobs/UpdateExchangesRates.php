<?php

namespace App\Jobs;

use App\Models\Currency;
use App\Models\ExchangeRate;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;


class UpdateExchangesRates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @property Collection currencies
     */
    private $currencies;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->currencies = collect(Currency::select('code', 'name', 'code_text')->get()->keyBy('code_text')->toArray());
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $this->getRequestsData()->each(function (Collection $col, string $key) {

            $response = $this->parseResponse($this->makeRequest($key, $col->get('exchanges')));
            foreach ($response['ratios'] as $ratioCoin => $ratio) {
                $exchangeCoinCode = $this->currencies->where('code_text', $ratioCoin)->first()['code'];
                ExchangeRate::updateOrCreate(
                    ['base_currency_code' => $col->get('currency')->code, 'exchange_currency_code' => $exchangeCoinCode],
                    ['ratio' => $ratio]
                );
            }
        });

    }


    /**
     * @param string     $requestCoin
     * @param Collection $quoteCoins
     *
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function makeRequest(string $requestCoin, Collection $quoteCoins): string
    {
       // Example result '{"disclaimer":"Usage subject to terms: https://openexchangerates.org/terms","license":"https://openexchangerates.org/license","timestamp":1548853200,"base":"' . $requestCoin . '","rates":{"CAD":1.32271,"EUR":0.874813,"GBP":0.76377,"JPY":109.42725,"USD":1}} ';
        $client = new Client();
        $return = null;
        try {
            $result = $client->request('GET', 'https://openexchangerates.org/api/latest.json', [

                'query' => [
                    'app_id'           => env('EXCHANGES_SERVICE_API_KEY'),
                    'base'             => $requestCoin,
                    'symbols'          => $quoteCoins->implode(','),
                    'prettyprint'      => false,
                    'show_alternative' => true
                ]
            ]);
            $return = $result->getBody()->getContents();
        } catch (BadResponseException $exception) {
            Log::error(basename(self::class) . '-Request to openexchangerates FAILED. Requested CurrencyCode: ' . $requestCoin);
        }
        return $return;

    }

    /**
     * @param string $response
     *
     * @return array
     */
    protected function parseResponse(string $response)
    {
        $json = json_decode($response, true);

        return [
            'base'   => array_get($json, 'base'),
            'ratios' => array_get($json, 'rates', [])
        ];
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    protected function getRequestsData()
    {
        $collection = collect();
        Currency::has('availableExchanges')->get()->map(function (Currency $coin) use ($collection) {
            $collection->put($coin->code_text, collect(['currency' => $coin, 'exchanges' => $coin->available_exchanges->pluck('code_text')]));
        });

        return $collection;
    }
}
