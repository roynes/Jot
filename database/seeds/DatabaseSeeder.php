<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GenerateFirstUserAndAssignSuperAdminRole::class);
        $this->call(GroupAndClientSeeder::class);
        $this->call(StateSeeder::class);
    }
}
