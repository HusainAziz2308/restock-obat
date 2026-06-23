<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use \Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $owner = Role::firstOrCreate(['name' => 'Owner']);
        $manager = Role::firstOrCreate(['name' => 'Manager']);
        $apoteker = Role::firstOrCreate(['name' => 'Apoteker']);
        $pegawai = Role::firstOrCreate(['name' => 'Pegawai']);
    }
}
