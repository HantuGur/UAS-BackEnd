<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Table;
use App\Models\Employee;
use App\Models\Promo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
use WithoutModelEvents;

/**
 * Menjalankan proses seeding utama pada database.
 */
public function run(): void
{
    // Membuat akun user default untuk kebutuhan testing terautentikasi
    User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    // 1. Seed Kategori
    Category::create(['name' => 'makanan', 'description' => 'Makanan berat dan cemilan gurih']);
    Category::create(['name' => 'minuman', 'description' => 'Minuman dingin dan hangat penyegar dahaga']);
    Category::create(['name' => 'dessert', 'description' => 'Makanan penutup manis pelengkap hidangan']);
    Category::create(['name' => 'appetizer', 'description' => 'Makanan pembuka pembangkit selera']);

    // Menjalankan seeder untuk Customer dan Menu
    $this->call([
        CustomerSeeder::class,
        MenuSeeder::class,
    ]);

    // 2. Seed Meja Restoran
    Table::create(['table_number' => '1', 'capacity' => 2, 'status' => 'available']);
    Table::create(['table_number' => '2', 'capacity' => 4, 'status' => 'available']);
    Table::create(['table_number' => '3', 'capacity' => 4, 'status' => 'available']);
    Table::create(['table_number' => '4', 'capacity' => 6, 'status' => 'available']);
    Table::create(['table_number' => '5', 'capacity' => 8, 'status' => 'available']);

    // 3. Seed Karyawan Admin
    Employee::create([
        'name' => 'Administrator',
        'role' => 'admin',
        'phone' => '081234567890',
        'username' => 'admin',
        'password' => Hash::make('admin123'),
    ]);

    // 4. Seed Promosi / Voucher
    Promo::create([
        'code' => 'DISKON20',
        'discount_type' => 'percent',
        'discount_amount' => 20,
        'max_discount' => 40000,
        'expired_at' => date('Y-m-d', strtotime('+30 days')),
        'status' => 'active',
        'is_public' => true,
    ]);

    Promo::create([
        'code' => 'DISKON5K',
        'discount_type' => 'fixed',
        'discount_amount' => 5000,
        'max_discount' => null,
        'expired_at' => date('Y-m-d', strtotime('+30 days')),
        'status' => 'active',
        'is_public' => true,
    ]);

    Promo::create([
        'code' => 'RAHASIA50',
        'discount_type' => 'percent',
        'discount_amount' => 50,
        'max_discount' => 50000,
        'expired_at' => date('Y-m-d', strtotime('+30 days')),
        'status' => 'active',
        'is_public' => false,
    ]);
}
}