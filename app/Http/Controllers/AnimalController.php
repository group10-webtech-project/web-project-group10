<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        $animals = Animal::with('category')->paginate(10);

        if (request()->wantsJson()) {
            return response()->json($animals);
        }

        return view('admin.animals.index', compact('animals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Categories::all();
        return view('admin.animals.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:255',
            'initial_hint' => 'nullable|string|max:255',
            'size' => 'required|string|max:50',
            'habitat' => 'required|string|max:100',
            'diet' => 'required|string|in:Herbivore,Carnivore,Omnivore',
            'region' => 'required|string|max:100',
            'lifespan' => 'required|string|max:50',
            'has_legs' => 'required|boolean',
            'has_fur' => 'required|boolean',
            'can_swim' => 'required|boolean',
            'can_fly' => 'required|boolean',
            'is_carnivore' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('animals', 'public');
            $validatedData['image_url'] = $imagePath;
        }

        $animal = Animal::create($validatedData);

        if (request()->wantsJson()) {
            return response()->json($animal, 201);
        }

        return redirect()->route('admin.animals.show', $animal)
            ->with('success', 'Animal created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Animal $animal): View|JsonResponse
    {
        $animal->load('category');

        if (request()->wantsJson()) {
            return response()->json($animal);
        }

        return view('admin.animals.show', compact('animal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Animal $animal): View
    {
        $categories = Categories::all();
        return view('admin.animals.edit', compact('animal', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Animal $animal): RedirectResponse|JsonResponse
    {
//        dd($request->all());
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'short_name' => 'sometimes|nullable|string|max:255',
            'initial_hint' => 'sometimes|nullable|string|max:255',
            'size' => 'sometimes|required|string|max:50',
            'habitat' => 'sometimes|required|string|max:100',
            'diet' => 'sometimes|required|string|in:Herbivore,Carnivore,Omnivore',
            'region' => 'sometimes|required|string|max:100',
            'lifespan' => 'sometimes|required|string|max:50',
            'has_legs' => 'sometimes|required|boolean',
            'has_fur' => 'sometimes|required|boolean',
            'can_swim' => 'sometimes|required|boolean',
            'can_fly' => 'sometimes|required|boolean',
            'is_carnivore' => 'sometimes|required|boolean',
            'category_id' => 'sometimes|required|exists:categories,id',
            'description' => 'sometimes|nullable|string',
            'image_url' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            // Delete old image if it exists
            if ($animal->image_url) {
                Storage::disk('public')->delete($animal->image_url);
            }

            $imagePath = $request->file('image_url')->store('animals', 'public');
            $validatedData['image_url'] = $imagePath;
        }

        $animal->update($validatedData);

        if (request()->wantsJson()) {
            return response()->json($animal);
        }

        return redirect()->route('admin.animals.show', $animal)
            ->with('success', 'Animal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Animal $animal): RedirectResponse|JsonResponse
    {
        // Delete related game sessions
        $animal->gameSessions()->delete(); // Assuming you have a relationship defined

        // Delete image if it exists
        if ($animal->image_url) {
            Storage::disk('public')->delete($animal->image_url);
        }

        // Now delete the animal
        $animal->delete();

        if (request()->wantsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('admin.animals.index')
            ->with('success', 'Animal deleted successfully.');
    }

    /**
     * Get animals by category.
     */
    public function getByCategory(int $categoryId): JsonResponse
    {
        $animals = Animal::where('category_id', $categoryId)
            ->with('category')
            ->get();

        return response()->json($animals);
    }

    /**
     * Search animals by various criteria.
     */
    public function search(Request $request): JsonResponse
    {
        $query = Animal::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('habitat')) {
            $query->where('habitat', $request->input('habitat'));
        }

        if ($request->has('diet')) {
            $query->where('diet', $request->input('diet'));
        }

        if ($request->has('region')) {
            $query->where('region', $request->input('region'));
        }

        $animals = $query->with('category')->get();

        return response()->json($animals);
    }
}
