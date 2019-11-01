<?php
/**
 * Created by PhpStorm.
 * User: ariel
 * Date: 11/ago/2019
 * Time: 01:18
 */
namespace App\Traits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

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
        $collection=$this->paginate($collection);
        $collection= $this->transformData($collection,$transformer);
        $collection= $this->cacheResponse($collection);

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
    
    protected function paginate(Collection $collection){
        $rules=[
            'per_page'=>'integer|min:2|max:50',
            ''
        ];
        Validator::validate(request()->all(),$rules);
        //aca conocemos la pagina en cual estamos
        $pageActual=LengthAwarePaginator::resolveCurrentPage();
        $perPage=15;
        if(request()->has('per_page')){
            $perPage=(int) request()->per_page;

        }
        //dividir la coleccion dependiendo del tamaño de la pagina
        //ej si estamos en la 2 debemos mostrar de la 16 a 30
        $results=$collection->slice(($pageActual-1)*$perPage,$perPage)->values();
        //crear instancia paginador
        $paginated=new LengthAwarePaginator($results,$collection->count(),$perPage,$pageActual,[
            'path'=>LengthAwarePaginator::resolveCurrentPath()
        ]);
        //tenemos que tener en cuenta que la generacion de esta ruta, automaticamente elimina los parametros d url q van alli
        //por ej si enviamos el num d pagina+que queremos ordenar los elementos, lo ultimo se eliminara
        //para resolver esto debbemos pedirle a los resultados paginados que agregue la lista de todos los parametros q podamos tener

        $paginated->appends(request()->all());

        return $paginated;


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

    protected function cacheResponse($data){
        //necesitamos la url actual
        $url=request()->url();
        //la url es para identificar de manera unica la peticion con otra
        //el 2do param es el tiempo, si queremos 30 segundos lo dividimos por 60 que es un minuto
        return Cache::remember($url,30/60,function() use ($data){
            return $data;

        });


    }




}