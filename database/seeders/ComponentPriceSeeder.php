<?php

namespace Database\Seeders;

use App\Models\Component;
use App\Models\ComponentPrice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ComponentPriceSeeder extends Seeder
{
    public function run(): void
    {
        $components = Component::all();
        $marketplaces = [
            ['name' => 'tokopedia', 'multiplier' => 1.00],
            ['name' => 'shopee', 'multiplier' => 0.97],
            ['name' => 'bukalapak', 'multiplier' => 1.02],
        ];

        foreach ($components as $component) {
            foreach ($marketplaces as $marketplace) {
                ComponentPrice::create([
                    'id' => Str::uuid(),
                    'component_id' => $component->id,
                    'marketplace' => $marketplace['name'],
                    'marketplace_url' => 'https://' . $marketplace['name'] . '.com/search?q=' . urlencode($component->name),
                    'price' => round($component->base_price * $marketplace['multiplier'], -3),
                    'is_available' => true,
                    'last_checked_at' => now(),
                ]);
            }
        }
    }
}
