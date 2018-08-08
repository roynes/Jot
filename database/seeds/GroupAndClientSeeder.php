<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Group;

class GroupAndClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables();

        factory(Group::class, 5)->create();
        factory(Client::class, 15)->create();
    }

    private function truncateTables()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('groups')->truncate();
        DB::table('clients')->truncate();
        DB::table('group_user')->truncate();
        DB::table('client_user')->truncate();

        Schema::enableForeignKeyConstraints();
    }
}
