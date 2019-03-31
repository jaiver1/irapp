<?php namespace App\Models\Comercio;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comercio\Producto;

class Imagen_producto extends Model
{

  /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'imagenes_productos';

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
    'ruta',
    'producto_id',
  ];

   /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'created_at',
      'updated_at'
  ];

  protected $dates = [
      'created_at',
      'updated_at'
  ];

  public function producto(){
    return $this->belongsTo(Producto::class);
  }
  
}
