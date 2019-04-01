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
        $especialidad->nombre = 'Electrohogar';
        $especialidad->save();

        $categoria = new Categoria;
        $categoria->nombre = 'Soportes De Tv';
        $categoria->especialidad()->associate($especialidad);
        $categoria->save();

        $especialidad = new Especialidad;
        $especialidad->nombre = 'Cocina';
        $especialidad->save();


        $categoria = new Categoria;
        $categoria->nombre = 'Muebles De Cocina';
        $categoria->especialidad()->associate($especialidad);
        $categoria->save();
        
        $categoria = new Categoria;
        $categoria->nombre = 'Accesorios De Cocina';
        $categoria->especialidad()->associate($especialidad);
        $categoria->save();


        $especialidad = new Especialidad;
        $especialidad->nombre = 'Baños';
        $especialidad->save();
        
        $categoria = new Categoria;
        $categoria->nombre = 'Muebles De Baño';
        $categoria->especialidad()->associate($especialidad);
        $categoria->save();
        
        $categoria = new Categoria;
        $categoria->nombre = 'Duchas';
        $categoria->especialidad()->associate($especialidad);
        $categoria->save();

        $especialidad = new Especialidad;
        $especialidad->nombre = 'Muebles Y Decoración';
        $especialidad->save();

        $categoria = new Categoria;
        $categoria->nombre = 'Muebles De Hogar';
        $categoria->especialidad()->associate($especialidad);
        $categoria->save(); 
    }
}
