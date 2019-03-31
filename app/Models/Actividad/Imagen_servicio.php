<?php namespace App\Models\Actividad;

use Illuminate\Database\Eloquent\Model;
use App\Models\Actividad\Servicio;

class Imagen_servicio extends Model
{

  /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'imagenes_servicios';

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
    'ruta',
    'servicio_id',
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

  public function servicio(){
    return $this->belongsTo(Servicio::class);
  }
  
}
