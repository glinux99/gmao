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
        $inventories = Permission::create(['name' => 'inventories']);
        $sorties = Permission::create(['name' => 'sorties']);
        $entries = Permission::create(['name' => 'entries']);
        $categories = Permission::create(['name' => 'categories']);
        $unities = Permission::create(['name' => 'unities']);
        $projets = Permission::create(['name' => 'projects']);
        $teams = Permission::create(['name' => 'teams']);
        $techniciens = Permission::create(['name' => 'techniciens']);
        $maintenances = Permission::create(['name' => 'maintenances']);
        $calendar = Permission::create(['name' => 'calendar']);
        $equipment = Permission::create(['name' => 'equipment']);
        $users = Permission::create(['name' => 'users']);
        $repports = Permission::create(['name' => 'repports']);
        $priority = Permission::create(['name' => 'priority']);
        $tasks = Permission::create(['name' => 'tasks']);
        $tasksGraph = Permission::create(['name' => 'tasksGraph']);
        $buget = Permission::create(['name' => 'buget']);



        // create roles and assign existing permissions
        $root = Role::create(['name' => 'Root']);
        $techniciens = Role::create(['name' => 'technicien']);
        $magasinier = Role::create(['name' => 'magasinier']);
        $techniciens->syncPermissions([$sorties,$teams, $tasksGraph, $tasks, $calendar, $equipment, $users]);
        $magasinier->syncPermissions([$add, $edit, $delete, $view_all, $view, $inventories, $sorties, $entries, $categories, $unities, $projets, $teams, $techniciens, $maintenances, $calendar, $equipment, $users, $repports, $priority, $buget]);
        $root->syncPermissions(Permission::all());
    }
}
