<?php
/**
 * Created by PhpStorm.
 * User: ariel
 * Date: 16/ago/2019
 * Time: 21:49
 */
namespace App\Scopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SellerScope implements Scope {
    public function apply(Builder $builder, Model $model)
    {
        // TODO: Implement apply() method.
        //un usuario es vendedor(seller) cuando tiene productos
        $builder->has('products');
    }


}