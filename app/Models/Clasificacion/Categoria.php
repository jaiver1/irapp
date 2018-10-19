<?php namespace App\Models\Clasificacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
  use SoftDeletes;

  /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categorias';

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
    'especialidad_id',
    'categoria_id'
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


public function especialidad()
{
    return $this->belongsTo('App\Models\Clasificacion\Especialidad');
}

public function categorias(){
  return $this->hasMany('App\Models\Clasificacion\Categoria');
}

public function categoria()
{
  return $this->belongsTo('App\Models\Clasificacion\Categoria');
}

public function productos(){
  return $this->hasMany('App\Models\Comercio\Producto');
}

public function servicios(){
  return $this->hasMany('App\Models\Actividad\Servicio');
}

}
