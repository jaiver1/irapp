<?php namespace App\Models\Actividad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orden extends Model
{
  use SoftDeletes;

  /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ordenes';

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
    'nombre'
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

}
