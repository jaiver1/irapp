<?php namespace App\Models\Actividad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Clasificacion\Categoria;
use App\Models\Dato_basico\Medida;
use App\Models\Contacto\Colaborador;
use App\Models\Actividad\Imagen_servicio;
use App\Models\Actividad\Calificacion_servicio;

class Servicio extends Model
{
  use SoftDeletes;

  /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'servicios';

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
    'descripcion',
    'valor_unitario',
    'medida_id',
    'categoria_id',
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

 public function categoria()
{
    return $this->belongsTo(Categoria::class);
}

public function medida()
{
    return $this->belongsTo(Medida::class);
}
  public function colaboradores()
  {
      return $this->belongsToMany(Colaborador::class);
  }

  public function imagenes(){
    return $this->hasMany(Imagen_servicio::class);
  }

  public function calificaciones(){
    return $this->hasMany(Calificacion_servicio::class);
  }
}
