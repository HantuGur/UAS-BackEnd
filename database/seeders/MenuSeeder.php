<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
/**
 * Menjalankan database seeder untuk data Menu.
 */
public function run(): void
{
    Menu::create([
        'name' => 'Nasi Goreng Spesial',
        'price' => 25000,
        'category' => 'makanan',
    ]);

    Menu::create([
        'name' => 'Mie Goreng Ayam',
        'price' => 22000,
        'category' => 'makanan',
    ]);

    Menu::create([
        'name' => 'Es Teh Manis',
        'price' => 5000,
        'category' => 'minuman',
    ]);

    Menu::create([
        'name' => 'Jus Alpukat',
        'price' => 12000,
        'category' => 'minuman',
    ]);
}
}