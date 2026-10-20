<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\StoreRequest;
use App\Http\Requests\Department\UpdateRequest;
use App\Models\Department;

class DepartmentController
{
    public function index()
    {
        $title = 'Manajemen Departemen - LMS Astra Report';
        $departments = Department::get();

        return view('department.index', [
            'title' => $title,
            'departments' => $departments,
        ]);
    }

    public function show(Department $department)
    {
        $title = 'Detail Departemen - LMS Astra Report';

        return view('department.show', [
            'title' => $title,
            'department' => $department,
        ]);
    }

    public function create(Department $department)
    {
        $title = 'Tambah Departemen - LMS Astra Report';

        return view('department.create', [
            'title' => $title,
            'departments' => $department,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $validatedRequest = $request->validated();

        Department::create($validatedRequest);

        return redirect()->route('department.index');
    }

    public function edit($id)
    {
        $title = 'Edit Departemen - LMS Astra Report';
        $department = Department::find($id);

        return view('department.edit', [
            'title' => $title,
            'department' => $department,
        ]);
    }

    public function update(Department $department, UpdateRequest $request)
    {
        $validatedRequest = $request->validated();
        $department->update($validatedRequest);

        return redirect()->route('department.index');
    }

    public function destroy(Department $department)
    {
        // Delete the department data by ID
        $department->delete();

        return redirect()->route('department.index');
    }
}
