<?php

use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getData() as $datum) {
            factory(\App\Models\Currency::class)->create($datum);
        }

    }

    protected function getData()
    {
        return [
            'euro'           => [
                'name'                => 'Euro',
                'code'                => 978,
                'code_text'           => 'EUR',
                'subunit'             => 100,
                'symbol'              => '€',
                'decimal_mark'        => ',',
                'thousands_separator' => '.',
            ],
            'usDollar'       => [
                'name'                => 'US Dollar',
                'code'                => 840,
                'code_text'           => 'USD',
                'subunit'             => 100,
                'symbol'              => '$',
                'decimal_mark'        => '.',
                'thousands_separator' => ',',
            ],
            'swissFrank'     => [
                'name'                => 'Swiss Franc',
                'code'                => 756,
                'code_text'           => 'CHF',               
                'subunit'             => 100,
                'symbol'              => 'CHF',
                'decimal_mark'        => '.',
                'thousands_separator' => ',',
            ],
            'britishPound'   => [
                'name'                => 'Pound Sterling',
                'code'                => 826,
                'code_text'           => 'GBP',
                'subunit'             => 100,
                'symbol'              => '£',
                'decimal_mark'        => '.',
                'thousands_separator' => ',',
            ],
            'canadianDollar' => [
                'name'                => 'Canadian Dollar',
                'code'                => 124,
                'code_text'           => 'CAD',              
                'subunit'             => 100,
                'symbol'              => '$',
                'decimal_mark'        => '.',
                'thousands_separator' => ',',
            ],
            'JapaneseYen'    => [
                'name'                => 'Japanese Yen',
                'code'                => 392,
                'code_text'           => 'JPY',              
                'subunit'             => 1,
                'symbol'              => '¥',
                'decimal_mark'        => '.',
                'thousands_separator' => ',',
            ],

        ];
    }
}
