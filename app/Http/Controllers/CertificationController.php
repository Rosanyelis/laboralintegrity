<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $certifications = Certification::orderBy('created_at', 'desc')->get();
        
        return view('certifications.index', compact('certifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('certifications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:certifications,name',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.unique' => 'Este nombre de depuración ya existe.',
        ]);

        Certification::create($validated);

        return redirect()->route('config.certifications.index')
            ->with('success', 'Tipo de depuración creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Certification $certification)
    {
        return view('certifications.show', compact('certification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certification $certification)
    {
        return view('certifications.edit', compact('certification'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certification $certification)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:certifications,name,' . $certification->id,
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.unique' => 'Este nombre de depuración ya existe.',
        ]);

        $certification->update($validated);

        return redirect()->route('config.certifications.index')
            ->with('success', 'Tipo de depuración actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certification $certification)
    {
        $certificationName = $certification->name;
        $certification->delete();

        return redirect()->route('config.certifications.index')
            ->with('success', "Tipo de depuración \"{$certificationName}\" eliminado correctamente.");
    }
}
