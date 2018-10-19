<?php namespace App\Models\Dato_basico;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class X_Departamento extends Model
{
  use SoftDeletes;


  /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'departamentos';

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
    'pais_id'
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


  public function ciudades(){
    return $this->hasMany('App\Models\Dato_basico\X_Ciudad');
  }
  
  public function pais()
{
    return $this->belongsTo('App\Models\Dato_basico\X_Pais');
}
}
