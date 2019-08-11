<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //luego veremos porque es bueno usar string en vez de boleanos
    const USUARIO_VERIFICADO='1';
    const USUARIO_NO_VERIFICADO='0';

    const USUARIO_ADMINISTRADOR='true';
    const USUARIO_REGULAR='false';

    //como buyer y seller heredan de users, al cambiar esta propiedad en user, tambien la heredaremos en los otros modelos que heredan de user
    protected $table='users';


    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','verified','verification_token','admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /* oculta estos atributos cuando se convierte en un array de datos qque luego se luego lo convierte en json*/
    protected $hidden = [
        'password', 'remember_token','verification_token'
    ];

    //definiendo un mutador para el nombre(modificar el valor antes de insertar)
    //ahora al insertar el nombre ya se insertara en minuscula, no hace falta llamar al metodo
    public function setNameAttribute($attribute){
        //guardaremos el nombre en minuscula
        $this->attributes['name']=strtolower($attribute);
    }
    //definiendo un accesor para el nombre
    //ahora al retornar el nombre ya se mostrara la primera letra en mayuscula, no hace falta llamar al metodo
    public function getNameAttribute($attribute){
        // si queremos que cada palabra salga en mayuscula podemos usar ucwords
        //ej Ariel Villalobos
        return ucwords($attribute);
    }

    //definiendo un mutador para el email(modificar el valor antes de insertar)
    public function setEmailAttribute($attribute){
        $this->attributes['email']=strtolower($attribute);
    }



    //retorna true si el usuario esta verificado
    public function esVerificado(){
        return $this->verified==User::USUARIO_VERIFICADO;
    }

    //retorna true si el usuario es admin
    public function esAdministrador(){
        return $this->admin==User::USUARIO_VERIFICADO;
    }

    //es estatico porque no es necesario instanciar la clase para acceder a el
    public static function generarVerificationToken(){
        return str_random(40);
    }

}
