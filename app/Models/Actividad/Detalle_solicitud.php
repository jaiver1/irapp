<?php namespace App\Models\Actividad;

use Illuminate\Database\Eloquent\Model;
use App\Models\Actividad\Orden;
use App\Models\Actividad\Servicio;
use App\Models\Contacto\Colaborador;

class Detalle_solicitud extends Model
{


  /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detalles_solicitudes';

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
      'valor_unitario',
      'cantidad',
      'solicitud_id',
      'servicio_id',  
      'colaborador_id'
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

  public function solicitud(){
    return $this->belongsTo(Solicitud::class);
  }

  public function colaborador()
  {
      return $this->belongsTo(Colaborador::class);
  }

  public function servicio()
  {
      return $this->belongsTo(Servicio::class);
  }

}
