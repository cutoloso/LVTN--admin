<?php

use Illuminate\Database\Seeder;
use App\PaymentStatus;
class PaymentStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_status')->delete();

        $status = [
            ['name'=>'Chưa thanh toán', 'description' => ''],
            ['name'=>'Đã thanh toán', 'description' => ''],
        ];

        foreach($status as $stt){
            PaymentStatus::create($stt);
        }
    }
}
