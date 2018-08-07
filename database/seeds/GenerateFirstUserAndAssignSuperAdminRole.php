<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class GenerateFirstUserAndAssignSuperAdminRole extends Seeder
{
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
        $superAdmin = User::create([
            'name' => 'superadmin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('secret')
        ]);

        $superAdminEmail = array_get(explode('@',$superAdmin->email), 0);

        $adminGroup = User::create([
            'name' => $superAdminEmail.'group',
            'email' => $superAdminEmail.'.group@'.$superAdminEmail.'.com',
            'password' => bcrypt('secret')
        ]);

        $adminClient = User::create([
            'name' => $superAdminEmail.'client',
            'email' => $superAdminEmail.'.client@'.$superAdminEmail.'.com',
            'password' => bcrypt('secret')
        ]);

        $superAdmin->assignRole(Role::findByName(config('user_roles.super_admin')));
        $adminGroup->assignRole(Role::findByName(config('user_roles.group_admin')));
        $adminClient->assignRole(Role::findByName(config('user_roles.client_admin')));
    }

    private function associateToSuperAdmin()
    {
        $superAdmin = User::find(1);
        $adminGroup = User::find(2);
        $adminClient = User::find(3);

        $superAdmin->associateWith($adminGroup);
        $superAdmin->associateWith($adminClient);
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

        Schema::enableForeignKeyConstraints();
    }
}
