<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // Seed the database with predefined roles and permissions for the application, ensuring that the necessary permissions are created and assigned to the appropriate roles.
    public function run(): void
    {
        //
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::firstOrCreate([ 'name' => 'manage categories']);
        Permission::firstOrCreate([ 'name' => 'delete categories']);
        Permission::firstOrCreate(['name' => 'manage tags']);
        Permission::firstOrCreate(['name' => 'delete tags']);
        Permission::firstOrCreate(['name' => 'manage articles']);
        Permission::firstOrCreate(['name' => 'publish articles']);
        Permission::firstOrCreate(['name' => 'view articles']);
        Permission::firstOrCreate(['name' => 'delete articles']);
        Permission::firstOrCreate(['name' => 'moderate comments']);
        Permission::firstOrCreate(['name' => 'manage users']);
        Permission::firstOrCreate(['name' => 'delete users']);
        Permission::firstOrCreate(['name' => 'review feedback']);
        Permission::firstOrCreate(['name' => 'delete feedback']);
        Permission::firstOrCreate(['name' => 'manage revisions']);
        Permission::firstOrCreate(['name' => 'export articles']);
        Permission::firstOrCreate(['name' => 'create backup']);
        $admin = Role::firstOrCreate([ 'name' => 'Admin']);
        $editor = Role::firstOrCreate([ 'name' => 'Editor']);
        $author = Role::firstOrCreate(['name' => 'Author']);
        $reader = Role::firstOrCreate(['name' => 'Reader']);

        $admin->givePermissionTo(Permission::all());
        $editor->givePermissionTo(['manage categories','manage tags','manage articles','delete articles','publish articles','view articles','moderate comments','review feedback','manage revisions','export articles']);
        $author->givePermissionTo(['manage articles','delete articles','view articles','publish articles','manage revisions','export articles','review feedback']);
        $reader->givePermissionTo([
           'view articles'
        ]);

    }
}
