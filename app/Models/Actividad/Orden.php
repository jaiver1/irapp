<?php namespace App\Models\Actividad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Contacto\Cliente;
use App\Models\Actividad\Detalle_orden;
use App\Models\Dato_basico\XUbicacion;
use App\Models\Dato_basico\XCiudad;
Use DB;

class Orden extends Model
{
  use SoftDeletes;

  /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ordenes';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
  protected $fillable = [
    'nombre',
    'estado',
    'fecha_inicio',
    'fecha_fin',
    'barrio',
    'direccion',
    'ciudad_id',  
    'ubicacion_id',
    'cliente_id' 
  ];

   /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'created_at',
      'updated_at',
      'deleted_at',
  ];

  protected $dates = [
      'created_at',
      'updated_at',
      'deleted_at',
  ];

  public static function getEstados()
{
  $type = DB::select( DB::raw("SHOW COLUMNS FROM ordenes WHERE Field = 'estado'") )[0]->Type;
  preg_match('/^enum\((.*)\)$/', $type, $matches);
  $enum = array();
  foreach( explode(',', $matches[1]) as $value )
  {
    $v = trim( $value, "'" );
    $enum = array_add($enum, $v, $v);
  }
  return $enum;
}

public function ubicacion()
{
    return $this->belongsTo(XUbicacion::class);
}

public function ciudad()
{
    return $this->belongsTo(XCiudad::class);
}
  
  public function cliente()
  {
    return $this->belongsTo(Cliente::class);
  }

  public function detalles(){
    return $this->hasMany(Detalle_orden::class);
  }

}
