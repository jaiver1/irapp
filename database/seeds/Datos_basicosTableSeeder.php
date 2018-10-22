<?php

use Illuminate\Database\Seeder;

use App\Models\Dato_basico\Medida;
use App\Models\Dato_basico\Tipo_medida;
use App\Models\Dato_basico\XPais;
use App\Models\Dato_basico\XDepartamento;
use App\Models\Dato_basico\XCiudad;
use App\Models\Dato_basico\XTipo_referencia;
class Datos_basicosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $tipo_medida = new Tipo_medida;
        $tipo_medida->nombre = 'Cantidad';
        $tipo_medida->save();

        $medida = new Medida;
        $medida->nombre = 'Unidades';
        $medida->etiqueta = 'uni';
        $medida->tipo_medida()->associate($tipo_medida);
        $medida->save();

        $medida = new Medida;
        $medida->nombre = 'Docenas';
        $medida->etiqueta = 'doc';
        $medida->tipo_medida()->associate($tipo_medida);
        $medida->save();

        $tipo_medida = new Tipo_medida;
        $tipo_medida->nombre = 'Longitud';
        $tipo_medida->save();

        $medida = new Medida;
        $medida->nombre = 'Metro';
        $medida->etiqueta = 'm';
        $medida->tipo_medida()->associate($tipo_medida);
        $medida->save();

        $medida = new Medida;
        $medida->nombre = 'Milimetros';
        $medida->etiqueta = 'mm';
        $medida->tipo_medida()->associate($tipo_medida);
        $medida->save();

        $tipo_medida = new Tipo_medida;
        $tipo_medida->nombre = 'Area';
        $tipo_medida->save();

        $medida = new Medida;
        $medida->nombre = 'Metro Cuadrado';
        $medida->etiqueta = 'm²';
        $medida->tipo_medida()->associate($tipo_medida);
        $medida->save();

        $tipo_medida = new Tipo_medida;
        $tipo_medida->nombre = 'Peso';
        $tipo_medida->save();

        $medida = new Medida;
        $medida->nombre = 'Libras';
        $medida->etiqueta = 'lb';
        $medida->tipo_medida()->associate($tipo_medida);
        $medida->save();

        $medida = new Medida;
        $medida->nombre = 'Kilogramo';
        $medida->etiqueta = 'Kg';
        $medida->tipo_medida()->associate($tipo_medida);
        $medida->save();

        $medida = new Medida;
        $medida->nombre = 'Gramo';
        $medida->etiqueta = 'g';
        $medida->tipo_medida()->associate($tipo_medida);
        $medida->save();

        $tipo_medida = new Tipo_medida;
        $tipo_medida->nombre = 'Volumen';
        $tipo_medida->save();

        $medida = new Medida;
        $medida->nombre = 'Mililitros';
        $medida->etiqueta = 'ml';
        $medida->tipo_medida()->associate($tipo_medida);
        $medida->save();

        $medida = new Medida;
        $medida->nombre = 'Litros';
        $medida->etiqueta = 'l';
        $medida->tipo_medida()->associate($tipo_medida);
        $medida->save();

        $medida = new Medida;
        $medida->nombre = 'Centimetros Cubicos';
        $medida->etiqueta = 'cm³';
        $medida->tipo_medida()->associate($tipo_medida);
        $medida->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'C39';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'C39+';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'C39E';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'C39E+';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'C93';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'S25';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'S25+';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'I25';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'I25+';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'C128';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'C128A';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'C128B';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'C128C';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'EAN2';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'EAN5';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'EAN8';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'EAN13';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'UPCA';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'UPCE';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'MSI';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'MSI+';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'POSTNET';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'PLANET';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'RMS4CC';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'KIX';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'IMB';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'CODABAR';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'CODE11';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'PHARMA';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'PHARMA2T';
        $tipo_referencia->dimension = '1D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'QRCODE';
        $tipo_referencia->dimension = '2D';
        $tipo_referencia->save();
        
        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'PDF417';
        $tipo_referencia->dimension = '2D';
        $tipo_referencia->save();

        $tipo_referencia = new XTipo_referencia;
        $tipo_referencia->nombre = 'DATAMATRIX';
        $tipo_referencia->dimension = '2D';
        $tipo_referencia->save();

        $pais = new XPais;
        $pais->nombre = 'Colombia';
        $pais->save();

        $departamento = new XDepartamento;
        $departamento->nombre = 'Valle del cauca';
        $departamento->pais()->associate($pais);       
        $departamento->save();

        $ciudad = new XCiudad;
        $ciudad->nombre = 'Cali';
        $ciudad->departamento()->associate($departamento);       
        $ciudad->save();

        $ciudad = new XCiudad;
        $ciudad->nombre = 'Palmira';
        $ciudad->departamento()->associate($departamento);       
        $ciudad->save();


        $ciudad = new XCiudad;
        $ciudad->nombre = 'Cerrito';
        $ciudad->departamento()->associate($departamento);       
        $ciudad->save();


        $ciudad = new XCiudad;
        $ciudad->nombre = 'Pradera';
        $ciudad->departamento()->associate($departamento);       
        $ciudad->save();

        $ciudad = new XCiudad;
        $ciudad->nombre = 'Amaime';
        $ciudad->departamento()->associate($departamento);       
        $ciudad->save();

        $ciudad = new XCiudad;
        $ciudad->nombre = 'Guacari';
        $ciudad->departamento()->associate($departamento);       
        $ciudad->save();

        $ciudad = new XCiudad;
        $ciudad->nombre = 'Jamundi';
        $ciudad->departamento()->associate($departamento);       
        $ciudad->save();


        $ciudad = new XCiudad;
        $ciudad->nombre = 'Tulua';
        $ciudad->departamento()->associate($departamento);       
        $ciudad->save();


        $ciudad = new XCiudad;
        $ciudad->nombre = 'Buga';
        $ciudad->departamento()->associate($departamento);       
        $ciudad->save();
        
    }
}
