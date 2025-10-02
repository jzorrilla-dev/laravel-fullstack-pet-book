<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Exception;

class PetController extends Controller
{
    /**
     * Muestra la página de inicio con una vista previa de mascotas.
     */
    public function home()
    {
        // Se eliminó la llamada a where() ya que este controlador solo maneja mascotas en adopción.
        $pets = Pet::latest()->take(8)->get();
        return view('home', compact('pets'));
    }

    /**
     * Muestra una lista de todas las mascotas disponibles para adopción.
     */
    public function index()
    {
        // Se eliminó la llamada a where() ya que este controlador solo maneja mascotas en adopción.
        $pets = Pet::latest()->get();
        return view('pets.index', compact('pets'));
    }

    /**
     * Muestra los detalles de una mascota específica.
     */
    public function show($pet_id)
    {
        // Busca la mascota por ID, fallando si no la encuentra
        $pet = Pet::with('user')->findOrFail($pet_id);

        // Devuelve la vista 'pets.show' y le pasa la mascota
        return view('pets.show', compact('pet'));
    }

    /**
     * Muestra el formulario para crear una nueva mascota.
     */
    public function create()
    {
        return view('pets.create');
    }

    /**
     * Almacena una nueva mascota en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pet_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'pet_species' => 'required|string|max:255',
            'castrated' => 'required',
            'pet_photo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'health_condition' => 'nullable|string',
        ]);

        try {
            $pet = new Pet();
            $pet->pet_name = $request->pet_name;
            $pet->location = $request->location;
            $pet->description = $request->description ?? '';
            $pet->pet_species = $request->pet_species;
            $pet->health_condition = $request->health_condition ?? '';
            $pet->castrated = filter_var($request->castrated, FILTER_VALIDATE_BOOLEAN);
            $pet->pet_status = 'available';

            // Aseguramos que el user_id se asigne solo si hay un usuario autenticado
            if (Auth::check()) {
                $pet->user_id = Auth::id();
            } else {
                // Manejar el caso donde no hay un usuario autenticado
                throw new Exception('Usuario no autenticado para crear una mascota.');
            }

            if ($request->hasFile('pet_photo') && $request->file('pet_photo')->isValid()) {
                $uploadedFile = $request->file('pet_photo');
                $result = Cloudinary::upload($uploadedFile->getRealPath(), [
                    'folder' => 'pets',
                    'public_id' => 'pet_' . time()
                ]);
                $pet->pet_photo = $result->getSecurePath();
            } else {
                $pet->pet_photo = null;
            }

            $pet->save();

            // Redirige a la página de detalles de la mascota recién creada
            return redirect()->route('pets.show', ['pet_id' => $pet->pet_id])
                ->with('status', '¡Mascota registrada con éxito!');
        } catch (Exception $e) {
            Log::error('Error al crear mascota: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al crear la mascota. Inténtalo de nuevo.');
        }
    }


    /**
     * Muestra el formulario para editar una mascota.
     */
    public function edit($pet_id)
    {
        $pet = Pet::findOrFail($pet_id);

        // Verifica que el usuario autenticado sea el dueño de la mascota
        if ((int) Auth::id() !== (int) $pet->user_id) {
            abort(403);
        }

        return view('pets.edit', compact('pet'));
    }

    /**
     * Actualiza una mascota en la base de datos.
     */
    public function update(Request $request, $pet_id)
    {
        $pet = Pet::findOrFail($pet_id);

        if ((int) Auth::id() !== (int) $pet->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'pet_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'pet_species' => 'required|string|max:255',
            'castrated' => 'required',
            'pet_photo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'health_condition' => 'nullable|string',
        ]);

        try {
            $pet->pet_name = $request->pet_name;
            $pet->location = $request->location;
            $pet->description = $request->description ?? '';
            $pet->pet_species = $request->pet_species;
            $pet->health_condition = $request->health_condition ?? '';
            $pet->castrated = filter_var($request->castrated, FILTER_VALIDATE_BOOLEAN);

            if ($request->hasFile('pet_photo') && $request->file('pet_photo')->isValid()) {
                $uploadedFile = $request->file('pet_photo');
                $result = Cloudinary::upload($uploadedFile->getRealPath(), [
                    'folder' => 'pets',
                    'public_id' => 'pet_' . time(),
                ]);
                $pet->pet_photo = $result->getSecurePath();
            }

            $pet->save();

            return redirect()->route('pets.show', ['pet_id' => $pet->id])
                ->with('status', '¡Mascota actualizada con éxito!');
        } catch (\Exception $e) {
            Log::error('Error al actualizar mascota: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error al actualizar la mascota. Inténtalo de nuevo.');
        }
    }

    /**
     * Elimina una mascota de la base de datos.
     */
    public function destroy($pet_id)
    {
        $pet = Pet::findOrFail($pet_id);

        if ((int) Auth::id() !== (int) $pet->user_id) {
            abort(403);
        }

        try {
            $pet->delete();
            return redirect()->route('home')
                ->with('status', '¡Mascota eliminada con éxito!');
        } catch (\Exception $e) {
            Log::error('Error al eliminar mascota: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar la mascota. Inténtalo de nuevo.');
        }
    }
}
