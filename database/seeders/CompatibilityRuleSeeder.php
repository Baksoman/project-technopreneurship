<?php

namespace Database\Seeders;

use App\Models\Component;
use App\Models\CompatibilityRule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CompatibilityRuleSeeder extends Seeder
{
    public function run(): void
    {
        $r5600x = Component::where('slug', 'amd-ryzen-5-5600x')->first();
        $r7600x = Component::where('slug', 'amd-ryzen-5-7600x')->first();
        $i5 = Component::where('slug', 'intel-core-i5-13600k')->first();
        $i3 = Component::where('slug', 'intel-core-i3-12100f')->first();
        $b550 = Component::where('slug', 'asus-rog-strix-b550-f')->first();
        $b760 = Component::where('slug', 'msi-pro-b760m-a')->first();
        $b650 = Component::where('slug', 'gigabyte-b650-aorus-elite-ax')->first();
        $ddr4 = Component::where('slug', 'corsair-vengeance-16gb-ddr4-3200')->first();
        $ddr5 = Component::where('slug', 'gskill-trident-z5-32gb-ddr5-6000')->first();
        $rtx4060 = Component::where('slug', 'nvidia-rtx-4060')->first();
        $rtx4070 = Component::where('slug', 'nvidia-rtx-4070')->first();
        $psu550 = Component::where('slug', 'corsair-cv550')->first();
        $psu750 = Component::where('slug', 'seasonic-focus-gx-750')->first();

        $rules = [
            [$r5600x, $b550, 'compatible', 'Works great together', null],
            [$r5600x, $b650, 'incompatible', 'Socket tidak cocok', 'Ryzen 5600X butuh AM4, ganti motherboard AM4'],
            [$r5600x, $b760, 'incompatible', 'Socket tidak cocok', 'Ryzen 5600X butuh AM4, B760 hanya support LGA1700'],
            [$r7600x, $b650, 'compatible', 'Works great together', null],
            [$r7600x, $b550, 'incompatible', 'Socket tidak cocok', 'Ryzen 7600X butuh AM5, ganti motherboard AM5'],
            [$i5, $b760, 'compatible', 'Works great together', null],
            [$i5, $b550, 'incompatible', 'Socket tidak cocok', 'i5-13600K butuh LGA1700, ganti ke motherboard Intel'],
            [$i3, $b760, 'compatible', 'Works great together', null],
            [$b550, $ddr4, 'compatible', 'Works great together', null],
            [$b550, $ddr5, 'incompatible', 'Tipe RAM tidak cocok', 'B550 hanya support DDR4'],
            [$b650, $ddr5, 'compatible', 'Works great together', null],
            [$b650, $ddr4, 'incompatible', 'Tipe RAM tidak cocok', 'B650 hanya support DDR5'],
            [$b760, $ddr4, 'compatible', 'Works great together', null],
            [$b760, $ddr5, 'compatible', 'Works great together', null],
            [$rtx4060, $psu550, 'compatible', 'Works great together', null],
            [$rtx4060, $psu750, 'compatible', 'Works great together', null],
            [$rtx4070, $psu550, 'warning', 'PSU mungkin kurang bertenaga', 'RTX 4070 butuh minimal 650W, upgrade ke PSU 750W'],
            [$rtx4070, $psu750, 'compatible', 'Works great together', null],
            [$i3, $rtx4070, 'warning', 'Potensi bottleneck terdeteksi', 'i3-12100F akan membatasi RTX 4070, pertimbangkan upgrade ke i5-13600K'],
        ];

        foreach ($rules as [$a, $b, $status, $message, $suggestion]) {
            if (!$a || !$b)
                continue;
            CompatibilityRule::create([
                'id' => Str::uuid(),
                'component_a_id' => $a->id,
                'component_b_id' => $b->id,
                'status' => $status,
                'message' => $message,
                'suggestion' => $suggestion,
            ]);
        }
    }
}
