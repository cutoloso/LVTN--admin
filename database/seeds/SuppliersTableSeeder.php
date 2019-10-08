<?php

use Illuminate\Database\Seeder;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suppliers')->delete();
        DB::table('suppliers')->insert([
            'name' => 'thegioididong',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
        DB::table('suppliers')->insert([
            'name' => 'fpt',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

    }
}
