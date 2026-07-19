<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CreateRolesAndPermissionsSeeder::class,
            CategoryAndSkillSeeder::class,
            SubscriptionPlanSeeder::class,
            UserCredentialsSeeder::class,
            SampleJobSeeder::class,
        ]);

        // User::factory(10)->create();

        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'first_name' => 'Test',
                'last_name' => 'User',
                'email' => 'test@example.com',
            ]);
        }
    }
}
