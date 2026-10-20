<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dealer\StoreRequest;
use App\Http\Requests\Dealer\UpdateRequest;
use App\Models\Dealer;

class DealerController
{
    public function index()
    {
        $title = 'Manajemen Dealer - LMS Astra Report';
        $dealers = Dealer::get();

        return view('dealer.index', [
            'title' => $title,
            'dealers' => $dealers,
        ]);
    }

    public function show(Dealer $dealer)
    {
        $title = 'Detail Dealer - LMS Astra Report';

        return view('dealer.show', [
            'title' => $title,
            'dealer' => $dealer,
        ]);
    }

    public function create(Dealer $dealer)
    {
        $title = 'Tambah Dealer - LMS Astra Report';

        return view('dealer.create', [
            'title' => $title,
            'dealer' => $dealer,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $validatedRequest = $request->validated();

        Dealer::create($validatedRequest);

        return redirect()->route('dealer.index');
    }

    public function edit($id)
    {
        // Retrieve the dealer data by ID
        // ...
        $title = 'Edit Dealer - LMS Astra Report';
        $dealer = Dealer::findOrFail($id);

        return view('dealer.edit', compact('dealer', 'title'));
    }

    public function update(Dealer $dealer, UpdateRequest $request)
    {
        $validatedRequest = $request->validated();

        $dealer->update($validatedRequest);

        return redirect()->route('dealer.index');
    }

    public function destroy(Dealer $dealer)
    {
        // Delete the dealer data by ID
        $dealer->delete();

        return redirect()->route('dealer.index');
    }
}
