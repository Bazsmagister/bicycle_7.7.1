<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('roles')->insert([
        //     ['name' => 'admin'],
        //     ['name' => 'serviceman'],
        //     ['name' => 'salesman'],
        //     ['name' => 'customer'],
        //     ]);


        DB::table('roles')->insert(array(
            'name' => 'admin',
            'name' => 'serviceman',
            'name' => 'salesman',
            'name' => 'customer'
            ));
    }
}
