<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BrandsTableSeeder::class);
        $this->call(SuppliersTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(AttributeGroupTableSeeder::class);
        $this->call(StatusTableSeeder::class);
        $this->call(PaymentStatusTableSeeder::class);
        $this->call(PaymentMethodTableSeeder::class);
        $this->call(AttributesTableSeeder::class);
        $this->call(GroupTableSeeder::class);
    }
}
