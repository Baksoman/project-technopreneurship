<?php

namespace Database\Seeders;

use App\Models\Component;
use App\Models\ComponentCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ComponentSeeder extends Seeder
{
    public function run(): void
    {
        $cpu = ComponentCategory::where('slug', 'cpu')->first();
        $cpus = [
            ['name' => 'AMD Ryzen 5 5600X', 'brand' => 'AMD', 'model' => 'Ryzen 5 5600X', 'base_price' => 1800000, 'tdp' => 65, 'performance_score' => 72, 'specs' => ['cores' => 6, 'threads' => 12, 'base_clock' => '3.7 GHz', 'boost_clock' => '4.6 GHz', 'socket' => 'AM4', 'cache' => '35MB'], 'compatibility_tags' => ['socket:AM4']],
            ['name' => 'AMD Ryzen 5 7600X', 'brand' => 'AMD', 'model' => 'Ryzen 5 7600X', 'base_price' => 2800000, 'tdp' => 105, 'performance_score' => 82, 'specs' => ['cores' => 6, 'threads' => 12, 'base_clock' => '4.7 GHz', 'boost_clock' => '5.3 GHz', 'socket' => 'AM5', 'cache' => '38MB'], 'compatibility_tags' => ['socket:AM5']],
            ['name' => 'Intel Core i5-13600K', 'brand' => 'Intel', 'model' => 'Core i5-13600K', 'base_price' => 3200000, 'tdp' => 125, 'performance_score' => 85, 'specs' => ['cores' => 14, 'threads' => 20, 'base_clock' => '3.5 GHz', 'boost_clock' => '5.1 GHz', 'socket' => 'LGA1700', 'cache' => '44MB'], 'compatibility_tags' => ['socket:LGA1700']],
            ['name' => 'Intel Core i3-12100F', 'brand' => 'Intel', 'model' => 'Core i3-12100F', 'base_price' => 1200000, 'tdp' => 58, 'performance_score' => 58, 'specs' => ['cores' => 4, 'threads' => 8, 'base_clock' => '3.3 GHz', 'boost_clock' => '4.3 GHz', 'socket' => 'LGA1700', 'cache' => '12MB'], 'compatibility_tags' => ['socket:LGA1700']],
        ];
        foreach ($cpus as $item) {
            Component::create(['id' => Str::uuid(), 'category_id' => $cpu->id, ...$item, 'specs' => json_encode($item['specs']), 'compatibility_tags' => json_encode($item['compatibility_tags'])]);
        }

        $gpu = ComponentCategory::where('slug', 'gpu')->first();
        $gpus = [
            ['name' => 'NVIDIA RTX 4060', 'brand' => 'NVIDIA', 'model' => 'RTX 4060', 'base_price' => 4500000, 'tdp' => 115, 'performance_score' => 75, 'specs' => ['vram' => '8GB GDDR6', 'bus_width' => '128-bit', 'boost_clock' => '2460 MHz', 'pcie' => 'PCIe 4.0 x16'], 'compatibility_tags' => ['pcie:4.0', 'psu_min:550']],
            ['name' => 'NVIDIA RTX 4070', 'brand' => 'NVIDIA', 'model' => 'RTX 4070', 'base_price' => 7500000, 'tdp' => 200, 'performance_score' => 88, 'specs' => ['vram' => '12GB GDDR6X', 'bus_width' => '192-bit', 'boost_clock' => '2475 MHz', 'pcie' => 'PCIe 4.0 x16'], 'compatibility_tags' => ['pcie:4.0', 'psu_min:650']],
            ['name' => 'AMD RX 7600', 'brand' => 'AMD', 'model' => 'RX 7600', 'base_price' => 3800000, 'tdp' => 165, 'performance_score' => 70, 'specs' => ['vram' => '8GB GDDR6', 'bus_width' => '128-bit', 'boost_clock' => '2655 MHz', 'pcie' => 'PCIe 4.0 x16'], 'compatibility_tags' => ['pcie:4.0', 'psu_min:550']],
        ];
        foreach ($gpus as $item) {
            Component::create(['id' => Str::uuid(), 'category_id' => $gpu->id, ...$item, 'specs' => json_encode($item['specs']), 'compatibility_tags' => json_encode($item['compatibility_tags'])]);
        }

        $mobo = ComponentCategory::where('slug', 'motherboard')->first();
        $mobos = [
            ['name' => 'ASUS ROG Strix B550-F', 'brand' => 'ASUS', 'model' => 'ROG Strix B550-F', 'base_price' => 2200000, 'tdp' => null, 'performance_score' => 75, 'specs' => ['socket' => 'AM4', 'chipset' => 'B550', 'form_factor' => 'ATX', 'ram_slots' => 4, 'max_ram' => '128GB', 'ram_type' => 'DDR4', 'pcie_slots' => 2], 'compatibility_tags' => ['socket:AM4', 'ram:DDR4', 'form_factor:ATX']],
            ['name' => 'MSI PRO B760M-A', 'brand' => 'MSI', 'model' => 'PRO B760M-A', 'base_price' => 1600000, 'tdp' => null, 'performance_score' => 65, 'specs' => ['socket' => 'LGA1700', 'chipset' => 'B760', 'form_factor' => 'mATX', 'ram_slots' => 2, 'max_ram' => '64GB', 'ram_type' => 'DDR4/DDR5', 'pcie_slots' => 1], 'compatibility_tags' => ['socket:LGA1700', 'ram:DDR4', 'ram:DDR5', 'form_factor:mATX']],
            ['name' => 'Gigabyte B650 AORUS Elite AX', 'brand' => 'Gigabyte', 'model' => 'B650 AORUS Elite AX', 'base_price' => 3100000, 'tdp' => null, 'performance_score' => 80, 'specs' => ['socket' => 'AM5', 'chipset' => 'B650', 'form_factor' => 'ATX', 'ram_slots' => 4, 'max_ram' => '192GB', 'ram_type' => 'DDR5', 'pcie_slots' => 2], 'compatibility_tags' => ['socket:AM5', 'ram:DDR5', 'form_factor:ATX']],
        ];
        foreach ($mobos as $item) {
            Component::create(['id' => Str::uuid(), 'category_id' => $mobo->id, ...$item, 'specs' => json_encode($item['specs']), 'compatibility_tags' => json_encode($item['compatibility_tags'])]);
        }

        $ram = ComponentCategory::where('slug', 'ram')->first();
        $rams = [
            ['name' => 'Corsair Vengeance 16GB DDR4 3200MHz', 'brand' => 'Corsair', 'model' => 'Vengeance DDR4 3200', 'base_price' => 650000, 'tdp' => 5, 'performance_score' => 65, 'specs' => ['capacity' => '16GB', 'type' => 'DDR4', 'speed' => '3200MHz', 'modules' => '2x8GB', 'latency' => 'CL16'], 'compatibility_tags' => ['ram:DDR4']],
            ['name' => 'G.Skill Trident Z5 32GB DDR5 6000MHz', 'brand' => 'G.Skill', 'model' => 'Trident Z5 DDR5 6000', 'base_price' => 1800000, 'tdp' => 8, 'performance_score' => 85, 'specs' => ['capacity' => '32GB', 'type' => 'DDR5', 'speed' => '6000MHz', 'modules' => '2x16GB', 'latency' => 'CL30'], 'compatibility_tags' => ['ram:DDR5']],
        ];
        foreach ($rams as $item) {
            Component::create(['id' => Str::uuid(), 'category_id' => $ram->id, ...$item, 'specs' => json_encode($item['specs']), 'compatibility_tags' => json_encode($item['compatibility_tags'])]);
        }

        $psu = ComponentCategory::where('slug', 'psu')->first();
        $psus = [
            ['name' => 'Corsair CV550 550W 80+ Bronze', 'brand' => 'Corsair', 'model' => 'CV550', 'base_price' => 650000, 'tdp' => null, 'performance_score' => 60, 'specs' => ['wattage' => 550, 'efficiency' => '80+ Bronze', 'modular' => 'Non-modular', 'form_factor' => 'ATX'], 'compatibility_tags' => ['psu_watt:550', 'form_factor:ATX']],
            ['name' => 'Seasonic Focus GX-750 750W 80+ Gold', 'brand' => 'Seasonic', 'model' => 'Focus GX-750', 'base_price' => 1350000, 'tdp' => null, 'performance_score' => 85, 'specs' => ['wattage' => 750, 'efficiency' => '80+ Gold', 'modular' => 'Full-modular', 'form_factor' => 'ATX'], 'compatibility_tags' => ['psu_watt:750', 'form_factor:ATX']],
        ];
        foreach ($psus as $item) {
            Component::create(['id' => Str::uuid(), 'category_id' => $psu->id, ...$item, 'specs' => json_encode($item['specs']), 'compatibility_tags' => json_encode($item['compatibility_tags'])]);
        }

        $storage = ComponentCategory::where('slug', 'storage')->first();
        $storages = [
            ['name' => 'Samsung 970 EVO Plus 1TB NVMe', 'brand' => 'Samsung', 'model' => '970 EVO Plus 1TB', 'base_price' => 950000, 'tdp' => 6, 'performance_score' => 85, 'specs' => ['capacity' => '1TB', 'type' => 'NVMe SSD', 'interface' => 'M.2 PCIe 3.0', 'read_speed' => '3500 MB/s', 'write_speed' => '3300 MB/s'], 'compatibility_tags' => ['storage:nvme', 'storage:m2']],
            ['name' => 'WD Blue SN580 1TB NVMe', 'brand' => 'Western Digital', 'model' => 'Blue SN580 1TB', 'base_price' => 750000, 'tdp' => 5, 'performance_score' => 78, 'specs' => ['capacity' => '1TB', 'type' => 'NVMe SSD', 'interface' => 'M.2 PCIe 4.0', 'read_speed' => '4150 MB/s', 'write_speed' => '4150 MB/s'], 'compatibility_tags' => ['storage:nvme', 'storage:m2']],
        ];
        foreach ($storages as $item) {
            Component::create(['id' => Str::uuid(), 'category_id' => $storage->id, ...$item, 'specs' => json_encode($item['specs']), 'compatibility_tags' => json_encode($item['compatibility_tags'])]);
        }
    }
}
