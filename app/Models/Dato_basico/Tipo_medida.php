<?php namespace App\Models\Dato_basico;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipo_medida extends Model
{
  use SoftDeletes;


  /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tipos_medidas';

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


  public function medidas(){
    return $this->hasMany('App\Models\Dato_basico\Medida');
}
}
