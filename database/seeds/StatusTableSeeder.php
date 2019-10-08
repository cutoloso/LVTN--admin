<?php

use Illuminate\Database\Seeder;
use App\Status;
class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->delete();

        $status = [
            ['name'=>'Đang xử lý', 'color_code' => '#fff', 'bg_color_code' => '#ffc107'],
            ['name'=>'Đang đóng gói', 'color_code' => '#fff', 'bg_color_code' => '#17a2b8'],
            ['name'=>'Đang vận chuyển', 'color_code' => '#fff', 'bg_color_code' => '#007bff'],
            ['name'=>'Giao hàng thành công', 'color_code' => '#fff', 'bg_color_code' => '#28a745'],
            ['name'=>'Đã hủy', 'color_code' => '#fff', 'bg_color_code' => '#e74a3b'],
        ];

        foreach($status as $stt){
            Status::create($stt);
        }
    }
}
