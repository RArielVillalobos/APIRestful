<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponser;

class ApiController extends Controller
{
    //ahora ya podemos usar todas los metodos del trait
    use ApiResponser;
    //

    public function __construct()
    {
    }

}
