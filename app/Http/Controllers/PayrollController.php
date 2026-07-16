<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Models\Employee;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::all();
        return view('payrolls.index' , compact('payrolls'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('payrolls.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'salary' => 'required|numeric',
            'bonuses' => 'required|numeric',
            'deductions' => 'required|numeric',
            'pay_date' => 'required|date',
        ]);

        $netSalary = $request->input('salary') + $request->input('bonuses') - $request->input('deductions');
        $request->merge(['net_salary' => $netSalary]);
        Payroll::create($request->all());

        return redirect()->route('payrolls.index')->with('success', 'Daftar Gaji berhasil ditambahkan.');
    }

    public function edit(Payroll $payroll)
    {
        $employees = Employee::all();
        return view('payrolls.edit', compact('payroll', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $payroll = Payroll::findOrFail($id);

        $request->validate([
            'employee_id' => 'required',
            'salary' => 'required|numeric',
            'bonuses' => 'required|numeric',
            'deductions' => 'required|numeric',
            'pay_date' => 'required|date',
        ]);

        $netSalary = $request->input('salary') + $request->input('bonuses') - $request->input('deductions');
        $request->merge(['net_salary' => $netSalary]);
        $payroll->update($request->all());

        return redirect()->route('payrolls.index')->with('success', 'Daftar Gaji berhasil diperbarui.');
    }

    public function show(Payroll $payroll)
    {
        return view('payrolls.show', compact('payroll'));
    }

    public function destroy(Payroll $payroll)
    {
        $payroll->delete();
        return redirect()->route('payrolls.index')->with('success', 'Daftar Gaji berhasil dihapus.');
    }
}
