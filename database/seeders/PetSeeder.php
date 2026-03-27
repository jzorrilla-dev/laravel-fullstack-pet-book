<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Seeder;

class PetSeeder extends Seeder
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
            'Buenos Aires, Argentina',
            'Córdoba, Argentina',
            'Rosario, Argentina',
            'Mendoza, Argentina',
            'La Plata, Argentina',
            'Mar del Plata, Argentina',
            'Salta, Argentina',
        ];

        $names = [
            'Luna', 'Max', 'Bella', 'Charlie', 'Lucy', 'Cooper', 'Daisy', 'Buddy',
            'Sasha', 'Rocky', 'Molly', 'Toby', 'Chloe', 'Duke', 'Zoey', 'Bear',
            'Maggie', 'Jack', 'Sophie', 'Oliver', 'Ruby', 'Bruno', 'Nina', 'Thor',
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

        for ($i = 0; $i < 20; $i++) {
            $user = $users->random();

            Pet::create([
                'pet_name' => $names[array_rand($names)],
                'location' => $locations[array_rand($locations)],
                'description' => 'Mascota friendly y adorable. Está buscando un hogar lleno de amor. Vacunas al día y muy sociable con otros animales.',
                'pet_species' => $species[array_rand($species)],
                'pet_status' => 'available',
                'health_condition' => 'Saludable, vacunas al día',
                'castrated' => rand(0, 1) === 1,
                'pet_photo' => $photos[array_rand($photos)],
                'user_id' => $user->user_id,
            ]);
        }

        $this->command->info('Seed de mascotas creado exitosamente!');
    }
}
