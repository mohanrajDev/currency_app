<?php

use App\CurrencyCode;
use Illuminate\Database\Seeder;

class CurrencyCodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $available_codes = config('currencycode');

        $currency_codes = file_get_contents('https://gist.githubusercontent.com/tiagodealmeida/0b97ccf117252d742dddf098bc6cc58a/raw/f621703926fc13be4f618fb4a058d0454177cceb/countries.json');
        $currency_codes = json_decode($currency_codes);
        $currency_codes = $currency_codes->countries->country;

        foreach ($currency_codes as $currency_code) {
            if (in_array( $currency_code->currencyCode, $available_codes)) {
                
                $exits = CurrencyCode::where('code', $currency_code->currencyCode)->first();
                if (! $exits) {
                    $code = new CurrencyCode;
                    $code->code = $currency_code->currencyCode;
                    $code->country = $currency_code->countryName;
                    $code->save();
                }
            }
        }
    }
}
