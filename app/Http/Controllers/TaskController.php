<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Models\Area;
use App\Models\Dealer;
use App\Models\Department;
use App\Models\Task;
use App\Models\TaskSubmission;

class TaskController
{
    public function index()
    {
        $title = 'Manajemen Tugas - LMS Astra Report';
        $tasks = Task::with(['area', 'department'])->get();
        $area = Area::select('id', 'name')->get();
        $department = Department::select('id', 'name')->get();

        return view('tasks.index', [
            'title' => $title,
            'tasks' => $tasks,
            'area' => $area,
            'department' => $department,
        ]);
    }

    public function create()
    {
        $title = 'Buat Tugas Baru - LMS Astra Report';
        $areas = Area::all();
        $departments = Department::all();

        return view('tasks.create', [
            'title' => $title,
            'areas' => $areas,
            'departments' => $departments,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $validatedRequest = $request->validated();
        $validatedRequest['created_by'] = auth()->id();

        $task = Task::create($validatedRequest);

        // Otomatis buat entri task_submissions untuk setiap dealer
        $dealers = Dealer::all();
        foreach ($dealers as $dealer) {
            TaskSubmission::create([
                'task_id' => $task->id,
                'dealer_id' => $dealer->id,
                'drive_link' => '',
                'status' => 'MENUNGGU',
            ]);
        }

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dibuat dan dibagikan ke dealer.');
    }

    public function edit($id)
    {
        $title = 'Edit Tugas - LMS Astra Report';
        $task = Task::findOrFail($id);
        $areas = Area::all();
        $departments = Department::all();

        return view('tasks.edit', compact('task', 'title', 'areas', 'departments'));
    }

    public function update(Task $task, UpdateRequest $request)
    {
        $validatedRequest = $request->validated();

        $task->update($validatedRequest);

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        // Delete the task data by ID
        $task->delete();

        return redirect()->route('tasks.index');
    }

    public function show(Task $task)
    {
        $title = 'Detail Tugas - LMS Astra Report';

        return view('tasks.show', [
            'title' => $title,
            'task' => $task,
        ]);
    }
}
