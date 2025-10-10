<?php

namespace App\Http\Controllers;

use App\Models\ReferenceCode;
use App\Models\Certification;
use Illuminate\Http\Request;

class ReferenceCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $referenceCodes = ReferenceCode::with('certification')->orderBy('created_at', 'desc')->get();
        
        return view('reference-codes.index', compact('referenceCodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $certifications = Certification::orderBy('name')->get();
        
        return view('reference-codes.create', compact('certifications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'certification_id' => 'required|exists:certifications,id',
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255|unique:reference_codes,name',
            'result' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ], [
            'certification_id.required' => 'El tipo de certificación es obligatorio.',
            'certification_id.exists' => 'El tipo de certificación seleccionado no es válido.',
            'code.required' => 'El código es obligatorio.',
            'name.required' => 'El nombre es obligatorio.',
            'name.unique' => 'Este nombre ya existe en el sistema.',
            'result.required' => 'El resultado es obligatorio.',
        ]);

        $validated['is_active'] = $request->has('is_active');

        ReferenceCode::create($validated);

        return redirect()->route('config.reference-codes.index')
            ->with('success', 'Código de referencia creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ReferenceCode $referenceCode)
    {
        $referenceCode->load('certification');
        
        return view('reference-codes.show', compact('referenceCode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReferenceCode $referenceCode)
    {
        $certifications = Certification::orderBy('name')->get();
        
        return view('reference-codes.edit', compact('referenceCode', 'certifications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReferenceCode $referenceCode)
    {
        $validated = $request->validate([
            'certification_id' => 'required|exists:certifications,id',
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255|unique:reference_codes,name,' . $referenceCode->id,
            'result' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ], [
            'certification_id.required' => 'El tipo de certificación es obligatorio.',
            'certification_id.exists' => 'El tipo de certificación seleccionado no es válido.',
            'code.required' => 'El código es obligatorio.',
            'name.required' => 'El nombre es obligatorio.',
            'name.unique' => 'Este nombre ya existe en el sistema.',
            'result.required' => 'El resultado es obligatorio.',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $referenceCode->update($validated);

        return redirect()->route('config.reference-codes.index')
            ->with('success', 'Código de referencia actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReferenceCode $referenceCode)
    {
        $referenceCode->delete();

        return redirect()->route('config.reference-codes.index')
            ->with('success', 'Código de referencia eliminado correctamente.');
    }
}
