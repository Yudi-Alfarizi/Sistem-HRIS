<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presence;
use App\Models\Employee;

class PresenceController extends Controller
{
    public function index()
    {
        $presences = Presence::all();
        return view('presences.index', compact('presences'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('presences.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'check_in' => 'required|date',
            'check_out' => 'nullable|date|after_or_equal:check_in',
            'date' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        Presence::create($request->all());

        return redirect()->route('presences.index')->with('success', 'Kehadiran berhasil direkam.');
    }

    public function edit(Presence $presence)
    {
        $employees = Employee::all();
        return view('presences.edit', compact('presence', 'employees'));
    }

    public function update(Request $request, Presence $presence)
    {
        $request->validate([
            'employee_id' => 'required',
            'check_in' => 'required|date',
            'check_out' => 'nullable|date|after_or_equal:check_in',
            'date' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        $presence->update($request->all());

        return redirect()->route('presences.index')->with('success', 'Kehadiran berhasil diperbarui.');
    }

    public function destroy(Presence $presence)
    {
        $presence->delete();
        return redirect()->route('presences.index')->with('success', 'Kehadiran berhasil dihapus.');
    }

}