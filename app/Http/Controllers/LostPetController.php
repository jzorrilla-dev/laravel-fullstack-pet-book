<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLostPetRequest;
use App\Http\Requests\UpdateLostPetRequest;
use App\Models\LostPet;
use App\Services\LostPetService;
use Illuminate\Support\Facades\Auth;

class LostPetController extends Controller
{
    public function __construct(
        private readonly LostPetService $lostPetService,
    ) {}

    public function index()
    {
        $lostPets = LostPet::with('user')->latest()->paginate(9);

        return view('lostpets.index', compact('lostPets'));
    }

    public function show(int $id)
    {
        $lostPet = LostPet::with('user')->findOrFail($id);

        return view('lostpets.show', compact('lostPet'));
    }

    public function create()
    {
        return view('lostpets.create');
    }

    public function store(StoreLostPetRequest $request)
    {
        try {
            $lostPet = $this->lostPetService->create(
                $request->validated(),
                Auth::id(),
                $request->file('pet_photo')
            );

            return redirect()->route('lostpets.show', ['id' => $lostPet->id])
                ->with('status', '¡Publicación de mascota perdida registrada con éxito!');
        } catch (\Exception $e) {
            logger()->error('Error al registrar mascota perdida: '.$e->getMessage());

            return back()->withInput()->with('error', 'Error al registrar la publicación. Inténtalo de nuevo.');
        }
    }

    public function edit(int $id)
    {
        $lostPet = LostPet::findOrFail($id);

        if (! $this->lostPetService->isOwner($lostPet, Auth::id())) {
            abort(403);
        }

        return view('lostpets.edit', compact('lostPet'));
    }

    public function update(UpdateLostPetRequest $request, int $id)
    {
        $lostPet = LostPet::findOrFail($id);

        if (! $this->lostPetService->isOwner($lostPet, Auth::id())) {
            abort(403);
        }

        try {
            $this->lostPetService->update($lostPet, $request->validated(), $request->file('pet_photo'));

            return redirect()->route('lostpets.show', ['id' => $lostPet->id])
                ->with('status', '¡Publicación actualizada con éxito!');
        } catch (\Exception $e) {
            logger()->error('Error al actualizar mascota perdida: '.$e->getMessage());

            return back()->withInput()->with('error', 'Error al actualizar la publicación. Inténtalo de nuevo.');
        }
    }

    public function destroy(int $id)
    {
        $lostPet = LostPet::findOrFail($id);

        if (! $this->lostPetService->isOwner($lostPet, Auth::id())) {
            abort(403);
        }

        try {
            $this->lostPetService->delete($lostPet);

            return redirect()->route('lostpets.index')
                ->with('status', '¡Publicación eliminada con éxito!');
        } catch (\Exception $e) {
            logger()->error('Error al eliminar mascota perdida: '.$e->getMessage());

            return back()->with('error', 'Error al eliminar la publicación. Inténtalo de nuevo.');
        }
    }
}
