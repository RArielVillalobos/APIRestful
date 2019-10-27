<?php

namespace App\Transformers;

use App\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            //
            'identificador'=> (int) $category->id,
            'titulo'=> (int) $category->name,
            'detalles'=> (int) $category->description,
            'fechaCreacion'=>(string)$category->created_at,
            'fechaActualizacion'=>(string)$category->updated_at,
            'fechaEliminacion'=>isset($category->delated_at) ? (string) $category->deleted_at : null


        ];
    }
}
