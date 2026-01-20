<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\FamilyRelationship;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FamilyController extends Controller
{
    /**
     * Display a listing of the families.
     */
    public function index(): View
    {
        $families = Family::orderBy('name')->paginate(15);
        return view('families.index', compact('families'));
    }

    /**
     * Show the form for creating a new family member.
     */
    public function create(): View
    {
        $families = Family::orderBy('name')->get();
        return view('families.create', compact('families'));
    }

    /**
     * Store a newly created family member in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:families,email',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:Hidup,Meninggal',
            'parent_id' => 'nullable|exists:families,id',
            'relationship_type' => 'nullable|in:Ayah,Ibu,Anak,Suami,Istri,Saudara',
        ]);

        // Create the family member
        $family = Family::create([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'status' => $validated['status'],
        ]);

        // Add relationship if parent is specified
        if (!empty($validated['parent_id'])) {
            FamilyRelationship::create([
                'parent_id' => $validated['parent_id'],
                'child_id' => $family->id,
                'relationship_type' => $validated['relationship_type'] ?? 'Anak',
            ]);
        }

        return redirect()->route('families.index')->with('success', 'Anggota keluarga berhasil ditambahkan!');
    }

    /**
     * Display the specified family member and their tree.
     */
    public function show(Family $family): View
    {
        $family->load('parents', 'children');
        return view('families.show', compact('family'));
    }

    /**
     * Show the form for editing the specified family member.
     */
    public function edit(Family $family): View
    {
        $families = Family::where('id', '!=', $family->id)->orderBy('name')->get();
        return view('families.edit', compact('family', 'families'));
    }

    /**
     * Update the specified family member in storage.
     */
    public function update(Request $request, Family $family): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:families,email,' . $family->id,
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:Hidup,Meninggal',
        ]);

        $family->update($validated);

        return redirect()->route('families.index')->with('success', 'Data anggota keluarga berhasil diperbarui!');
    }

    /**
     * Remove the specified family member from storage.
     */
    public function destroy(Family $family): RedirectResponse
    {
        $family->delete();

        return redirect()->route('families.index')->with('success', 'Anggota keluarga berhasil dihapus!');
    }

    /**
     * Display the family tree view
     */
    public function tree(): View
    {
        $rootFamilies = Family::whereDoesntHave('parents')
            ->with('children')
            ->get();
        
        return view('families.tree', compact('rootFamilies'));
    }

    /**
     * Get family tree data as JSON for visualization
     */
    public function getTreeData(Family $family = null)
    {
        if ($family === null) {
            // Get root family members (no parents)
            $family = Family::whereDoesntHave('parents')->first();
        }

        if (!$family) {
            return response()->json(['error' => 'No family data found'], 404);
        }

        return response()->json($this->buildTreeData($family));
    }

    /**
     * Build tree data recursively
     */
    private function buildTreeData(Family $family): array
    {
        $children = $family->children()->get();
        
        return [
            'id' => $family->id,
            'name' => $family->name,
            'gender' => $family->gender,
            'birth_date' => $family->birth_date ? $family->birth_date->format('Y-m-d') : null,
            'status' => $family->status,
            'children' => $children->map(fn($child) => $this->buildTreeData($child))->toArray(),
        ];
    }

    /**
     * Add relationship between two family members
     */
    public function addRelationship(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'parent_id' => 'required|exists:families,id',
            'child_id' => 'required|exists:families,id|different:parent_id',
            'relationship_type' => 'required|in:Ayah,Ibu,Anak,Suami,Istri,Saudara',
        ]);

        // Check if relationship already exists
        $exists = FamilyRelationship::where([
            'parent_id' => $validated['parent_id'],
            'child_id' => $validated['child_id'],
            'relationship_type' => $validated['relationship_type'],
        ])->exists();

        if ($exists) {
            return back()->with('warning', 'Hubungan keluarga ini sudah ada!');
        }

        FamilyRelationship::create($validated);

        return back()->with('success', 'Hubungan keluarga berhasil ditambahkan!');
    }

    /**
     * Remove relationship between two family members
     */
    public function removeRelationship(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'relationship_id' => 'required|exists:family_relationships,id',
        ]);

        FamilyRelationship::find($validated['relationship_id'])->delete();

        return back()->with('success', 'Hubungan keluarga berhasil dihapus!');
    }
}
