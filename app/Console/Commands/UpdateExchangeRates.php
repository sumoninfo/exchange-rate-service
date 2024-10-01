<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\CurrencyHistory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:rates:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update currency exchange rates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get('http://www.cbr.ru/scripts/XML_daily.asp');
        $xml = simplexml_load_string($response->body());

        foreach ($xml->Valute as $valute) {
            $currencyName = (string)$valute->Name;
            $rate = (float)str_replace(',', '.', $valute->Value);

            $currency = Currency::updateOrCreate(
                ['name' => $currencyName],
                ['rate' => $rate]
            );

            CurrencyHistory::create([
                'currency_id' => $currency->id,
                'rate' => $rate
            ]);
        }

        $this->info('Exchange rates updated successfully!');
    }
}
