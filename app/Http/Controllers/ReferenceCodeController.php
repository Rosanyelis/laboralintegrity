<?php

namespace App\Http\Controllers;

use App\Models\ReferenceCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReferenceCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $referenceCodes = ReferenceCode::orderBy('code')->get();
        
        return view('reference-codes.index', compact('referenceCodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reference-codes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verificar permisos usando Gate
        Gate::authorize('create', ReferenceCode::class);

        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:reference_codes,code',
            'result' => 'required|string|max:255',
            'actual_result' => 'nullable|string|max:255',
        ], [
            'code.required' => 'El código es obligatorio.',
            'code.unique' => 'Este código ya existe en el sistema.',
            'result.required' => 'El resultado es obligatorio.',
        ]);

        ReferenceCode::create($validated);

        return redirect()->route('config.reference-codes.index')
            ->with('success', 'Código de referencia creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ReferenceCode $referenceCode)
    {
        return view('reference-codes.show', compact('referenceCode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReferenceCode $referenceCode)
    {
        return view('reference-codes.edit', compact('referenceCode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReferenceCode $referenceCode)
    {
        // Verificar permisos usando Gate
        Gate::authorize('update', $referenceCode);

        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:reference_codes,code,' . $referenceCode->id,
            'result' => 'required|string|max:255',
            'actual_result' => 'nullable|string|max:255',
        ], [
            'code.required' => 'El código es obligatorio.',
            'code.unique' => 'Este código ya existe en el sistema.',
            'result.required' => 'El resultado es obligatorio.',
        ]);

        $referenceCode->update($validated);

        return redirect()->route('config.reference-codes.index')
            ->with('success', 'Código de referencia actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReferenceCode $referenceCode)
    {
        // Verificar permisos usando Gate
        Gate::authorize('delete', $referenceCode);

        $referenceCode->delete();

        return redirect()->route('config.reference-codes.index')
            ->with('success', 'Código de referencia eliminado correctamente.');
    }
}
