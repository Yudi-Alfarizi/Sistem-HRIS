<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all(); // Mengambil semua data karyawan
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::all();
        $roles = Role::all();
        return view('employees.create', compact('departments', 'roles'));
    }

    public function store(Request $request)
    {
        // Tangkap HASIL VALIDASI KE DALAM VARIABEL $validatedData
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|unique:employees,email', 
            'password' => 'required|string|min:8|confirmed', 
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'hire_date' => 'required|date',
            'department_id' => 'required|exists:departments,id', 
            'role_id' => 'required|exists:roles,id', 
            'status' => 'required|string',
            'salary' => 'required|numeric|min:0',
        ]);
        
        DB::beginTransaction();

        try {
            // Ambil data yg khusus untuk tabel employees
            $employeeData = $validatedData;
            unset($employeeData['password']);
            unset($employeeData['password_confirmation']);

            // Buat Data Karyawan 
            $employee = Employee::create($employeeData);

            // Buat Akun Login (User) dan tautin dengan ID Employee yang baru dibuat
            User::create([
                'name' => $validatedData['fullname'], 
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'employee_id' => $employee->id,
                'email_verified_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('employees.index')->with('success', 'Karyawan dan Akun Login berhasil dibuat.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::all();
        $roles = Role::all();
        return view('employees.edit', compact('employee', 'departments', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'hire_date' => 'required|date',
            'department_id' => 'required|exists:departments,id', // Validasi untuk memastikan department_id ada di tabel departments
            'role_id' => 'required|exists:roles,id', // Validasi untuk memastikan role_id ada di tabel roles
            'status' => 'required|string',
            'salary' => 'required|numeric|min:0',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        DB::beginTransaction();

        try {
            // A. Update Data Employee
            $employee = Employee::findOrFail($id);
            $employeeData = $request->except(['password', 'password_confirmation']);
            $employee->update($employeeData);

            // B. Update Data User Login menggunakan ORM
            $user = User::where('employee_id', $employee->id)->first();
            if ($user) {
                $userData = [
                    'name' => $request->fullname,
                    'email' => $request->email,
                ];
                
                // Jika input password diisi, maka update passwordnya
                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }
                
                $user->update($userData);
            }

            DB::commit();
            return redirect()->route('employees.index')->with('success', 'Data Karyawan dan Akun berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $employee = Employee::findOrFail($id);
            
            // Hapus Akun User (Login) terlebih dahulu berdasarkan employee_id
            User::where('employee_id', $employee->id)->delete();
            
            // Hapus data Karyawan
            $employee->delete();
            
            DB::commit();
            return redirect()->route('employees.index')->with('success', 'Karyawan dan Akun Login terkait berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus karyawan: ' . $e->getMessage());
        }
    }
}
