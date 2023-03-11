<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('tasks')->insert([
        'due_date'=>'2099-06-28 23:59:59',
        'title'=>'Buy eggs',
        'description'=>'The brown ones, not purple!',
        'parent_folder'=>null,
        'parent_user'=>1,
        'is_completed'=>false
      ]);

      DB::table('tasks')->insert([
        'due_date'=>null,
        'title'=>'Buy notes',
        'description'=>null,
        'parent_folder'=>1,
        'parent_user'=>1,
        'is_completed'=>true
      ]);
    }
}
