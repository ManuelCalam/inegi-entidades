<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole      = Role::firstOrCreate(['name' => 'admin']);
        $capturistaRole = Role::firstOrCreate(['name' => 'capturista']);

        $adminUser = User::firstOrCreate(
            ['email' => 'correo@gmail.com'],
            [
                'name'     => 'Manuel Calam',
                'password' => Hash::make('clave123'),
            ]
        );

        $adminUser->assignRole($adminRole);
    }
}