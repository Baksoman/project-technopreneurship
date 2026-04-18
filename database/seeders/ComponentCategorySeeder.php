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
            ['name' => 'CPU', 'icon' => 'cpu'],
            ['name' => 'GPU', 'icon' => 'gpu'],
            ['name' => 'Motherboard', 'icon' => 'motherboard'],
            ['name' => 'RAM', 'icon' => 'ram'],
            ['name' => 'Storage', 'icon' => 'storage'],
            ['name' => 'PSU', 'icon' => 'psu'],
            ['name' => 'Case', 'icon' => 'case'],
            ['name' => 'CPU Cooler', 'icon' => 'cooler'],
        ];

        foreach ($categories as $category) {
            ComponentCategory::create(['id' => Str::uuid(), ...$category]);
        }
    }
}
