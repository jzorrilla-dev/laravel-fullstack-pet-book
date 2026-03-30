<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyAccountRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
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

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'))->with('success', '¡Has iniciado sesión con éxito!');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', '¡Sesión cerrada!');
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $response = Password::broker()->sendResetLink($request->only('email'));

        if ($response == Password::RESET_LINK_SENT) {
            return back()->with('status', 'Te hemos enviado el enlace de restablecimiento de contraseña.');
        }

        return back()->withErrors(['email' => 'No pudimos encontrar un usuario con esa dirección de correo.']);
    }

    public function showResetForm(Request $request)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $request->token, 'email' => $request->email]
        );
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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

    public function showProfile()
    {
        $user = Auth::user();

        return view('profile.show', compact('user'));
    }

    public function editProfile()
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        $this->profileService->update(
            $user,
            $request->validated(),
            $request->file('photo')
        );

        return redirect()->route('profile')->with('success', 'Perfil actualizado correctamente.');
    }

    public function destroyAccount(DestroyAccountRequest $request)
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
