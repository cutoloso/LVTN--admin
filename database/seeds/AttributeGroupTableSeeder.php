<?php

use Illuminate\Database\Seeder;
use App\AttributeGroup;
class AttributeGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attribute_group')->delete();

        $att_g = [
            ['name'=>'Điện thoại', 'alias' => 'dien-thoai', 'att_name_1' => 'Dung lượng', 'att_name_2' => 'Màu sắc']
        ];

        foreach($att_g as $att){
            AttributeGroup::create($att);
        }
    }
}
