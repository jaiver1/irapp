<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsuariosTableSeeder::class);
        $this->call(Datos_basicosTableSeeder::class);
        $this->call(ClasificacionesTableSeeder::class);
        $this->call(ComerciosTableSeeder::class);
    }
}
