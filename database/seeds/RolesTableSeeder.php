<?php

use Illuminate\Database\Seeder;
use App\Models\Root\Role;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_root = new Role;
        $role_root->name = 'ROLE_ROOT';
        $role_root->display_name = 'Root';
        $role_root->description = 'Usuario que se encarga de administrar usuarios, permisos y roles.';
        $role_root->save();
    
        $role_administrador = new Role;
        $role_administrador->name = 'ROLE_ADMINISTRADOR';
        $role_administrador->display_name = 'Administrador';
        $role_administrador->description = 'Usuario que puede administrar clientes y asignar ordenes de servicio.';
        $role_administrador->save();

        $role_colaborador = new Role;
        $role_colaborador->name = 'ROLE_COLABORADOR';
        $role_colaborador->display_name = 'Colaborador';
        $role_colaborador->description = 'Usuario que unicamente puede ver ordenes de servicio.';
        $role_colaborador->save();

        $role_cliente = new Role;
        $role_cliente->name = 'ROLE_CLIENTE';
        $role_cliente->display_name = 'Cliente';
        $role_cliente->description = 'Usuario que unicamente puede solicitar y cotizar ordenes de servicio.';
        $role_cliente->save();
    }
}
