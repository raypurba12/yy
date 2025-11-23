<?php

namespace App\Http\Controllers;

use App\Models\ColdStorage;
use Illuminate\Http\Request;

class ColdStorageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coldStorages = ColdStorage::paginate(10);
        return view('cold-storage.index', compact('coldStorages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cold-storage.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'current_temperature' => 'required|numeric|between:-50,50',
            'target_temperature' => 'required|numeric|between:-50,50',
            'status' => 'required|in:active,maintenance,offline',
            'description' => 'nullable|string',
        ]);

        ColdStorage::create($request->all());

        return redirect()->route('cold-storage.index')->with('success', 'Cold storage unit created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ColdStorage $coldStorage)
    {
        return view('cold-storage.show', compact('coldStorage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ColdStorage $coldStorage)
    {
        return view('cold-storage.edit', compact('coldStorage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ColdStorage $coldStorage)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'current_temperature' => 'required|numeric|between:-50,50',
            'target_temperature' => 'required|numeric|between:-50,50',
            'status' => 'required|in:active,maintenance,offline',
            'description' => 'nullable|string',
        ]);

        $coldStorage->update($request->all());

        return redirect()->route('cold-storage.index')->with('success', 'Cold storage unit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ColdStorage $coldStorage)
    {
        $coldStorage->delete();

        return redirect()->route('cold-storage.index')->with('success', 'Cold storage unit deleted successfully.');
    }
}