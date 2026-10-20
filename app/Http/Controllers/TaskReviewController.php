<?php

namespace App\Http\Controllers;

use App\Models\TaskLog;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TaskReviewController extends Controller
{
    public function index(Request $request)
    {
        $title = "Pemeriksaan Tugas - LMS Astra Report";

        $search = $request->query('search');
        $departmentId = $request->query('department_id');
        $areaId = $request->query('area_id');
        $tasklog = TaskLog::get();

        $submissions = TaskSubmission::with(['task.department', 'task.area', 'dealer'])
            
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('task', function ($taskQuery) use ($search) {
                        $taskQuery->where('title', 'like', "%{$search}%");
                    })->orWhereHas('dealer', function ($dealerQuery) use ($search) {
                        $dealerQuery->where('name', 'like', "%{$search}%");
                    });
                });
            })
            ->when($departmentId, function ($query, $departmentId) {
                $query->whereHas('task', fn($q) => $q->where('department_id', $departmentId));
            })
            ->when($areaId, function ($query, $areaId) {
                $query->whereHas('task', fn($q) => $q->where('area_id', $areaId));
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        $departments = \App\Models\Department::all();
        $areas = \App\Models\Area::all();

        return view('task_reviews.index', [
            'title' => $title,
            'submissions' => $submissions,
            'departments' => $departments,
            'areas' => $areas,
        ]);
    }

    public function show($id)
    {
        $title = 'Review & Verifikasi Tugas - LMS Astra Report';
        $submission = TaskSubmission::with(['task.department', 'task.area', 'dealer', 'logs.user'])
            ->findOrFail($id);

        return view('task_reviews.show', [
            'title' => $title,
            'submission' => $submission,
        ]);
    }

    public function approve(Request $request, $id)
    {
        $submission = TaskSubmission::findOrFail($id);

        $submission->update([
            'status' => 'DISETUJUI',
        ]);

        TaskLog::create([
            'task_submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'activity' => 'Supervisor Menyetujui Pengumpulan',
            'notes' => $request->input('notes'),
        ]);

        return redirect()->route('task-reviews.index')
            ->with('success', 'Task berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'notes' => 'required|string|max:500',
        ]);

        $submission = TaskSubmission::findOrFail($id);

        // Ubah status ke REVISI atau DITOLAK sesuai input/kebutuhan
        $status = $request->input('status') === 'DITOLAK' ? 'DITOLAK' : 'REVISI';

        $submission->update([
            'status' => $status,
        ]);

        TaskLog::create([
            'task_submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'activity' => $status === 'DITOLAK' ? 'Supervisor Menolak Hasil Pekerjaan' : 'Supervisor Minta Revisi',
            'notes' => $request->notes,
        ]);

        return redirect()->route('task-reviews.index')
            ->with('warning', 'Status task berhasil diperbarui.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:DISETUJUI,REVISI,DITOLAK',
            'notes' => 'nullable|string|max:500',
        ]);

        $submission = TaskSubmission::findOrFail($id);
        $submission->update([
            'status' => $request->status,
        ]);

        $activity = match ($request->status) {
            'DISETUJUI' => 'Supervisor Menyetujui Pengumpulan',
            'REVISI' => 'Supervisor Meminta Revisi',
            'DITOLAK' => 'Supervisor Menolak Hasil Pekerjaan',
        };

        TaskLog::create([
            'task_submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'activity' => $activity,
            'notes' => $request->notes,
        ]);

        return redirect()->route('task-reviews.index')
            ->with('success', 'Hasil pemeriksaan berhasil disimpan.');
    }
}
