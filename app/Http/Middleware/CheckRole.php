<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Employee;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $employeeID = auth()->user()->employee_id;
        $employee = Employee::find($employeeID);
        $request->session()->put('role', $employee->role->title);
        $request->session()->put('employee_id', $employee->id);
        $request->session()->put('department_id', $employee->department_id);

        // Jika role yang diizinkan adalah '*' atau 'all', maka izinkan akses untuk semua role
        if (in_array('*', $roles, true) || in_array('all', $roles, true)) {
            return $next($request);
        }

        // Jika role pengguna sesuai dengan salah satu role yang diizinkan, maka izinkan akses
        if (in_array($employee->role->title, $roles, true)) {
            return $next($request);
        }

        abort(403, 'Tidak memiliki izin untuk mengakses halaman ini.');
    }
}
