<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Employee;

class TaskController extends Controller
{
    // Menampilkan daftar tugas
    public function index()
    {
        if (session('role') == 'HR') {
            $tasks = Task::all();
        } else {
            $tasks = Task::where('assigned_to', session('employee_id'))->get();
        }
        
        return view('tasks.index', compact('tasks'));
    }
    // Menampilkan detail tugas
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    // Menampilkan form untuk membuat tugas baru
    public function create()
    {
        $employees = Employee::all();
        return view('tasks.create', compact('employees'));
    }

    // Menyimpan tugas baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required',
            'due_date' => 'required|date',
            'status' => 'required|string',
        ]);

        // Berhasil divalidasi, simpan data tugas ke database
        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dibuat.');
    }

    // Menampilkan form untuk mengedit tugas
    public function edit(Task $task)
    {
        $employees = Employee::all();
        return view('tasks.edit', compact('task', 'employees'));
    }

    // Memperbarui tugas yang ada di database
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:employees,id',
            'due_date' => 'required|date',
            'status' => 'required|string',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    // Menandai tugas sebagai selesai
    public function done(int $id)
    {
        $task = Task::find($id);
        $task->update(['status' => 'selesai']);
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditandai sebagai selesai.');
    }

    // Menandai tugas sebagai pending
    public function pending(int $id)
    {
        $task = Task::find($id);
        $task->update(['status' => 'pending']);
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditandai sebagai pending.');
    }

    // Menandai tugas sebagai sedang dikerjakan
    public function inProgress(int $id)
    {
        $task = Task::find($id);
        $task->update(['status' => 'proses']);
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditandai sebagai proses.');
    }

    // Menghapus tugas dari database
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }

}
