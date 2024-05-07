<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Usuario::create([
            'nombre' => 'Jonathan',
            'apellido' => 'Moran',
            'usuario' => 'jonathan',
            'password' => bcrypt('1234'),
            'telefono' => '75',
            'dui' => '00',
        ])->assignRole('admin');
    }
}
