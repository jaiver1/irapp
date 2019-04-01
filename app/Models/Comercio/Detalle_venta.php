<?php namespace App\Models\Comercio;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comercio\Venta;
use App\Models\Comercio\Producto;
use Illuminate\Database\Eloquent\SoftDeletes;


class Detalle_venta extends Model
{
  use SoftDeletes;

  /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detalles_ventas';

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
      'valor_unitario',
      'cantidad',
      'venta_id',
      'producto_id'
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

  public function venta(){
    return $this->belongsTo(Venta::class);
  }


  public function producto()
  {
      return $this->belongsTo(Producto::class);
  }

}
