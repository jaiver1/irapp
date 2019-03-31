<?php namespace App\Models\Actividad;

use Illuminate\Database\Eloquent\Model;
use App\Models\Contacto\Cliente;
use App\Models\Actividad\Detalle_solicitud;
use App\Models\Dato_basico\Direccion;
Use DB;

class Solicitud extends Model
{

  /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'solicitudes';

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
    'direccion_id',
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
      'updated_at'
  ];

  protected $dates = [
      'created_at',
      'updated_at'
  ];

  public static function getEstados()
{
  $type = DB::select( DB::raw("SHOW COLUMNS FROM solicitudes WHERE Field = 'estado'") )[0]->Type;
  preg_match('/^enum\((.*)\)$/', $type, $matches);
  $enum = array();
  foreach( explode(',', $matches[1]) as $value )
  {
    $v = trim( $value, "'" );
    $enum = array_add($enum, $v, $v);
  }
  return $enum;
}

public function direccion()
{
    return $this->belongsTo(Direccion::class);
}
  
  public function cliente()
  {
    return $this->belongsTo(Cliente::class);
  }

  public function detalles(){
    return $this->hasMany(Detalle_solicitud::class);
  }

}
