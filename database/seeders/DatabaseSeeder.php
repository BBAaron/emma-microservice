<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('discounts')->insert([
            'id' => 1,
            'type' => 'SIMPLEDISCOUNT',
            'data' => '0.2'
        ]);
        DB::table('discounts')->insert([
            'id' => 2,
            'type' => 'BUYXGETYFREE',
            'data' => '2;1'
        ]);
        DB::table('products')->insert([
            'id' => 1,
            'discount_id' => 1,
        ]);
        DB::table('products')->insert([
            'id' => 3,
            'discount_id' => 2,
        ]);
    }
}
