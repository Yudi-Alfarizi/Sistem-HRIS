<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Task;
use App\Models\Employee;

class TaskController extends Controller
{
    // Mendapatkan role saat ini dari session
    private function currentRole(): ?string
    {
        return session('role');
    }

    // Mendapatkan ID karyawan saat ini dari session
    private function currentEmployeeId(): ?int
    {
        return session('employee_id');
    }

    // Mendapatkan ID departemen saat ini dari session
    private function currentDepartmentId(): ?int
    {
        return session('department_id');
    }

    // Memeriksa apakah pengguna saat ini memiliki izin untuk mengelola tugas
    private function canManageTasks(): bool
    {
        return in_array($this->currentRole(), ['HR', 'Manager'], true);
    }

    // Mendapatkan query builder untuk karyawan yang dapat dilihat oleh pengguna saat ini
    private function visibleEmployeesQuery()
    {
        $query = Employee::with('department');

        if ($this->currentRole() === 'Manager') {
            $query->where('department_id', $this->currentDepartmentId());
        }

        return $query->orderBy('fullname');
    }

    // Memeriksa apakah pengguna saat ini dapat melihat tugas tertentu
    private function canViewTask(Task $task): bool
    {
        $task->loadMissing('employee');

        if ($this->currentRole() === 'HR') {
            return true;
        }

        if ($this->currentRole() === 'Manager') {
            return (int) optional($task->employee)->department_id === (int) $this->currentDepartmentId();
        }

        return (int) $task->assigned_to === (int) $this->currentEmployeeId();
    }

    // Validasi input tugas
    private function validateTaskInput(Request $request, bool $allowFinishedStatus = false): array
    {
        $statusRule = $allowFinishedStatus
            ? ['required', 'in:pending,proses,selesai']
            : ['required', 'in:pending,proses'];

        $assignedToRule = Rule::exists('employees', 'id');

        if ($this->currentRole() === 'Manager') {
            $assignedToRule = Rule::exists('employees', 'id')
                ->where(fn ($query) => $query->where('department_id', $this->currentDepartmentId()));
        }

        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => ['required', 'integer', $assignedToRule],
            'due_date' => 'required|date',
            'status' => $statusRule,
        ]);
    }

    // Menampilkan daftar tugas
    public function index()
    {
        $query = Task::with('employee.department');

        if ($this->currentRole() === 'HR') {
            $tasks = $query->get();
        } elseif ($this->currentRole() === 'Manager') {
            $tasks = $query->whereHas('employee', function ($employeeQuery) {
                $employeeQuery->where('department_id', $this->currentDepartmentId());
            })->get();
        } else {
            $tasks = $query->where('assigned_to', $this->currentEmployeeId())->get();
        }
        
        return view('tasks.index', compact('tasks'));
    }
    // Menampilkan detail tugas
    public function show(Task $task)
    {
        abort_unless($this->canViewTask($task), 403);

        return view('tasks.show', compact('task'));
    }

    // Menampilkan form untuk membuat tugas baru
    public function create()
    {
        abort_unless($this->canManageTasks(), 403);

        $employees = $this->visibleEmployeesQuery()->get();
        return view('tasks.create', compact('employees'));
    }

    // Menyimpan tugas baru ke database
    public function store(Request $request)
    {
        abort_unless($this->canManageTasks(), 403);

        $validated = $this->validateTaskInput($request);

        // Berhasil divalidasi, simpan data tugas ke database
        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dibuat.');
    }

    // Menampilkan form untuk mengedit tugas
    public function edit(Task $task)
    {
        abort_unless($this->canManageTasks() && $this->canViewTask($task), 403);

        $employees = $this->visibleEmployeesQuery()->get();
        return view('tasks.edit', compact('task', 'employees'));
    }

    // Memperbarui tugas yang ada di database
    public function update(Request $request, Task $task)
    {
        abort_unless($this->canManageTasks() && $this->canViewTask($task), 403);

        $validated = $this->validateTaskInput($request, true);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    // Menandai tugas sebagai selesai
    public function done(int $id)
    {
        $task = Task::find($id);
        abort_unless($task && $this->canViewTask($task), 403);

        $task->update(['status' => 'selesai']);
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditandai sebagai selesai.');
    }

    // Menandai tugas sebagai pending
    public function pending(int $id)
    {
        $task = Task::find($id);
        abort_unless($task && $this->canViewTask($task), 403);

        $task->update(['status' => 'pending']);
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditandai sebagai pending.');
    }

    // Menandai tugas sebagai sedang dikerjakan
    public function inProgress(int $id)
    {
        $task = Task::find($id);
        abort_unless($task && $this->canViewTask($task), 403);

        $task->update(['status' => 'proses']);
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditandai sebagai proses.');
    }

    // Menghapus tugas dari database
    public function destroy(Task $task)
    {
        abort_unless($this->canManageTasks() && $this->canViewTask($task), 403);

        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }

}
