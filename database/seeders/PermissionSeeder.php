<?php


namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Effacer toutes les roles et les permissions qui esont en caches
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        // Services
        $add = Permission::create(['name' => 'add']);
        $edit = Permission::create(['name' => 'edit']);
        $delete = Permission::create(['name' => 'delete']);
        $view_all = Permission::create(['name' => 'view_all']);
        $view = Permission::create(['name' => 'view']);
        $view = Permission::create(['name' => 'donwload_repport']);
        $view = Permission::create(['name' => 'add_users']);


        // create roles and assign existing permissions
        $root = Role::create(['name' => 'Root']);

        $techniciens = Role::create(['name' => 'technicien']);
        $magasinier = Role::create(['name' => 'magasinier']);
        $magasinier->syncPermissions([$add, $edit, $delete, $view_all, $view]);
        $root->syncPermissions(Permission::all());
    }
}
