<?php namespace App\Models\Comercio;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comercio\Compra;
use App\Models\Comercio\Producto;
use App\Models\Contacto\Proveedor;
use Illuminate\Database\Eloquent\SoftDeletes;


class Detalle_compra extends Model
{
  use SoftDeletes;

  /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detalles_compras';

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
      'compra_id',
      'producto_id',
      'proveedor_id'
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

  public function compra(){
    return $this->belongsTo(Compra::class);
  }


  public function producto()
  {
      return $this->belongsTo(Producto::class);
  }

  public function proveedor()
  {
      return $this->belongsTo(Proveedor::class);
  }

}
