<?php

namespace Database\Seeders;

use App\Models\LostPet;
use App\Models\User;
use Illuminate\Database\Seeder;

class LostPetSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('No hay usuarios. Creando usuario de prueba...');
            $user = User::create([
                'user_name' => 'Usuario Prueba',
                'user_phone' => '+54 9 11 1234 5678',
                'city' => 'Buenos Aires',
                'email' => 'test@petbook.com',
                'password' => bcrypt('password'),
            ]);
            $users = collect([$user]);
        }

        $species = ['perro', 'gato', 'conejo', 'hamster', 'ave'];
        $locations = [
            'Parque Central, Buenos Aires',
            'Plaza Italia, Córdoba',
            'Barrio Norte, Rosario',
            'Centro, Mendoza',
            'Ciudad Universitaria, La Plata',
            'Playa Bristol, Mar del Plata',
            'Mercado Central, Salta',
        ];

        $names = [
            'Peluso', 'Michi', 'Tomy', 'Luna', 'Simba', 'Nieve', 'Moro', 'Chiquito',
            'Rex', 'Bolsa', 'Pip', 'Tuti', 'Cuki', 'Pancho', 'Negro', 'Blanco',
            'Copito', 'Frida', 'Keko', 'Puka',
        ];

        $photos = [
            'https://images.unsplash.com/photo-1587300003388-59208cc962cb?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1573865526739-10659fec78a5?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1537151608828-ea2b11777ee8?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1518791841217-8f162f1e1131?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1592194996308-7b43878e84a6?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1601758228041-f3b2795255f1?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1560807707-8cc77767d783?w=400&h=300&fit=crop',
        ];

        $descriptions = [
            'Perro de tamaño mediano, color café. Tiene collar azul. Es muy amigable.',
            'Gato atigrado con ojos verdes. Tiene una mancha blanca en el pecho. Responde a su nombre.',
            'Perro golden retriever joven. Se asustó con un ruido y salió corriendo.',
            'Gato naranja, muy nervioso. Usualmente duerme en el balcón.',
            'Perro fox terrier, ears pointing up. Very playful and friendly.',
            'Gato negro con ojos amarillos. Tiene una cicatriz en la oreja izquierda.',
            'Conejo blanco con orejas largas. Muy tímido, probablemente está escondido.',
            'Perro labrador negro, tiene cerca de 3 años. Ama jugar con pelotas.',
            'Gato siamés, muy vocal. Se lost near the park.',
            'Hamster dorado, puede estar cerca de arbustos.',
        ];

        for ($i = 0; $i < 20; $i++) {
            $user = $users->random();
            $lostDate = now()->subDays(rand(1, 30));

            LostPet::create([
                'pet_name' => $names[array_rand($names)],
                'last_seen' => $locations[array_rand($locations)],
                'lost_date' => $lostDate->toDateString(),
                'pet_species' => $species[array_rand($species)],
                'pet_photo' => $photos[array_rand($photos)],
                'description' => $descriptions[array_rand($descriptions)],
                'user_id' => $user->user_id,
            ]);
        }

        $this->command->info('Seed de mascotas perdidas creado exitosamente!');
    }
}
