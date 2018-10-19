<?php

namespace App\Models\Contacto;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
 
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'personas';

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
        'cedula',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'telefono_fijo',
        'telefono_movil',
        'ciudad_id',
        'ubicacion_id',
        'barrio',
        'direccion',
        'cuenta_banco',
        'usuario_id',
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

    public function ubicacion()
    {
        return $this->belongsTo('App\Models\Dato_basico\X_Ubicacion');
    }

    public function ciudad()
    {
        return $this->belongsTo('App\Models\Dato_basico\X_Ciudad');
    }
    
}
