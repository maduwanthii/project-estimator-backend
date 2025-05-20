<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Staff;
use App\Models\OfficeExpense;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::with('staff')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'hours' => 'required|numeric',
            'staff_ids' => 'required|array'
        ]);

        $staff = Staff::whereIn('id', $request->staff_ids)->get();

        if ($staff->isEmpty()) {
            return response()->json(['error' => 'No valid staff IDs found'], 400);
        }

        $hours = $request->hours;

        $staffCost = $staff->sum(function ($s) use ($hours) {
            $hourly = $s->salary / 180;
            return $hourly * $hours;
        });

        $officeMonthly = OfficeExpense::sum('cost');
        $officeHourly = $officeMonthly / 180;
        $officeCost = $officeHourly * $hours;

        $totalCost = $staffCost + $officeCost;
        $costPerHour = $totalCost / $hours;

        $project = Project::create([
            'name' => $request->name,
            'hours' => $hours
        ]);

        $project->staff()->attach($request->staff_ids);

        return response()->json([
            'project' => $project->name,
            'hours' => $hours,
            'staff_cost' => round($staffCost, 2),
            'office_cost' => round($officeCost, 2),
            'total_cost' => round($totalCost, 2),
            'cost_per_hour' => round($costPerHour, 2),
            'project_id' => $project->id
        ], 201);
    }
}
