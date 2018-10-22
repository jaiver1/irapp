<?php

use Illuminate\Database\Seeder;
use App\Models\Clasificacion\Especialidad;
use App\Models\Clasificacion\Categoria;
class ClasificacionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $especialidad = new Especialidad;
        $especialidad->nombre = 'Sin Clasificación';
        $especialidad->save();

        $especialidad = new Especialidad;
        $especialidad->nombre = 'Tecnologia';
        $especialidad->save();

        $categoria = new Categoria;
        $categoria->nombre = 'Electronicos';
        $categoria->especialidad()->associate($especialidad);
        $categoria->save();

        $sub_categoria = new Categoria;
        $sub_categoria->nombre = 'Electrodomesticos';
        $sub_categoria->especialidad()->associate($especialidad);
        $sub_categoria->categoria()->associate($categoria);
        $sub_categoria->save();

        $sub_categoria = new Categoria;
        $sub_categoria->nombre = 'Entretenimiento';
        $sub_categoria->especialidad()->associate($especialidad);
        $sub_categoria->categoria()->associate($categoria);
        $sub_categoria->save();

        $sub_categoria2 = new Categoria;
        $sub_categoria2->nombre = 'Televisores';
        $sub_categoria2->especialidad()->associate($especialidad);
        $sub_categoria2->categoria()->associate($sub_categoria);
        $sub_categoria2->save(); 
    }
}
