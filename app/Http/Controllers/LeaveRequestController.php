<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\Employee;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $leaveRequests = LeaveRequest::all();
        return view('leave-requests.index', compact('leaveRequests'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('leave-requests.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $request->merge([
            'status' => 'pending',
        ]);
        LeaveRequest::create($request->all());

        return redirect()->route('leave-requests.index')->with('success', 'Permintaan cuti berhasil dibuat.');
    }

    public function edit(LeaveRequest $leaveRequest)
    {
        $employees = Employee::all();
        $statuses = ['pending', 'disetujui', 'ditolak'];
        return view('leave-requests.edit', compact('leaveRequest', 'employees', 'statuses'));
    }

    public function update(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string',
        ]);

        $leaveRequest->update($request->all());

        return redirect()->route('leave-requests.index')->with('success', 'Permintaan cuti berhasil diperbarui.');
    }

    public function confirm( int $id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update(['status' => 'disetujui']);

        return redirect()->route('leave-requests.index')->with('success', 'Permintaan cuti berhasil disetujui.');
    }

    public function reject( int $id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update(['status' => 'ditolak']);

        return redirect()->route('leave-requests.index')->with('success', 'Permintaan cuti berhasil ditolak.');
    }

    public function destroy(LeaveRequest $leaveRequest)
    {
        $leaveRequest->delete();
        return redirect()->route('leave-requests.index')->with('success', 'Permintaan cuti berhasil dihapus.');
    }
}
