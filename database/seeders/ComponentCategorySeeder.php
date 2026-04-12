<?php

namespace Database\Seeders;

use App\Models\ComponentCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ComponentCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'CPU', 'slug' => 'cpu', 'icon' => 'cpu'],
            ['name' => 'GPU', 'slug' => 'gpu', 'icon' => 'gpu'],
            ['name' => 'Motherboard', 'slug' => 'motherboard', 'icon' => 'motherboard'],
            ['name' => 'RAM', 'slug' => 'ram', 'icon' => 'ram'],
            ['name' => 'Storage', 'slug' => 'storage', 'icon' => 'storage'],
            ['name' => 'PSU', 'slug' => 'psu', 'icon' => 'psu'],
            ['name' => 'Case', 'slug' => 'case', 'icon' => 'case'],
            ['name' => 'Cooler', 'slug' => 'cooler', 'icon' => 'cooler'],
        ];

        foreach ($categories as $category) {
            ComponentCategory::create(['id' => Str::uuid(), ...$category]);
        }
    }
}
