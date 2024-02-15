<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = [
            'Superadmin',
            'Admin',
            'Estandar'
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                [
                    'name' => $role,
                    'guard_name' => $role,
                ]
            );
        }
        $roles = Role::all();
        foreach ($roles as $role) {
            User::updateOrCreate(
                [
                    'email' => Str::lower($role->name) . "@test.com"
                ],
                [
                    'password' => Hash::make(Str::random(8)),
                    'name' => $role
                ]
            );
        }
    }


}
