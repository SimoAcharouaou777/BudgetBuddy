<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class   ExpenseController extends Controller
{
    public function index()
    {
        return Auth::user()->expenses;
    }

    public function store(Request $request)
    {
        //return response()->json($request->user()-);
        $request->validate([
            'description' => 'required',
            'amount' => 'required',
            'date' => 'required',
        ]);
    
        $expense = Expense::create([
            'description' => $request->description,
            'amount' => $request->amount,
            'date' => $request->date,
            'user_id' =>$request->user()->id,
        ]);
    
        return response()->json($expense, 201);
    }

public function update(Request $request, Expense $expense)
{
    $this->authorize('update', $expense);

    $expense->update($request->all());
    return $expense;
}

public function destroy(Expense $expense)
{
    $this->authorize('delete', $expense);

    $expense->delete();

    return response()->json(null, 204);
}
}