<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class   ExpenseController extends Controller
{
/**
 * @OA\Get(
 *   path="/expenses",
 *   description="Get all expenses",
 *   operationId="index",
 *   tags={"Expenses"},
 *   security={ {"bearerAuth": {} }},
 *   @OA\Response(
 *     response=200,
 *     description="Success",
 *     @OA\JsonContent(
 *       type="array",
 *       @OA\Items(ref="#/components/schemas/Expense")
 *     )
 *   )
 * )
 */

    public function index()
    {
        $user = Auth::user();
        $expenses = $user->expenses;
        return response()->json($expenses);
    }

    /**
     * @OA\Post(
     *    path="/expenses",
     *  summary="Create a new expense",
     * description="Create a new expense",
     * operationId="store",
     * tags={"Expenses"},
     * security={ {"bearerAuth": {} }},
     * @OA\RequestBody(
     *   required=true,
     * @OA\JsonContent(
     * required={"description","amount","date"},
     * @OA\Property(property="description", type="string", format="text", example="Lunch"),
     * @OA\Property(property="amount", type="number", format="float", example="10.99"),
     * @OA\Property(property="date", type="string", format="date", example="2021-01-01")
     * )
     * ),
     * @OA\Response(
     *   response=201,description="Created",
     * @OA\JsonContent(ref="#/components/schemas/Expense")
     * )
     * )
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request)
    {
        //return response()->json($request->user()-);
        $request->validate([
            'description' => 'required',
            'amount' => 'required',
            'date' => 'required|date',
        ]);
    
        $expense = Expense::create([
            'description' => $request->description,
            'amount' => $request->amount,
            'date' => $request->date,
            'user_id' =>$request->user()->id,
        ]);
    
        return response()->json($expense, 201);
    }

    /**
     * @OA\Get(
     *    path="/expenses/{expense}",
     * summary="Get an expense",
     * description="Get an expense",
     * operationId="show",
     * tags={"Expenses"},
     * security={ {"bearerAuth": {} }},
     *  @OA\Parameter(
     *   name="expense",
     * in="path",
     * required=true,
     * description="ID of the expense",
     * @OA\Schema(
     *  type="integer",
     * format="int64"
     * )
     * ),
     * @OA\Response(
     *  response=200,description="Success",
     * @OA\JsonContent(ref="#/components/schemas/Expense")
     * )
     * )
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */

     /**
      * @OA\Put(
        *    path="/expenses/{expense}",
        *  summary="Update an expense",
        * description="Update an expense",
        * operationId="update",
        * tags={"Expenses"},
        * security={ {"bearerAuth": {} }},
        * @OA\Parameter(
        *   name="expense",
        * in="path",
        * required=true,
        * description="ID of the expense",
        * @OA\Schema(
        *  type="integer",
        * format="int64"
        * )
        * ),
        * @OA\RequestBody(
        *   required=true,
        * @OA\JsonContent(
        * required={"description","amount","date"},
        * @OA\Property(property="description", type="string", format="text", example="Lunch"),
        * @OA\Property(property="amount", type="number", format="float", example="10.99"),
        * @OA\Property(property="date", type="string", format="date", example="2021-01-01")
        * )
        * ),
        * @OA\Response(
        *   response=200,description="Success",
        * @OA\JsonContent(ref="#/components/schemas/Expense")
        * )
        * )
        * @param  \Illuminate\Http\Request  $request
        * @param  \App\Models\Expense  $expense
        * @return \Illuminate\Http\Response
        * @throws \Illuminate\Auth\Access\AuthorizationException
        * @throws \Illuminate\Validation\ValidationException
        * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
        */

public function update(Request $request, Expense $expense)
{
    $this->authorize('update', $expense);

    $expense->update($request->all());
    return $expense;
}

        /**
         * @OA\Delete(
         *    path="/expenses/{expense}",
         *  summary="Delete an expense",
         * description="Delete an expense",
         * operationId="destroy",
         * tags={"Expenses"},
         * security={ {"bearerAuth": {} }},
         * @OA\Parameter(
         *   name="expense",
         * in="path",
         * required=true,
         * description="ID of the expense",
         * @OA\Schema(
         *  type="integer",
         * format="int64"
         * )
         * ),
         * @OA\Response(
         *  response=204,description="No content"
         * )
         * )
         * @param  \App\Models\Expense  $expense
         * @return \Illuminate\Http\Response
         * @throws \Illuminate\Auth\Access\AuthorizationException
         */

public function destroy(Expense $expense)
{
    $this->authorize('delete', $expense);

    $expense->delete();

    return response()->json(null, 204);
}
}