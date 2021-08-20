<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        \Illuminate\Support\Facades\DB::table('admins')->delete();

        $users = array(
            ['email' => 'admin', 'password' => 'admin']
        );

        // Loop through each user above and create the record for them in the database
        foreach ($users as $user)
        {
            \App\Models\Admin::create($user);
        }
    }
}
