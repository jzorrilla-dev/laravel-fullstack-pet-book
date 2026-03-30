<?php

namespace App\Http\Controllers;

use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de registro.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Procesa la petición de registro de un nuevo usuario.
     * Si es exitoso, redirige al usuario.
     */
    public function register(Request $request)
    {
        // 1. Validar los datos del formulario, incluyendo los nuevos campos.
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Crear el nuevo usuario en la base de datos.
        $user = User::create([
            'user_name' => $request->user_name,
            'user_phone' => $request->user_phone,
            'city' => $request->city,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3. Autenticar al usuario recién registrado de forma directa.
        Auth::login($user);

        // 4. Redirige al usuario a la página de inicio con un mensaje de éxito.
        return redirect()->route('home')->with('success', '¡Registro exitoso! ¡Bienvenido a Pet Book!');
    }

    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesa la petición de inicio de sesión.
     * Si es exitoso, redirige; si falla, vuelve al formulario.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'))->with('success', '¡Has iniciado sesión con éxito!');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', '¡Sesión cerrada!');
    }

    /**
     * Muestra el formulario para solicitar el restablecimiento de contraseña.
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Envía el enlace de restablecimiento de contraseña por correo.
     */
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = Password::broker()->sendResetLink($request->only('email'));

        if ($response == Password::RESET_LINK_SENT) {
            return back()->with('status', 'Te hemos enviado el enlace de restablecimiento de contraseña.');
        }

        return back()->withErrors(['email' => 'No pudimos encontrar un usuario con esa dirección de correo.']);
    }

    /**
     * Muestra el formulario para restablecer la contraseña.
     */
    public function showResetForm(Request $request)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $request->token, 'email' => $request->email]
        );
    }

    /**
     * Restablece la contraseña del usuario.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $response = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
                event(new PasswordReset($user));
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', '¡Tu contraseña ha sido restablecida!');
        }

        return back()->withErrors(['email' => trans($response)]);
    }

    /**
     * Muestra el perfil del usuario autenticado.
     */
    public function showProfile()
    {
        $user = Auth::user();

        return view('profile.show', compact('user'));
    }

    /**
     * Muestra el formulario para editar el perfil del usuario autenticado.
     */
    public function editProfile()
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    /**
     * Actualiza el perfil del usuario autenticado.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validación. Email único exceptuando el propio usuario. Password opcional.
        $validated = $request->validate([
            'user_name' => ['required', 'string', 'max:255'],
            'user_phone' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->user_id.',user_id'],
            'description' => ['nullable', 'string', 'max:1000'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        // Actualizar campos básicos
        $user->user_name = $validated['user_name'];
        $user->user_phone = $validated['user_phone'];
        $user->city = $validated['city'];
        $user->email = $validated['email'];
        $user->description = $validated['description'] ?? $user->description;

        // Actualizar password si se envió
        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Actualizar foto de perfil si se subió
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            // Eliminar foto anterior si existe y no es la default
            if ($user->photo && strpos($user->photo, 'cloudinary') !== false) {
                try {
                    $publicId = pathinfo(parse_url($user->photo, PHP_URL_PATH), PATHINFO_FILENAME);
                    Cloudinary::destroy('profile_photos/'.$publicId);
                } catch (\Exception $e) {
                    Log::warning('No se pudo eliminar la foto anterior: '.$e->getMessage());
                }
            }

            // Subir nueva foto
            $uploadedFile = $request->file('photo');
            $result = Cloudinary::upload($uploadedFile->getRealPath(), [
                'folder' => 'profile_photos',
                'public_id' => 'profile_'.$user->user_id,
                'transformation' => [
                    'width' => 400,
                    'height' => 400,
                    'crop' => 'fill',
                    'gravity' => 'face',
                ],
            ]);
            $user->photo = $result->getSecurePath();
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Perfil actualizado correctamente.');
    }

    public function destroyAccount(Request $request): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'password' => ['required', 'string'],
            'confirm_deletion' => ['accepted'],
        ]);

        if (! Hash::check($validated['password'], $user->password)) {
            return back()->withErrors(['password' => 'La contraseña proporcionada es incorrecta.'])->withInput();
        }

        if ($user->photo && strpos($user->photo, 'cloudinary') !== false) {
            try {
                $publicId = pathinfo(parse_url($user->photo, PHP_URL_PATH), PATHINFO_FILENAME);
                Cloudinary::destroy('profile_photos/'.$publicId);
            } catch (\Exception $e) {
                logger()->warning('No se pudo eliminar la foto de perfil: '.$e->getMessage());
            }
        }

        $userName = $user->user_name;
        $user->delete();

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', "¡Tu cuenta ha sido eliminada correctamente! Gracias por usar PetBook, {$userName}. Te extrañaremos.");
    }
}
