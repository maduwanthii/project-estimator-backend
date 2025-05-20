<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfficeExpense;

class OfficeExpenseController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'cost' => 'required|numeric',
        ]);

        $expense = OfficeExpense::create([
            'title' => $request->title,
            'cost' => $request->cost,
        ]);

        return response()->json([
            'message' => 'Expense created',
            'expenseId' => $expense->id
        ], 201);
    }

   
    public function update(Request $request, $id)
    {
        $expense = OfficeExpense::findOrFail($id);

        $request->validate([
            'title' => 'required|string',
            'cost' => 'required|numeric',
        ]);

        $expense->update([
            'title' => $request->title,
            'cost' => $request->cost,
        ]);

        return response()->json(['message' => 'Expense updated']);
    }
}
