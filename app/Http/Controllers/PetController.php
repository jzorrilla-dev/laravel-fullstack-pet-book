<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Models\LostPet;
use App\Models\Pet;
use App\Services\PetService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PetController extends Controller
{
    public function __construct(
        private readonly PetService $petService,
    ) {}

    public function home(): View
    {
        $pets = Pet::latest()->take(9)->get();
        $lostPets = LostPet::latest()->take(9)->get();

        return view('home', compact('pets', 'lostPets'));
    }

    public function index(): View
    {
        $pets = Pet::latest()->paginate(9);

        return view('pets.index', compact('pets'));
    }

    public function show(int $pet_id): View
    {
        $pet = Pet::with('user')->findOrFail($pet_id);

        return view('pets.show', compact('pet'));
    }

    public function create(): View
    {
        return view('pets.create');
    }

    public function store(StorePetRequest $request): RedirectResponse
    {
        try {
            $pet = $this->petService->create(
                $request->validated(),
                Auth::id(),
                $request->file('pet_photo')
            );

            return redirect()->route('pets.show', ['pet_id' => $pet->pet_id])
                ->with('status', '¡Mascota registrada con éxito!');
        } catch (\Exception $e) {
            logger()->error('Error al crear mascota: '.$e->getMessage());

            return back()->withInput()->with('error', 'Error al crear la mascota. Inténtalo de nuevo.');
        }
    }

    public function edit(int $pet_id): View
    {
        $pet = Pet::findOrFail($pet_id);

        if (! $this->petService->isOwner($pet, Auth::id())) {
            abort(403);
        }

        return view('pets.edit', compact('pet'));
    }

    public function update(UpdatePetRequest $request, int $pet_id): RedirectResponse
    {
        $pet = Pet::findOrFail($pet_id);

        if (! $this->petService->isOwner($pet, Auth::id())) {
            abort(403);
        }

        try {
            $this->petService->update($pet, $request->validated(), $request->file('pet_photo'));

            return redirect()->route('pets.show', ['pet_id' => $pet->pet_id])
                ->with('status', '¡Mascota actualizada con éxito!');
        } catch (\Exception $e) {
            logger()->error('Error al actualizar mascota: '.$e->getMessage());

            return back()->withInput()->with('error', 'Error al actualizar la mascota. Inténtalo de nuevo.');
        }
    }

    public function destroy(int $pet_id): RedirectResponse
    {
        $pet = Pet::findOrFail($pet_id);

        if (! $this->petService->isOwner($pet, Auth::id())) {
            abort(403);
        }

        try {
            $this->petService->delete($pet);

            return redirect()->route('home')
                ->with('status', '¡Mascota eliminada con éxito!');
        } catch (\Exception $e) {
            logger()->error('Error al eliminar mascota: '.$e->getMessage());

            return back()->with('error', 'Error al eliminar la mascota. Inténtalo de nuevo.');
        }
    }
}
