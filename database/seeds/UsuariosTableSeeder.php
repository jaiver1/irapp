<?php

use Illuminate\Database\Seeder;
use App\Models\Root\User;
use App\Models\Root\Role;
use Carbon\Carbon;
class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_root  = Role::where('name', 'ROLE_ROOT')->first();
        $role_administrador = Role::where('name', 'ROLE_ADMINISTRADOR')->first();
        $role_colaborador = Role::where('name', 'ROLE_COLABORADOR')->first();  
        $role_cliente = Role::where('name', 'ROLE_CLIENTE')->first();    
    
        $root = new User;
        $root->name = 'Root';
        $root->email = 'root@example.com';
        $root->email_verified_at = Carbon::now();
        $root->password = bcrypt('root1234');
        $root->save();
        $root->roles()->attach($role_root);

        $administrador = new User;
        $administrador->name = 'Administrador';
        $administrador->email = 'administrador@example.com';
        $root->email_verified_at = Carbon::now();
        $administrador->password = bcrypt('administrador');
        $administrador->save();
        $administrador->roles()->attach($role_administrador);
/*
        $colaborador = new User;
        $colaborador->name = 'Colaborador';
        $colaborador->email = 'colaborador@example.com';
        $colaborador->password = bcrypt('colaborador');
        $colaborador->save();
        $colaborador->roles()->attach($role_colaborador);

        $cliente = new User;
        $cliente->name = 'Cliente #1';
        $cliente->email = 'cliente@example.com';
        $cliente->password = bcrypt('cliente');
        $cliente->save();
        $cliente->roles()->attach($role_cliente);
*/

    }
}
