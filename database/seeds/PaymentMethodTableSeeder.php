<?php

use Illuminate\Database\Seeder;

class PaymentMethodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_method')->delete();

        DB::table('payment_method')->insert([
            [
                'name' => 'Thanh toán tiền mặt khi nhận hàng (COD)',
                'description'   => 'Nhận hàng và thanh toán trực tiếp với nhân viên giao hàng.',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'name' => 'Thanh toán online',
                'description'   => 'Thanh toán online qua Paypal.',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ]
        ]);
    }
}
