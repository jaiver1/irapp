<?php namespace App\Models\Actividad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Actividad\Orden;
use App\Models\Contacto\Colaborador;

class Detalle_orden extends Model
{
  use SoftDeletes;


  /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detalles_ordenes';

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
      'orden_id',
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
      'updated_at',
      'deleted_at',
  ];

  protected $dates = [
      'created_at',
      'updated_at',
      'deleted_at',
  ];

  public function orden(){
    return $this->belongTo(Orden::class);
  }

  public function colaborador()
  {
      return $this->belongsTo(Colaborador::class);
  }

}
