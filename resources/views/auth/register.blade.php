@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-8">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Crear Cuenta</h1>

        <!-- Formulario de registro -->
        <form action="{{ route('register') }}" method="POST" x-data="registerForm()">
            @csrf

            <!-- Campo de Nombre de Usuario -->
            <div class="mb-4">
                <label for="user_name" class="block text-gray-700 font-semibold mb-2">Nombre de Usuario</label>
                <input type="text" id="user_name" name="user_name" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    required>
            </div>

            <!-- Campo de Teléfono -->
            <div class="mb-4">
                <label for="user_phone" class="block text-gray-700 font-semibold mb-2">Teléfono</label>
                <input type="text" id="user_phone" name="user_phone" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    required>
            </div>

            <!-- Campo de Ciudad -->
            <div class="mb-4">
                <label for="city" class="block text-gray-700 font-semibold mb-2">Ciudad</label>
                <input type="text" id="city" name="city" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    required>
            </div>

            <!-- Campo de Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" id="email" name="email" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    required>
            </div>

            <!-- Campo de Contraseña con toggle -->
            <div class="mb-2">
                <label for="password" class="block text-gray-700 font-semibold mb-2">Contraseña</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" 
                        x-model="password"
                        @input="checkPassword()"
                        id="password" name="password" 
                        class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        required>
                    <button type="button" 
                        @click="showPassword = !showPassword"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                        tabindex="-1">
                        <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                    </button>
                </div>
            </div>

            <!-- Indicador de fortaleza de contraseña -->
            <div x-show="password.length > 0" class="mb-4">
                <!-- Barra de progreso -->
                <div class="h-2 bg-gray-200 rounded-full overflow-hidden mb-2">
                    <div class="h-full transition-all duration-300" 
                        :class="strengthBarClass"
                        :style="`width: ${score * 25}%`">
                    </div>
                </div>
                <!-- Texto de fortaleza -->
                <p class="text-sm font-medium" :class="strengthTextClass" x-text="strengthText"></p>
                
                <!-- Lista de requisitos -->
                <ul class="mt-2 space-y-1 text-sm">
                    <li class="flex items-center gap-2" :class="requirements.length >= 8 ? 'text-green-600' : 'text-red-500'">
                        <i :class="requirements.length >= 8 ? 'fa-solid fa-check' : 'fa-solid fa-xmark'"></i>
                        <span>Mínimo 8 caracteres</span>
                    </li>
                    <li class="flex items-center gap-2" :class="requirements.hasUppercase ? 'text-green-600' : 'text-red-500'">
                        <i :class="requirements.hasUppercase ? 'fa-solid fa-check' : 'fa-solid fa-xmark'"></i>
                        <span>Al menos una mayúscula</span>
                    </li>
                    <li class="flex items-center gap-2" :class="requirements.hasNumber ? 'text-green-600' : 'text-red-500'">
                        <i :class="requirements.hasNumber ? 'fa-solid fa-check' : 'fa-solid fa-xmark'"></i>
                        <span>Al menos un número</span>
                    </li>
                    <li class="flex items-center gap-2" :class="requirements.hasSpecial ? 'text-green-600' : 'text-red-500'">
                        <i :class="requirements.hasSpecial ? 'fa-solid fa-check' : 'fa-solid fa-xmark'"></i>
                        <span>Al menos un carácter especial</span>
                    </li>
                </ul>
            </div>

            <!-- Campo de Confirmación de Contraseña con toggle -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">Confirmar Contraseña</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" 
                        x-model="passwordConfirm"
                        @input="checkPasswordMatch()"
                        id="password_confirmation" name="password_confirmation" 
                        class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        required>
                    <button type="button" 
                        @click="showPassword = !showPassword"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                        tabindex="-1">
                        <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                    </button>
                </div>
                <!-- Mensaje de coincidencia -->
                <p x-show="passwordConfirm.length > 0" 
                    class="text-sm mt-1"
                    :class="passwordMatch ? 'text-green-600' : 'text-red-500'">
                    <i :class="passwordMatch ? 'fa-solid fa-check' : 'fa-solid fa-xmark'"></i>
                    <span x-text="passwordMatch ? 'Las contraseñas coinciden' : 'Las contraseñas no coinciden'"></span>
                </p>
            </div>

            <!-- Botón de envío -->
            <button type="submit" 
                class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                :disabled="!isValid">
                Registrarse
            </button>
        </form>
    </div>
</div>

<script>
function registerForm() {
    return {
        password: '',
        passwordConfirm: '',
        showPassword: false,
        score: 0,
        strengthText: '',
        strengthBarClass: '',
        strengthTextClass: '',
        requirements: {
            length: 0,
            hasUppercase: false,
            hasNumber: false,
            hasSpecial: false
        },
        passwordMatch: false,

        checkPassword() {
            if (this.password.length === 0) {
                this.score = 0;
                this.strengthText = '';
                return;
            }

            // Check basic requirements
            this.requirements.length = this.password.length;
            this.requirements.hasUppercase = /[A-Z]/.test(this.password);
            this.requirements.hasNumber = /[0-9]/.test(this.password);
            this.requirements.hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(this.password);

            // Use zxcvbn for strength calculation
            const result = zxcvbn(this.password);
            this.score = result.score;

            // Update text and colors
            const texts = ['Muy débil', 'Débil', 'Regular', 'Fuerte', 'Muy fuerte'];
            const barClasses = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500', 'bg-green-600'];
            const textClasses = ['text-red-500', 'text-orange-500', 'text-yellow-600', 'text-green-500', 'text-green-600'];

            this.strengthText = texts[this.score];
            this.strengthBarClass = barClasses[this.score];
            this.strengthTextClass = textClasses[this.score];

            this.checkPasswordMatch();
        },

        checkPasswordMatch() {
            this.passwordMatch = this.password === this.passwordConfirm && this.password.length > 0;
        },

        get isValid() {
            return this.score >= 3 && this.passwordMatch && this.requirements.length >= 8;
        }
    }
}
</script>
@endsection