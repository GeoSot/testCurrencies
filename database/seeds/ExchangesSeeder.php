<?php

use Illuminate\Database\Seeder;

class ExchangesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = \App\Models\Currency::all()->pluck('code', 'code_text');

        foreach ($this->getData() as $datum) {

            \App\Models\AvailableExchange::create([
                'currency_from_code' => $currencies->get($datum[0]),
                'currency_to_code'  => $currencies->get($datum[1]),
            ]);
            \App\Models\ExchangeRate::create([
                'base_currency_code'     => $currencies->get($datum[0]),
                'exchange_currency_code' => $currencies->get($datum[1]),
                'ratio' => $datum[2],
            ]);
        }


    }

    protected function getData()
    {
        return [
            ['EUR', 'USD', 1.3764],
            ['EUR', 'CHF', 1.2079],
            ['EUR', 'GBP', 0.8731],
            ['USD', 'JPY', 76.7200],
            ['CHF', 'USD', 1.1379],
            ['GBP', 'CAD', 1.5648],
        ];
    }
}
