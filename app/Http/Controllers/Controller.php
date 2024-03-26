<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Expense Tracker API",
     *      description="Laravel API for Expense Tracker",
     *      @OA\Contact(
     *          email="acharouaoumohamed @gmail.com"
     *     ),   
     * )
     */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
