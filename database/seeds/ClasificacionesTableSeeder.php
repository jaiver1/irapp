<?php

use Illuminate\Database\Seeder;
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
        $categoria = new Categoria;
        $categoria->nombre = 'Sin Clasificación';
        $categoria->save();

        $categoria = new Categoria;
        $categoria->nombre = 'Electrohogar';
        $categoria->save();

        $sub = new Categoria;
        $sub->nombre = 'Soportes De Tv';
        $sub->categoria()->associate($categoria);
        $sub->save();

        $categoria = new Categoria;
        $categoria->nombre = 'Cocina';
        $categoria->save();


        $sub = new Categoria;
        $sub->nombre = 'Muebles De Cocina';
        $sub->categoria()->associate($categoria);
        $sub->save();
        
        $sub = new Categoria;
        $sub->nombre = 'Accesorios De Cocina';
        $sub->categoria()->associate($categoria);
        $sub->save();


        $categoria = new Categoria;
        $categoria->nombre = 'Baños';
        $categoria->save();
        
        $sub = new Categoria;
        $sub->nombre = 'Muebles De Baño';
        $sub->categoria()->associate($categoria);
        $sub->save();
        
        $sub = new Categoria;
        $sub->nombre = 'Duchas';
        $sub->categoria()->associate($categoria);
        $sub->save();

        $categoria = new Categoria;
        $categoria->nombre = 'Muebles Y Decoración';
        $categoria->save();

        $sub = new Categoria;
        $sub->nombre = 'Muebles De Hogar';
        $sub->categoria()->associate($categoria);
        $sub->save(); 
    }
}
