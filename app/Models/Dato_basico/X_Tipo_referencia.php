<?php namespace App\Models\Dato_basico;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class X_Tipo_referencia extends Model
{
  use SoftDeletes;


  /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tipos_referencias';

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
    'dimension',
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

  public function productos(){
    return $this->hasMany('App\Models\Comercio\Producto');
  }

}
