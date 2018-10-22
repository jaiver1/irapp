<?php

use Illuminate\Database\Seeder;
use App\Models\Comercio\Marca;
class ComerciosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $marca = new Marca;
        $marca->nombre = 'Generico';
        $marca->save();

        $marca = new Marca;
        $marca->nombre = 'Produccion Propia';
        $marca->save();

        $marca = new Marca;
        $marca->nombre = 'Genius';
        $marca->save();
        
        $marca = new Marca;
        $marca->nombre = 'Adidas';
        $marca->save();

        $marca = new Marca;
        $marca->nombre = 'Nestle';
        $marca->save();

        $marca = new Marca;
        $marca->nombre = 'Faber Castle';
        $marca->save();
    }
}
