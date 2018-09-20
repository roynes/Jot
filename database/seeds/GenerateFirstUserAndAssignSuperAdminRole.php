<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use App\Models\User;

class GenerateFirstUserAndAssignSuperAdminRole extends Seeder
{
    private $superAdmin;
    private $adminGroup;
    private $adminClient;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables();
        $this->seedRoles();
        $this->seedAdminUsers();
        $this->associateUsersWithAccounts();
        $this->associateToSuperAdmin();

        cache()->forget('spatie.permission.cache');
    }

    /**
     * Assign role to the currently created user
     */
    private function seedRoles(): void
    {
        foreach(config('user_roles') as $role) {
            Role::firstOrCreate([ 'name' => $role ]);
        }
    }

    /**
     * Seeds the first admin users
     */
    private function seedAdminUsers(): void
    {
        $this->superAdmin = User::create([
            'name' => 'superadmin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('secret')
        ]);

        $superAdminEmail = array_get(explode('@',$this->superAdmin->email), 0);

        $this->adminGroup = User::create([
            'name' => $superAdminEmail.'group',
            'email' => $superAdminEmail.'.group@'.$superAdminEmail.'.com',
            'password' => bcrypt('secret')
        ]);

        $this->adminClient = User::create([
            'name' => $superAdminEmail.'client',
            'email' => $superAdminEmail.'.client@'.$superAdminEmail.'.com',
            'password' => bcrypt('secret')
        ]);

        $this->superAdmin->assignRole(Role::findByName(config('user_roles.super_admin')));
        $this->adminGroup->assignRole(Role::findByName(config('user_roles.group_admin')));
        $this->adminClient->assignRole(Role::findByName(config('user_roles.client_admin')));
    }

    private function associateToSuperAdmin()
    {
        $this->superAdmin->associateWith($this->adminGroup);
        $this->superAdmin->associateWith($this->adminClient);

        $this->adminGroup->associateWith($this->superAdmin);
        $this->adminGroup->associateWith($this->adminClient);

        $this->adminClient->associateWith($this->adminGroup);
        $this->adminClient->associateWith($this->superAdmin);
    }

    private function associateUsersWithAccounts()
    {
        $this->superAdmin->account()->create([
            'type' => $this->superAdmin->roles->first()->name
        ]);

        $groupAdminAccount = Account::create([
            'type' => config('user_roles.group_admin')
        ]);

        $clientAdminAccount = Account::create([
            'type' => config('user_roles.client_admin')
        ]);

        $group = factory(\App\Models\Group::class)->create();
        $client = factory(\App\Models\Client::class)->create();

        $groupAdminAccount->assignGroup($group);
        $groupAdminAccount->save();

        $groupAdminAccount->assignUser($this->adminGroup);
        $groupAdminAccount->save();

        $clientAdminAccount->assignClient($client);
        $clientAdminAccount->save();

        $clientAdminAccount->assignUser($this->adminClient);
        $clientAdminAccount->save();
    }

    /**
     * Truncates the table needed for seeding
     */
    public function truncateTables(): void
    {
        $spatieTables = config('permission.table_names');

        Schema::disableForeignKeyConstraints();

        DB::table($spatieTables['roles'])->truncate();
        DB::table($spatieTables['permissions'])->truncate();

        DB::table($spatieTables['model_has_permissions'])->truncate();
        DB::table($spatieTables['model_has_roles'])->truncate();

        DB::table($spatieTables['role_has_permissions'])->truncate();

        DB::table('users')->truncate();
        DB::table('accounts')->truncate();

        Schema::enableForeignKeyConstraints();
    }
}
