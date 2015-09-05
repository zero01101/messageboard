<?php

use Illuminate\Database\Seeder;

class SeedMsgboardsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('messageboards')->insert([
            1 => [
                'title' => 'default'
            ]
        ]);
    }
}
