<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LostPet;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LostPetController extends Controller
{
    /**
     * Muestra una lista de mascotas perdidas.
     */
    public function index()
    {
        // Cargar la relación 'user' para incluir los datos del usuario
        $lostPets = LostPet::with('user')->latest()->get();

        // Devuelve la vista 'lostpets.index' y le pasa la colección de mascotas
        return view('lostpets.index', compact('lostPets'));
    }

    /**
     * Muestra los detalles de una mascota perdida específica.
     */
    public function show($id)
    {
        // Busca la mascota perdida por ID, fallando si no la encuentra
        $lostPet = LostPet::with('user')->findOrFail($id);

        // Devuelve la vista 'lostpets.show' y le pasa la mascota perdida
        return view('lostpets.show', compact('lostPet'));
    }

    /**
     * Muestra el formulario para crear una nueva publicación de mascota perdida.
     */
    public function create()
    {
        return view('lostpets.create');
    }

    /**
     * Almacena una nueva mascota perdida en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_name' => 'nullable|string|max:255',
            'last_seen' => 'nullable|string|max:255',
            'lost_date' => 'nullable|date',
            'pet_species' => 'required|string|max:255',
            'pet_photo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        try {
            $lostPet = new LostPet();
            $lostPet->user_id = Auth::id(); // Obtiene el ID del usuario autenticado
            $lostPet->pet_name = $request->pet_name;
            $lostPet->last_seen = $request->last_seen;
            $lostPet->lost_date = $request->lost_date;
            $lostPet->pet_species = $request->pet_species;
            $lostPet->description = $request->description ?? '';

            if ($request->hasFile('pet_photo') && $request->file('pet_photo')->isValid()) {
                $uploadedFile = $request->file('pet_photo');
                $result = Cloudinary::upload($uploadedFile->getRealPath(), [
                    'folder' => 'lost_pets',
                    'public_id' => 'lost_' . time(),
                ]);
                $lostPet->pet_photo = $result->getSecurePath();
            } else {
                $lostPet->pet_photo = null;
            }

            $lostPet->save();

            // Redirige a la página de detalles de la publicación recién creada
            return redirect()->route('lostpets.show', ['id' => $lostPet->id])
                ->with('status', '¡Publicación de mascota perdida registrada con éxito!');
        } catch (\Exception $e) {
            Log::error('Error al registrar mascota perdida: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al registrar la publicación. Inténtalo de nuevo.');
        }
    }

    /**
     * Muestra el formulario para editar una publicación de mascota perdida.
     */
    public function edit($id)
    {
        $lostPet = LostPet::findOrFail($id);

        // Verifica que el usuario autenticado sea el creador de la publicación
        if ((int) Auth::id() !== (int) $lostPet->user_id) {
            abort(403);
        }

        return view('lostpets.edit', compact('lostPet'));
    }

    /**
     * Actualiza una publicación de mascota perdida en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $lostPet = LostPet::findOrFail($id);

        if ((int) Auth::id() !== (int) $lostPet->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'pet_name' => 'nullable|string|max:255',
            'last_seen' => 'nullable|string|max:255',
            'lost_date' => 'nullable|date',
            'pet_species' => 'required|string|max:255',
            'pet_photo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        try {
            $lostPet->pet_name = $request->pet_name;
            $lostPet->last_seen = $request->last_seen;
            $lostPet->lost_date = $request->lost_date;
            $lostPet->pet_species = $request->pet_species;
            $lostPet->description = $request->description ?? '';

            if ($request->hasFile('pet_photo') && $request->file('pet_photo')->isValid()) {
                $uploadedFile = $request->file('pet_photo');
                $result = Cloudinary::upload($uploadedFile->getRealPath(), [
                    'folder' => 'lost_pets',
                    'public_id' => 'lost_' . time(),
                ]);
                $lostPet->pet_photo = $result->getSecurePath();
            }

            $lostPet->save();

            return redirect()->route('lostpets.show', ['id' => $lostPet->id])
                ->with('status', '¡Publicación actualizada con éxito!');
        } catch (\Exception $e) {
            Log::error('Error al actualizar mascota perdida: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al actualizar la publicación. Inténtalo de nuevo.');
        }
    }

    /**
     * Elimina una publicación de mascota perdida de la base de datos.
     */
    public function destroy($id)
    {
        $lostPet = LostPet::findOrFail($id);

        if ((int) Auth::id() !== (int) $lostPet->user_id) {
            abort(403);
        }

        try {
            $lostPet->delete();
            return redirect()->route('lostpets.index')
                ->with('status', '¡Publicación eliminada con éxito!');
        } catch (\Exception $e) {
            Log::error('Error al eliminar mascota perdida: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar la publicación. Inténtalo de nuevo.');
        }
    }
}
