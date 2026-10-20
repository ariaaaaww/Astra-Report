<?php

namespace App\Http\Controllers;

use App\Http\Requests\Area\StoreRequest;
use App\Http\Requests\Area\UpdateRequest;
use App\Models\Area;

class AreaController
{
    public function index()
    {
        $title = 'Manajemen Area - LMS Astra Report';
        $areas = Area::get();

        return view('area.index', [
            'title' => $title,
            'areas' => $areas,
        ]);
    }

    public function show(Area $area)
    {
        $title = 'Detail Area - LMS Astra Report';

        return view('area.show', [
            'title' => $title,
            'area' => $area,
        ]);
    }

    public function create()
    {
        $title = 'Tambah Area - LMS Astra Report';

        return view('area.create', [
            'title' => $title,

        ]);
    }

    public function store(Area $area, StoreRequest $request)
    {   
        $validatedRequest = $request->validated();

        Area::create($validatedRequest);

        return redirect()->route('area.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(Area $area)
    {
        // Retrieve the area data by ID
        $title = 'Edit Area - LMS Astra Report';

        return view('area.edit', [
            'title' => 'Edit Area',
            'area' => $area,
        ]);
    }

    public function update(Area $area, UpdateRequest $request)
    {
        $validatedRequest = $request->validated();
        $area->update($validatedRequest);

        return redirect()->route('area.index');
    }

    public function destroy(Area $area)
    {
        // Delete the area data by ID
        $area->delete();

        return redirect()->route('area.index');
    }
}
