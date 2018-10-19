<?php namespace App\Models\Dato_basico;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medida extends Model
{
  use SoftDeletes;

  /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'medidas';

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
    'etiqueta',
    'tipo_medida_id'
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


public function tipo_medida()
{
    return $this->belongsTo('App\Models\Dato_basico\Tipo_medida');
}

public function productos(){
  return $this->hasMany('App\Models\Comercio\Producto');
}

public function servicios(){
  return $this->hasMany('App\Models\Actividad\Servicio');
}
}
