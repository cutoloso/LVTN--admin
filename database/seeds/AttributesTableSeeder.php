<?php

use App\Attribute;
use Illuminate\Database\Seeder;

class AttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attributes')->delete();

        $atts = [
            ['name'=>'Loại / Công nghệ màn hình'],
            ['name'=>'Kích thước màn hình'],
            ['name'=>'Độ phân giải màn hình'],
            ['name'=>'Camera trước'],
            ['name'=>'Camera sau'],
            ['name'=>'Tính năng camera'],
            ['name'=>'Đèn Flash'],
            ['name'=>'Video call'],
            ['name'=>'Quay phim'],
            ['name'=>'Bộ nhớ RAM'],
            ['name'=>'Bộ nhớ trong (ROM)'],
            ['name'=>'Hỗ trợ thẻ nhớ ngoài'],
            ['name'=>'Hỗ trợ thẻ tối đa'],
            ['name'=>'Trọng lượng'],
            ['name'=>'Kích thước'],
            ['name'=>'Tên chip'],
            ['name'=>'Tốc độ chip (GHz)'],
            ['name'=>'Chip đồ họa (GPU)'],
            ['name'=>'Hệ điều hành'],
            ['name'=>'Dung lượng pin (mAh)'],
            ['name'=>'Loại pin'],
            ['name'=>'Loại Sim'],
            ['name'=>'Số khe sim'],
            ['name'=>'Wifi'],
            ['name'=>'GPS'],
            ['name'=>'Bluetooth'],
            ['name'=>'Cổng sạc'],
            ['name'=>'Jack tai nghe'],
            ['name'=>'Xem phim'],
            ['name'=>'Nghe nhạc'],
            ['name'=>'Ghi âm'],
            ['name'=>'Thời điểm ra mắt'],
            ['name'=>'SKU'],
        ];

        foreach($atts as $att){
            Attribute::create($att);
        }
    }
}
