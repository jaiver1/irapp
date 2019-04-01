<?php namespace App\Models\Clasificacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Comercio\Producto;
use App\Models\Actividad\Servicio;



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


public function categorias(){
  return $this->hasMany(Categoria::class);
}

public function categoria()
{
  return $this->belongsTo(Categoria::class);
}

public function productos(){
  return $this->hasMany(Producto::class);
}

public function servicios(){
  return $this->hasMany(Servicio::class);
}

}
