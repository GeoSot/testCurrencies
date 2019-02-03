<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateExchangesRates;
use App\Models\AvailableExchange;
use App\Models\Currency;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeCurrencies = Currency::active()->has('availableExchanges')->orderBy('name')->get();

        $availableExchanges = $activeCurrencies->map(function (Currency $item) {
            return $item->availableExchanges()->get()->map(function (AvailableExchange $item) {
                return $item->currencyTo->forSelectBox();
            });
        })->flatten(1)->unique();
        $currencies = $activeCurrencies->map(function (Currency $item) {
            return $item->forSelectBox(['available_exchanges']);
        });
        return view('welcome', compact('currencies', 'availableExchanges'));
    }


    public function getExchange(Request $request)
    {
        $this->validate($request, [
            'selected_coin' => 'required',
            'exchange_to'   => 'required',
            'amount'        => 'required|numeric',
        ]);
        $amount = $request->input('amount', 1);
        $selectedCoin = Currency::findOrFail($request->input('selected_coin'));
        $exchangeToCoin = Currency::findOrFail($request->input('exchange_to'));
        $result = $selectedCoin->getExchangeTo($exchangeToCoin, $amount);

        $text = "{$selectedCoin->getHumanFormatted($amount)} {$selectedCoin->name} ({$selectedCoin->code_text}) is equal to {$exchangeToCoin->getHumanFormatted($result)} {$exchangeToCoin->name} ({$exchangeToCoin->code_text})";
       $text.='</br><small> Each currency has been formatted according to its specifications</small> ';
        return response()->json($text);
    }


}
