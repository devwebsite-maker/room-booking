<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder {
    public function run(): void {
        User::factory()->create(['name' => 'Admin User', 'email' => 'admin@example.com', 'role' => 'admin']);
        User::factory()->create(['name' => 'Regular User', 'email' => 'user@example.com', 'role' => 'user']);
    }
}