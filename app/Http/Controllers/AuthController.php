<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyAccountRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'user_name' => $request->user_name,
            'user_phone' => $request->user_phone,
            'city' => $request->city,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', '¡Registro exitoso! ¡Bienvenido a Pet Book!');
    }

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        // Intentar autenticación
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'))->with('success', '¡Has iniciado sesión con éxito!');
        }

        // Mensaje genérico por seguridad
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no son correctas. Por favor, verifica tu correo y contraseña.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', '¡Sesión cerrada!');
    }

    public function showLinkRequestForm(): View
    {
        return view('auth.passwords.email');
    }

    public function forgotPassword(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        // Buscar usuario primero
        $user = User::where('email', $request->email)->first();

        // Generar token manualmente para tener control sobre user_id
        if ($user) {
            $token = Str::random(64);
            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'user_id' => $user->user_id,
                'token' => $token,
                'created_at' => now(),
            ]);

            // Enviar correo manualmente
            $user->sendPasswordResetNotification($token);
        }

        // Mensaje genérico por seguridad (no revela si el email existe)
        return back()->with('status', 'Si el correo electrónico existe en nuestro sistema, recibirás un enlace de restablecimiento en tu correo.');
    }

    public function showResetForm(Request $request): View
    {
        // Solo pasar el token, no el email
        return view('auth.passwords.reset')->with(
            ['token' => $request->token]
        );
    }

    public function validateResetToken(Request $request): JsonResponse
    {
        $token = $request->validate(['token' => 'required|string']);

        // Buscar token en la base de datos
        $tokenRecord = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->where('created_at', '>', now()->subMinutes(60))
            ->first();

        if (!$tokenRecord) {
            return response()->json(['error' => 'Token inválido o expirado'], 422);
        }

        // Obtener usuario asociado al token
        $user = User::find($tokenRecord->user_id);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 422);
        }

        return response()->json([
            'email' => $user->email,
            'user_name' => $user->user_name,
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Buscar token en la base de datos
        $tokenRecord = DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->first();

        if (!$tokenRecord) {
            return back()->withErrors(['token' => 'Token inválido o expirado']);
        }

        // Obtener usuario usando user_id del token (ignorar email del request por seguridad)
        $user = User::find($tokenRecord->user_id);

        if (!$user) {
            return back()->withErrors(['token' => 'Usuario no encontrado']);
        }

        // Actualizar contraseña
        $user->password = Hash::make($request->password);
        $user->save();

        // IMPORTANTE: Eliminar token inmediatamente
        DB::table('password_reset_tokens')->where('token', $request->token)->delete();

        // Invalidar todas las sesiones activas (seguridad)
        $user->tokens()->delete();

        // Evento de password reset
        event(new PasswordReset($user));

        return redirect()->route('login')->with('status', '¡Contraseña restablecida correctamente!');
    }

    public function showProfile(): View
    {
        $user = Auth::user();

        return view('profile.show', compact('user'));
    }

    public function editProfile(): View
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    public function updateProfile(UpdateProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();

        $this->profileService->update(
            $user,
            $request->validated(),
            $request->file('photo')
        );

        return redirect()->route('profile')->with('success', 'Perfil actualizado correctamente.');
    }

    public function destroyAccount(DestroyAccountRequest $request): RedirectResponse
    {
        $user = Auth::user();

        $success = $this->profileService->destroy($user, $request->password);

        if (! $success) {
            return back()->withErrors(['password' => 'La contraseña proporcionada es incorrecta.'])->withInput();
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', '¡Tu cuenta ha sido eliminada correctamente! Gracias por usar PetBook. Te extrañaremos.');
    }
}
