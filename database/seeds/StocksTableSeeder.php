<?php

use Illuminate\Database\Seeder;

class StocksTableSeeder extends Seeder
{
    const STOCKS = [
        '1' => 'Cryptopia',
        '2' => 'Binance',
        '3' => 'Livecoin',
        '4' => 'Liqui',
        '5' => 'KuCoin',
        '6' => 'CoinExchange',
        '7' => 'Qryptos',
        '8' => 'IDEX',
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::STOCKS as $id => $stock)
        {
            \App\Models\Stock::create([
                'id'   => $id,
                'name' => $stock,
            ]);
        }
    }
}
