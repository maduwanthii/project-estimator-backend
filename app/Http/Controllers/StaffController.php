<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;

class StaffController extends Controller
{
    
    public function index()
    {
        return Staff::select('id', 'name', 'salary')->get();
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'salary' => 'required|numeric',
        ]);

        $staff = Staff::create($request->only('name', 'salary'));

        return response()->json([
            'message' => 'Staff created',
            'staffId' => $staff->id,
        ], 201);
    }

    
    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'salary' => 'required|numeric',
        ]);

        $staff->update($request->only('name', 'salary'));

        return response()->json(['message' => 'Staff updated']);
    }
}
