<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskLog;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TaskSubmissionController implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('can:view,submission', only: ['show']),
            new Middleware('can:update,submission', only: ['edit', 'update']),
            new Middleware('can:delete,submission', only: ['destroy']),
        ];
    }

    public function index()
    {
        $title = 'Daftar Tugas Saya - LMS Astra Report';
        $dealerId = auth()->user()->dealer_id;

        $tasks = Task::with([
            'department',
            'submissions' => function ($query) use ($dealerId) {
                $query->where('dealer_id', $dealerId);
            },
        ])->latest()->get();

        return view('task_submission.index', [
            'title' => $title,
            'tasks' => $tasks,
        ]);
    }

    public function show($id)
    {
        $title = 'Status Pengumpulan Tugas - LMS Astra Report';
        $submission = TaskSubmission::with(['task.department', 'dealer', 'logs.user'])
            ->findOrFail($id);

        return view('task_submission.show', [
            'title' => $title,
            'submission' => $submission,
        ]);
    }

    public function create(Task $task)
    {
        $title = 'Pengumpulan Tugas - LMS Astra Report';

        // Load relasi department jika diperlukan
        $task->load('department');

        return view('task_submission.create', [
            'title' => $title,
            'task' => $task,
        ]);
    }

    public function store(Request $request, Task $task)
    {
        $request->validate([
            'drive_link' => 'required|url',
            'notes' => 'nullable|string|max:500',
        ]);

        $dealerId = auth()->user()->dealer_id;

        if (! $dealerId) {
            return back()->with('error', 'Akun Anda belum terhubung dengan data Dealer. Silakan hubungi Administrator untuk memilihkan Dealer.');
        }

        $submission = TaskSubmission::updateOrCreate(
            [
                'task_id' => $task->id, // Diambil langsung dari $task pada parameter URL
                'dealer_id' => $dealerId,
            ],
            [
                'drive_link' => $request->drive_link,
                'status' => 'MENUNGGU',
            ]
        );

        TaskLog::create([
            'task_submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'activity' => 'Dealer Mengumpulkan Tugas',
            'notes' => $request->notes ?? 'Tugas baru dikumpulkan dengan link Drive.',
        ]);

        return redirect()->route('task-submissions.index')->with('success', 'Tugas berhasil dikumpulkan.');
    }

    public function edit($id)
    {
        $title = 'Pengumpulan Ulang / Revisi - LMS Astra Report';
        $submission = TaskSubmission::with('task')->findOrFail($id);

        return view('task_submission.edit', [
            'title' => $title,
            'submission' => $submission,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'drive_link' => 'required|url',
            'notes' => 'nullable|string|max:500',
        ]);

        $submission = TaskSubmission::findOrFail($id);
        $submission->update([
            'drive_link' => $request->drive_link,
            'status' => 'MENUNGGU',
        ]);

        TaskLog::create([
            'task_submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'activity' => 'Dealer Mengirimkan Revisi Tugas',
            'notes' => $request->notes ?? 'Dealer memperbarui link pengerjaan tugas.',
        ]);

        return redirect()->route('task-submissions.index')->with('success', 'Revisi tugas berhasil dikirimkan.');
    }

    public function destroy($id)
    {
        $submission = TaskSubmission::findOrFail($id);
        $submission->delete();

        return redirect()->route('task-submissions.index')->with('success', 'Pengumpulan tugas berhasil dihapus.');
    }
}
