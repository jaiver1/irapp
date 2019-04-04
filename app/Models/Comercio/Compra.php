<?php namespace App\Models\Comercio;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comercio\Detalle_compra;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compra extends Model
{
  use SoftDeletes;

  /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'compras';

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
    'fecha'
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

  public function detalles(){
    return $this->hasMany(Detalle_compra::class);
  }

}
