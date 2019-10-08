<?php

use Illuminate\Database\Seeder;
use App\Group;
class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->delete();

        $groups = [
            ['gr_id'=> 1 , 'description' => 'Quản trị viên'],
            ['gr_id'=> 2, 'description' => 'Nhân viên'],
            ['gr_id'=> 3, 'description' => 'Thành viên'],
        ];

        foreach($groups as $group){
            Group::create($group);
        }
    }
}
