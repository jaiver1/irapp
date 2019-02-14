<?php

namespace App\Models\Root;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Models\Contacto\Persona;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use EntrustUserTrait { restore as private restoreA; }
    use SoftDeletes { restore as private restoreB; }
 /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

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
        'name',
        'email',
        'password',
        'imagen',
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
        'email_verified_at',
        'password',
        'remember_token',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'email_verified_at',
    ];

    protected $hashable = ['password'];

    public function restore()
{
    $this->restoreA();
    $this->restoreB();
}

public function entrustPasswordHash() 
    {
        $this->password = Hash::make($this->password);
        $this->save();
    }

    public function authorizeRoles($roles,$abort)
    
    {
    
      if (is_array($roles)) {
        if ($abort) {
          return $this->hasAnyRole($roles) || 
                 abort(401, 'No esta autorizado.');
        }else{
            return $this->hasAnyRole($roles);
        }
      }

      if ($abort) {
      return $this->hasRole($roles) || 
             abort(401, 'No esta autorizado.');
      }else{
        return $this->hasRole($roles);
      }
    }
    
    /**
    
    * Check multiple roles
    
    * @param array $roles
    
    */
    
    public function hasAnyRole($roles)
    
    {
    
      return null !== $this->roles()->whereIn('name', $roles)->first();
    
    }
    
    /**
    
    * Check one role
    
    * @param string $role
    
    */
    
    public function hasRole($role)
    
    {
    
      return null !== $this->roles()->where('name', $role)->first();
    
    }

    public function getPersona()
    
    {
      $persona = Persona::where('usuario_id','=',$this->id)->first();
      return ($persona) ? $persona : new Persona;
    
    }

    public function getCliente()
    
    {
        $persona = getPersona();
      $cliente = Cliente::where('persona_id','=',$persona->id)->first();
      return ($cliente) ? $cliente : new Cliente;
    }

    public function getColaborador()
    
    {
        $persona = getPersona();
      $colaborador = Colaborador::where('persona_id','=',$persona->id)->first();
      return ($colaborador) ? $colaborador : new Colaborador;
    }

}
