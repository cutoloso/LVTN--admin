<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->delete();
        DB::table('brands')->insert([
            'name' => 'samsung',
            'img'   => 'samsung.jpg',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
        DB::table('brands')->insert([
            'name' => 'nokia',
            'img'   => 'nokia.jpg',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
        DB::table('brands')->insert([
            'name' => 'apple',
            'img'   => 'apple.jpg',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
        DB::table('brands')->insert([
            'name' => 'xiaomi',
            'img'   => 'xiaomi.png',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
        DB::table('brands')->insert([
            'name' => 'huawei',
            'img'   => 'huawei.jpg',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
        DB::table('brands')->insert([
            'name' => 'realme',
            'img'   => 'realme.png',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
        DB::table('brands')->insert([
            'name' => 'asus',
            'img'   => 'asus.jpg',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
        DB::table('brands')->insert([
            'name' => 'oppo',
            'img'   => 'oppo.jpg',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
        DB::table('brands')->insert([
            'name' => 'vivo',
            'img'   => 'vivo.jpg',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
        DB::table('brands')->insert([
            'name' => 'vsmart',
            'img'   => 'vsmart.png',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
    }
}
