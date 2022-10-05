<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('currencies')->insert(
           [
               [
                   'name' => 'Euro',
                   'symbol' => '€',
                   'exchange_rate' => 1,
                   'code' => 'EUR'
               ],
               [
                   'name' => 'USA Dollar',
                   'symbol' => '$',
                   'exchange_rate' => 1,
                   'code' => 'USD'
               ],
               [
                   'name' => 'Polish złoty',
                   'symbol' => 'zł',
                   'exchange_rate' => 4.72,
                   'code' => 'PLN'
               ],
//               [
//               'name' => 'Turkish lira',
//               'symbol' => '₺',
//               'exchange_rate' => 16.39,
//               'code' => 'TKL'
//           ]
           ]

       );
    }
}
