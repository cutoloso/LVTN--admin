<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->delete();
        DB::table('category')->insert([
            'name'          => 'Điện thoại',
            'icon'          => '<i class="fas fa-mobile-alt"></i>',
            'sort_order'    => 1,
            'created_at'    => new DateTime,
            'updated_at'    => new DateTime,
        ]);
        DB::table('category')->insert([
            'name'          => 'Phụ kiện',
            'icon'          => '<i class="fas fa-headphones"></i>',
            'sort_order'    => 2,
            'created_at'    => new DateTime,
            'updated_at'    => new DateTime,
        ]);

        DB::table('category')->insert([
            'name'          => 'Tin tức',
            'icon'          => '<i class="fas fa-newspaper"></i>',
            'sort_order'    => 3,
            'created_at'    => new DateTime,
            'updated_at'    => new DateTime,
        ]);
    }
}
