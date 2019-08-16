<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $usuarios=User::all();
        //es bueno estandarizxar la respuesta, osea que sea una response, json y tener un elemento raiz que ene ste caso generalmente es un data
        return $this->showAll($usuarios);

    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //regla validacion
        $rules=[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed',

        ];
        $this->validate($request,$rules);
        

        $campos=$request->all();
        $campos['password']=bcrypt($request->password);
        $campos['verified']=User::USUARIO_NO_VERIFICADO;
        $campos['verification_token']=User::generarVerificationToken();
        $campos['admin']=User::USUARIO_REGULAR;



        //create hace una asignacion masiva
        $usuario=User::create($campos);
        return $this->showOne($usuario,201);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        //$user=User::findOrFail($id);

        return $this->showOne($user);

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
        //$user=User::findOrFail($id);
        //regla validacion
        $rules=[
            //como el email es unico , al actualizar el email de usuario daria error, entonces debemos hacer la excepcion del usuario autenticado
            //validacion del campo email de tabla users exceptuando el usuario actual
            'email'=>'email|unique:users,email,'.$user->id,
            'password'=>'min:6|confirmed',
            //que este entre los valores de usuario administrador(true) y usuario regular(false)
            'admin'=>'in:'.User::USUARIO_ADMINISTRADOR.','.User::USUARIO_REGULAR
            

        ];
        $this->validate($request,$rules);
        if($request->has('name')){
            $user->name=$request->name;
        }

        if($request->has('email') && $user->email!=$request->email){
            if($user->email!=$request->email){
                $user->email=$request->email;
                $user->verified=User::USUARIO_NO_VERIFICADO;
                $user->verification_token=User::generarVerificationToken();   
            }

        }
        if($request->has('password')){
            $user->password=bcrypt($request->password);
        }

        if($request->has('admin')){
            //si el usuario no es verificado
            if(!$user->esVerificado()){
                //el codigo 409 significa que hubo un conflicto
                return $this->errorResponse('Unicamente los usuarios verificados pueden cambiar su valor a administrador',409);

            }
            $user->admin=$request->admin;

        }
        
        // isdirty verirfica si una propiedad al menos fue cambiada
        //si el usuario no cambio
        //422 peticion mal formada
        if(!$user->isDirty()){
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',422);
        }
        $user->save();
        return response()->json(['data'=>$user],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        //$user=User::findOrFail($id);
        $user->delete();
        return response()->json(['data'=>$user],200);
    }
}
