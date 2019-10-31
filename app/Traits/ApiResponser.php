<?php
/**
 * Created by PhpStorm.
 * User: ariel
 * Date: 11/ago/2019
 * Time: 01:18
 */
namespace App\Traits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ApiResponser{
    //encargado de construir respuestas satisfactorias
    //parametros el dato y el codigo de la respuesta
    private function successResponse($data,$code){
        return response()->json($data,$code);


    }

    protected function errorResponse($message,$code){
        return response()->json(['error'=>$message,'code'=>$code],$code);

    }

    //mostrar una respuesta con multiples elementos(una coleccion) por ej lista de usuarios
    protected function showAll(Collection $collection,$code=200){
        if($collection->isEmpty()){
            return $this->successResponse(['data'=>$collection],$code);
        }
        $transformer=$collection->first()->transformer;
        $collection=$this->filterData($collection,$transformer);
        $collection=$this->sortData($collection,$transformer);
        $collection= $this->transformData($collection,$transformer);

        return $this->successResponse($collection,$code);

    }
    protected function showOne(Model $instance,$code=200){
        $transformer=$instance->transformer;
        $instance=$this->transformData($instance,$transformer);
        return $this->successResponse($instance,$code);

    }
    protected function showMessage($message,$code=200){
        return $this->successResponse(['data'=>$message],$code);

    }
    
    public function sortData(Collection $collection,$transformer){
        if(request()->has('sort_by')){
            $attribute=$transformer::originalAttribute(request()->sort_by);
            $collection=$collection->sortBy->{$attribute};


        }
        return $collection;

    }

    //por medio del transformer podemos identificar realmente cual es el atributo por el cual se va a hacer el filtrado
    public function filterData(Collection $collection,$transformer){
        //obtenemos la lista de todos los parametros
            foreach(request()->query as $query=>$value){
                //obtengo el valor original del campo ej esVerificado el original es verified
                $atributte=$transformer::originalAttribute($query);
                //si el atributo y valor no son vacio
                if(isset($atributte,$value)){
                    $collection=$collection->where($atributte,$value);


                }

            }
           
         return $collection;
    }

    protected function transformData($data,$transformer){
        //recibe los datos y como segundo parametro y la instancia del transformador
        $transformation=fractal($data,new $transformer);
        //aca ya tenemos toda la info transformaada
        //convertir la transformacion(instancia de php fractal) a array
        return $transformation->toArray();




    }




}