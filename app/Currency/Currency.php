<?php

namespace App\Currency;

class Currency {

    protected $currency_data;

    public function __construct()
    {
       $url = 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';
       $currency_data = file_get_contents($url);
       $currency_data = simplexml_load_string($currency_data);
       $currency_data = json_encode( $currency_data);
       $currency_data = json_decode( $currency_data);      
       $this->currency_data = $currency_data->Cube->Cube;
    }

    public function getDate()
    {
        $data = (array) $this->currency_data;
        return $data['@attributes']->time;
    }

    public function getCurrencyList()
    {
       $currency_lists = [];
       $lists = $this->currency_data->Cube;
       foreach ( $lists as $list) {
          $list = (array) $list;
          $list = $list['@attributes'];
          $currency_lists[$list->currency] = $list->rate;
       }

       return $currency_lists;
    }

    public function getExchangeRate($from, $to)
    {
        $currency_lists = $this->getCurrencyList();
        $base_currency = $currency_lists[$from];
        $to_currency = $currency_lists[$to];
        return  round($base_currency / $to_currency, 2);
    }
}