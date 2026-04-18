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
        // CPUs - AMD AM4
        $r5600x = Component::where('model', 'Ryzen 5 5600X')->first();
        $r5600g = Component::where('model', 'Ryzen 5 5600G')->first();
        $r5700x = Component::where('model', 'Ryzen 7 5700X')->first();
        $r5800x3d = Component::where('model', 'Ryzen 7 5800X3D')->first();
        $r5900x = Component::where('model', 'Ryzen 9 5900X')->first();

        // CPUs - AMD AM5
        $r7600x = Component::where('model', 'Ryzen 5 7600X')->first();
        $r7600 = Component::where('model', 'Ryzen 5 7600')->first();
        $r7700x = Component::where('model', 'Ryzen 7 7700X')->first();
        $r7800x3d = Component::where('model', 'Ryzen 7 7800X3D')->first();
        $r7900x = Component::where('model', 'Ryzen 9 7900X')->first();
        $r7950x3d = Component::where('model', 'Ryzen 9 7950X3D')->first();

        // CPUs - Intel LGA1700
        $i3_12100f = Component::where('model', 'Core i3-12100F')->first();
        $i3_12100 = Component::where('model', 'Core i3-12100')->first();
        $i5_12400f = Component::where('model', 'Core i5-12400F')->first();
        $i5_13400f = Component::where('model', 'Core i5-13400F')->first();
        $i5_13600k = Component::where('model', 'Core i5-13600K')->first();
        $i7_13700k = Component::where('model', 'Core i7-13700K')->first();
        $i9_13900k = Component::where('model', 'Core i9-13900K')->first();

        // CPUs - Intel LGA1851
        $ultra5_245k = Component::where('model', 'Core Ultra 5 245K')->first();
        $ultra7_265k = Component::where('model', 'Core Ultra 7 265K')->first();
        $ultra9_285k = Component::where('model', 'Core Ultra 9 285K')->first();

        // Motherboards - AM4
        $b550_asus = Component::where('model', 'ROG Strix B550-F')->first();
        $b450_msi = Component::where('model', 'B450M Pro-VDH Max')->first();
        $b550_gigabyte = Component::where('model', 'B550 AORUS Elite V2')->first();
        $x570_asrock = Component::where('model', 'X570 Phantom Gaming 4')->first();

        // Motherboards - AM5
        $b650_gigabyte = Component::where('model', 'B650 AORUS Elite AX')->first();
        $b650_msi = Component::where('model', 'MAG B650M Mortar WiFi')->first();
        $x670e_asus = Component::where('model', 'TUF Gaming X670E-Plus WiFi')->first();
        $b650e_asrock = Component::where('model', 'B650E PG Riptide WiFi')->first();

        // Motherboards - LGA1700
        $b760_msi_ddr4 = Component::where('model', 'PRO B760M-A DDR4')->first();
        $b760_msi_ddr5 = Component::where('model', 'PRO B760M-A DDR5')->first();
        $b760_gigabyte = Component::where('model', 'B760 AORUS Elite AX DDR4')->first();
        $z790_asus = Component::where('model', 'ROG Strix Z790-E Gaming WiFi')->first();
        $z790_msi = Component::where('model', 'MAG Z790 Tomahawk WiFi DDR4')->first();
        $b660_asrock = Component::where('model', 'B660M Pro RS DDR4')->first();

        // Motherboards - LGA1851
        $z890_asus = Component::where('model', 'TUF Gaming Z890-Plus WiFi')->first();
        $z890_msi = Component::where('model', 'MAG Z890 Tomahawk WiFi')->first();

        // RAM - DDR4
        $ddr4_corsair_16 = Component::where('model', 'Vengeance LPX DDR4 3200')->first();
        $ddr4_corsair_32 = Component::where('model', 'Vengeance LPX DDR4 3200 32GB')->first();
        $ddr4_gskill_16 = Component::where('model', 'Ripjaws V DDR4 3600')->first();
        $ddr4_gskill_32 = Component::where('model', 'Ripjaws V DDR4 3600 32GB')->first();
        $ddr4_kingston = Component::where('model', 'Fury Beast DDR4 3200')->first();
        $ddr4_team = Component::where('model', 'T-Force Vulcan Z DDR4 3200')->first();

        // RAM - DDR5
        $ddr5_gskill_32 = Component::where('model', 'Trident Z5 DDR5 6000')->first();
        $ddr5_gskill_64 = Component::where('model', 'Trident Z5 DDR5 6000 64GB')->first();
        $ddr5_corsair_32 = Component::where('model', 'Dominator Titanium DDR5 6000')->first();
        $ddr5_kingston = Component::where('model', 'Fury Beast DDR5 5200')->first();
        $ddr5_crucial = Component::where('model', 'Pro DDR5 5600')->first();
        $ddr5_team = Component::where('model', 'T-Force Delta DDR5 6400')->first();

        // GPUs
        $rtx4060 = Component::where('model', 'RTX 4060')->first();
        $rtx4060ti = Component::where('model', 'RTX 4060 Ti')->first();
        $rtx4070 = Component::where('model', 'RTX 4070')->first();
        $rtx4070s = Component::where('model', 'RTX 4070 Super')->first();
        $rtx4070tis = Component::where('model', 'RTX 4070 Ti Super')->first();
        $rtx4080s = Component::where('model', 'RTX 4080 Super')->first();
        $rtx4090 = Component::where('model', 'RTX 4090')->first();
        $gtx1650 = Component::where('model', 'GTX 1650')->first();
        $rtx3060 = Component::where('model', 'RTX 3060')->first();
        $rx7600 = Component::where('model', 'RX 7600')->first();
        $rx7700xt = Component::where('model', 'RX 7700 XT')->first();
        $rx7800xt = Component::where('model', 'RX 7800 XT')->first();
        $rx7900gre = Component::where('model', 'RX 7900 GRE')->first();
        $rx7900xt = Component::where('model', 'RX 7900 XT')->first();
        $rx7900xtx = Component::where('model', 'RX 7900 XTX')->first();

        // PSUs
        $psu450 = Component::where('model', 'CV450')->first();
        $psu550 = Component::where('model', 'CV550')->first();
        $psu650_seasonic = Component::where('model', 'Focus GX-650')->first();
        $psu750 = Component::where('model', 'Focus GX-750')->first();
        $psu850 = Component::where('model', 'Focus GX-850')->first();
        $psu1000_corsair = Component::where('model', 'RM1000x')->first();
        $psu1300 = Component::where('model', 'SuperNOVA 1300 G+')->first();
        $psu650_bequiet = Component::where('model', 'Pure Power 12 M 650W')->first();
        $psu750_cm = Component::where('model', 'MWE Gold 750 V2')->first();
        $psu1000_tt = Component::where('model', 'Toughpower GF3 1000W')->first();

        // Storage
        $nvme_gen4_sn850x = Component::where('model', 'Black SN850X 1TB')->first();
        $nvme_gen5_mp700 = Component::where('model', 'MP700 Pro 2TB')->first();
        $nvme_gen4_samsung_990 = Component::where('model', '990 Pro 2TB')->first();

        // Buat rules
        $rules = [];

        // SECTION 1: CPU ↔ MOTHERBOARD (Socket Compatibility)

        // AMD Ryzen 5600X (AM4) ↔ Motherboards
        $rules[] = [$r5600x, $b550_asus, 'compatible', 'Pasangan optimal untuk Ryzen 5000', null];
        $rules[] = [$r5600x, $b550_gigabyte, 'compatible', 'Pasangan yang bagus', null];
        $rules[] = [$r5600x, $x570_asrock, 'compatible', 'Berjalan di X570, ada banyak fitur', null];
        $rules[] = [$r5600x, $b450_msi, 'compatible', 'Bisa digunakan, butuh update BIOS terlebih dulu', 'Pastikan update BIOS MSI B450M ke versi terbaru sebelum pemasangan Ryzen 5000 series'];
        $rules[] = [$r5600x, $b650_gigabyte, 'incompatible', 'Socket tidak cocok - AM4 vs AM5', 'Ryzen 5600X menggunakan socket AM4. Gunakan motherboard AM4 seperti B550 atau X570'];
        $rules[] = [$r5600x, $b760_msi_ddr4, 'incompatible', 'Socket tidak cocok - AM4 vs LGA1700', 'Ryzen 5600X adalah CPU AMD AM4, tidak kompatibel dengan motherboard Intel LGA1700'];
        $rules[] = [$r5600x, $z890_asus, 'incompatible', 'Socket tidak cocok - AM4 vs LGA1851', 'Ryzen 5600X menggunakan socket AM4, bukan LGA1851'];

        // AMD Ryzen 5600G (AM4, has iGPU)
        $rules[] = [$r5600g, $b550_asus, 'compatible', 'Cocok, iGPU Vega 7 aktif tanpa GPU diskrit', null];
        $rules[] = [$r5600g, $b450_msi, 'compatible', 'Bisa digunakan, update BIOS diperlukan', 'Update BIOS B450 ke AGESA terbaru agar support Ryzen 5000G'];
        $rules[] = [$r5600g, $b650_gigabyte, 'incompatible', 'Socket AM4 tidak kompatibel dengan AM5', 'Ryzen 5600G adalah CPU AM4'];

        // AMD Ryzen 5700X (AM4)
        $rules[] = [$r5700x, $b550_asus, 'compatible', 'Kombinasi seimbang untuk mid-range', null];
        $rules[] = [$r5700x, $x570_asrock, 'compatible', 'Berjalan optimal di X570', null];
        $rules[] = [$r5700x, $b650_gigabyte, 'incompatible', 'Socket tidak cocok', 'Ryzen 5700X butuh motherboard AM4'];

        // AMD Ryzen 5800X3D (AM4) - catatan penting: tidak bisa di-overclock
        $rules[] = [$r5800x3d, $b550_asus, 'compatible', 'Berjalan baik, perlu BIOS terbaru', 'Ryzen 5800X3D tidak support overclocking manual. Gunakan BIOS terbaru untuk stabilitas'];
        $rules[] = [$r5800x3d, $x570_asrock, 'compatible', 'X570 support 3D V-Cache dengan baik', null];
        $rules[] = [$r5800x3d, $b650_gigabyte, 'incompatible', 'Socket AM4 tidak kompatibel dengan AM5', null];

        // AMD Ryzen 9 5900X (AM4)
        $rules[] = [$r5900x, $b550_asus, 'compatible', 'Butuh VRM yang kuat, B550-F sudah memadai', null];
        $rules[] = [$r5900x, $x570_asrock, 'compatible', 'X570 lebih disarankan untuk Ryzen 9', null];
        $rules[] = [$r5900x, $b450_msi, 'warning', 'VRM B450M kurang ideal untuk Ryzen 9', 'Ryzen 9 5900X TDP 105W membutuhkan VRM yang kuat. B450M Pro-VDH mungkin thermal throttle saat full load'];

        // AMD Ryzen 7600X (AM5)
        $rules[] = [$r7600x, $b650_gigabyte, 'compatible', 'Pasangan mainstream AM5 yang bagus', null];
        $rules[] = [$r7600x, $b650_msi, 'compatible', 'Kompatibel, form factor mATX', null];
        $rules[] = [$r7600x, $x670e_asus, 'compatible', 'X670E overkill untuk 7600X, tapi berjalan sempurna', null];
        $rules[] = [$r7600x, $b550_asus, 'incompatible', 'Socket AM5 tidak cocok dengan AM4', 'Ryzen 7600X menggunakan socket AM5. Gunakan motherboard AM5 seperti B650 atau X670'];
        $rules[] = [$r7600x, $b760_msi_ddr4, 'incompatible', 'Socket tidak cocok - AM5 vs LGA1700', 'Ryzen 7600X adalah CPU AMD, tidak kompatibel dengan motherboard Intel'];

        // AMD Ryzen 7600 (AM5)
        $rules[] = [$r7600, $b650_gigabyte, 'compatible', 'Kombinasi hemat daya yang efisien', null];
        $rules[] = [$r7600, $b650_msi, 'compatible', 'Cocok untuk build mATX compact', null];

        // AMD Ryzen 7700X (AM5)
        $rules[] = [$r7700x, $b650_gigabyte, 'compatible', 'Pasangan yang baik', null];
        $rules[] = [$r7700x, $x670e_asus, 'compatible', 'X670E memberikan headroom penuh untuk 7700X', null];
        $rules[] = [$r7700x, $b650e_asrock, 'compatible', 'B650E support PCIe 5.0 untuk SSD kencang', null];

        // AMD Ryzen 7800X3D (AM5) - raja gaming
        $rules[] = [$r7800x3d, $b650_gigabyte, 'compatible', 'Kombinasi terbaik untuk gaming saat ini', null];
        $rules[] = [$r7800x3d, $x670e_asus, 'compatible', 'Berjalan sempurna di X670E', null];
        $rules[] = [$r7800x3d, $b650e_asrock, 'compatible', 'B650E cocok untuk 7800X3D', null];
        $rules[] = [$r7800x3d, $b550_asus, 'incompatible', 'Socket AM5 tidak cocok dengan AM4', null];

        // AMD Ryzen 9 7900X (AM5) - TDP tinggi, perlu VRM kuat
        $rules[] = [$r7900x, $x670e_asus, 'compatible', 'X670E sangat disarankan untuk Ryzen 9', null];
        $rules[] = [$r7900x, $b650_gigabyte, 'warning', 'VRM B650 mungkin terbatas untuk Ryzen 9 7900X', 'Ryzen 9 7900X TDP 170W sangat tinggi. Pantau suhu VRM saat full load, pertimbangkan X670E'];
        $rules[] = [$r7900x, $b650_msi, 'warning', 'mATX dengan TDP 170W berisiko thermal throttle', 'Ryzen 9 7900X tidak disarankan di board mATX entry-level, upgrade ke X670E ATX'];

        // AMD Ryzen 9 7950X3D (AM5) - flagship
        $rules[] = [$r7950x3d, $x670e_asus, 'compatible', 'Pasangan flagship yang sempurna', null];
        $rules[] = [$r7950x3d, $b650_gigabyte, 'warning', 'VRM B650 kurang ideal untuk 7950X3D', 'Ryzen 9 7950X3D TDP 120W tetapi bisa spike tinggi. Gunakan X670E untuk keandalan maksimal'];

        // Intel Core i3-12100F (LGA1700, no iGPU) - WAJIB pakai GPU diskrit
        $rules[] = [$i3_12100f, $b760_msi_ddr4, 'compatible', 'Budget build yang solid', null];
        $rules[] = [$i3_12100f, $b760_gigabyte, 'compatible', 'Berjalan baik dengan DDR4', null];
        $rules[] = [$i3_12100f, $b660_asrock, 'compatible', 'Budget mATX yang cocok', null];
        $rules[] = [$i3_12100f, $z790_asus, 'warning', 'Z790 terlalu mahal untuk i3-12100F', 'Z790 flagship tidak memberikan manfaat berarti untuk i3-12100F. Gunakan B660 atau B760 yang lebih hemat'];
        $rules[] = [$i3_12100f, $b550_asus, 'incompatible', 'Socket LGA1700 tidak cocok dengan AM4', null];
        $rules[] = [$i3_12100f, $b650_gigabyte, 'incompatible', 'Socket LGA1700 tidak cocok dengan AM5', null];
        $rules[] = [$i3_12100f, $z890_asus, 'incompatible', 'LGA1700 tidak kompatibel dengan LGA1851', null];

        // Intel Core i3-12100 (LGA1700, has iGPU UHD 730)
        $rules[] = [$i3_12100, $b760_msi_ddr4, 'compatible', 'Budget starter build dengan iGPU', null];
        $rules[] = [$i3_12100, $b660_asrock, 'compatible', 'Kombinasi budget yang efisien', null];

        // Intel Core i5-12400F (LGA1700, no iGPU)
        $rules[] = [$i5_12400f, $b760_msi_ddr4, 'compatible', 'Mid-range build yang hemat daya', null];
        $rules[] = [$i5_12400f, $b760_gigabyte, 'compatible', 'Berjalan sangat baik dengan DDR4', null];
        $rules[] = [$i5_12400f, $b660_asrock, 'compatible', 'Budget gaming build yang bagus', null];
        $rules[] = [$i5_12400f, $z790_msi, 'warning', 'Z790 terlalu mahal untuk i5-12400F', 'Gunakan B660 atau B760 yang lebih sesuai anggaran dengan i5-12400F'];
        $rules[] = [$i5_12400f, $b550_asus, 'incompatible', 'Socket tidak cocok - LGA1700 vs AM4', null];

        // Intel Core i5-13400F (LGA1700, no iGPU)
        $rules[] = [$i5_13400f, $b760_msi_ddr4, 'compatible', 'Kombinasi gaming mainstream yang bagus', null];
        $rules[] = [$i5_13400f, $b760_gigabyte, 'compatible', 'Berjalan optimal', null];
        $rules[] = [$i5_13400f, $z790_msi, 'warning', 'Z790 overkill untuk i5-13400F yang tidak support overclocking', 'i5-13400F tidak memiliki unlocked multiplier, Z790 tidak memberikan keuntungan overclock. Gunakan B760'];

        // Intel Core i5-13600K (LGA1700, unlocked, has iGPU)
        $rules[] = [$i5_13600k, $b760_msi_ddr4, 'compatible', 'Berjalan, tapi fitur OC terkunci di B760', 'i5-13600K bisa overclocking tetapi B760 tidak mendukung OC CPU. Gunakan Z790 untuk manfaat penuh'];
        $rules[] = [$i5_13600k, $z790_msi, 'compatible', 'Pasangan ideal untuk OC dengan DDR4', null];
        $rules[] = [$i5_13600k, $z790_asus, 'compatible', 'Pasangan premium terbaik untuk OC', null];
        $rules[] = [$i5_13600k, $b550_asus, 'incompatible', 'Socket LGA1700 tidak cocok dengan AM4', null];
        $rules[] = [$i5_13600k, $z890_asus, 'incompatible', 'LGA1700 tidak kompatibel dengan LGA1851', null];

        // Intel Core i7-13700K (LGA1700)
        $rules[] = [$i7_13700k, $z790_msi, 'compatible', 'Pasangan mainstream Z790 yang sangat baik', null];
        $rules[] = [$i7_13700k, $z790_asus, 'compatible', 'Pasangan premium, performa terbaik', null];
        $rules[] = [$i7_13700k, $b760_msi_ddr4, 'warning', 'i7-13700K kehilangan kemampuan OC di B760', 'i7-13700K adalah CPU unlocked (K), tapi B760 tidak mendukung overclocking. Gunakan Z790 untuk performa penuh'];
        $rules[] = [$i7_13700k, $b660_asrock, 'warning', 'B660 VRM kurang ideal untuk i7-13700K 125W', 'TDP i7-13700K mencapai 125W+, VRM B660 entry-level mungkin tidak stabil di full load'];

        // Intel Core i9-13900K (LGA1700) - power hungry
        $rules[] = [$i9_13900k, $z790_asus, 'compatible', 'Pasangan flagship yang optimal', null];
        $rules[] = [$i9_13900k, $z790_msi, 'compatible', 'Z790 Tomahawk bisa handle i9-13900K dengan baik', null];
        $rules[] = [$i9_13900k, $b760_msi_ddr4, 'incompatible', 'B760 tidak mendukung overclocking i9-13900K', 'i9-13900K membutuhkan Z-series chipset untuk OC dan VRM yang kuat. B760 tidak cocok'];
        $rules[] = [$i9_13900k, $b660_asrock, 'incompatible', 'B660 tidak layak untuk i9-13900K', 'i9-13900K TDP 125W+ membutuhkan motherboard Z-series dengan VRM premium. B660 mATX entry-level tidak cukup'];

        // Intel Core Ultra (LGA1851) ↔ Motherboards LGA1851
        $rules[] = [$ultra5_245k, $z890_asus, 'compatible', 'Pasangan yang solid untuk Arrow Lake', null];
        $rules[] = [$ultra5_245k, $z890_msi, 'compatible', 'Berjalan baik dengan Z890', null];
        $rules[] = [$ultra7_265k, $z890_asus, 'compatible', 'Kombinasi LGA1851 terbaik di kelas ini', null];
        $rules[] = [$ultra7_265k, $z890_msi, 'compatible', 'Performa konsisten di Z890 Tomahawk', null];
        $rules[] = [$ultra9_285k, $z890_asus, 'compatible', 'Flagship build LGA1851', null];

        // Intel LGA1851 CPU tidak kompatibel dengan LGA1700 board dan sebaliknya
        $rules[] = [$ultra5_245k, $z790_asus, 'incompatible', 'LGA1851 tidak cocok dengan LGA1700', 'Core Ultra 200 menggunakan socket LGA1851, tidak kompatibel dengan motherboard Z790 (LGA1700)'];
        $rules[] = [$ultra7_265k, $b760_msi_ddr4, 'incompatible', 'LGA1851 tidak cocok dengan LGA1700', null];
        $rules[] = [$i5_13600k, $z890_asus, 'incompatible', 'LGA1700 tidak cocok dengan LGA1851', 'i5-13600K menggunakan socket LGA1700, tidak kompatibel dengan motherboard Z890 (LGA1851)'];
        $rules[] = [$i9_13900k, $z890_asus, 'incompatible', 'LGA1700 tidak cocok dengan LGA1851', null];

        // SECTION 2: MOTHERBOARD ↔ RAM (DDR4 vs DDR5)

        // AM4 Boards hanya support DDR4
        $rules[] = [$b550_asus, $ddr4_corsair_16, 'compatible', 'DDR4 3200MHz berjalan optimal di B550', null];
        $rules[] = [$b550_asus, $ddr4_gskill_16, 'compatible', 'DDR4 3600MHz support XMP di B550', null];
        $rules[] = [$b550_asus, $ddr4_gskill_32, 'compatible', 'DDR4 32GB ideal untuk kreator konten', null];
        $rules[] = [$b550_asus, $ddr5_gskill_32, 'incompatible', 'B550 hanya support DDR4, bukan DDR5', 'Motherboard AM4 B550 hanya mendukung DDR4. Gunakan RAM DDR4 seperti Corsair Vengeance atau G.Skill Ripjaws'];
        $rules[] = [$b550_asus, $ddr5_corsair_32, 'incompatible', 'B550 hanya support DDR4', null];

        $rules[] = [$b450_msi, $ddr4_corsair_16, 'compatible', 'DDR4 3200MHz berjalan di B450', null];
        $rules[] = [$b450_msi, $ddr5_gskill_32, 'incompatible', 'B450 hanya support DDR4', null];

        $rules[] = [$b550_gigabyte, $ddr4_corsair_16, 'compatible', 'DDR4 support penuh di B550', null];
        $rules[] = [$b550_gigabyte, $ddr5_gskill_32, 'incompatible', 'B550 hanya support DDR4', null];

        $rules[] = [$x570_asrock, $ddr4_corsair_16, 'compatible', 'DDR4 berjalan baik di X570', null];
        $rules[] = [$x570_asrock, $ddr4_gskill_16, 'compatible', 'DDR4 3600MHz dengan XMP optimal di X570', null];
        $rules[] = [$x570_asrock, $ddr5_gskill_32, 'incompatible', 'X570 AM4 hanya support DDR4', null];

        // AM5 Boards hanya support DDR5
        $rules[] = [$b650_gigabyte, $ddr5_gskill_32, 'compatible', 'DDR5 6000MHz adalah titik manis untuk AM5', null];
        $rules[] = [$b650_gigabyte, $ddr5_corsair_32, 'compatible', 'DDR5 6000MHz berjalan optimal', null];
        $rules[] = [$b650_gigabyte, $ddr5_kingston, 'compatible', 'DDR5 5200MHz kompatibel', null];
        $rules[] = [$b650_gigabyte, $ddr5_crucial, 'compatible', 'DDR5 5600MHz berjalan baik', null];
        $rules[] = [$b650_gigabyte, $ddr5_team, 'compatible', 'DDR5 6400MHz support di B650', null];
        $rules[] = [$b650_gigabyte, $ddr4_corsair_16, 'incompatible', 'B650 AM5 hanya support DDR5, bukan DDR4', 'Motherboard AM5 B650 hanya mendukung DDR5. Gunakan RAM DDR5 seperti G.Skill Trident Z5 atau Kingston Fury Beast DDR5'];
        $rules[] = [$b650_gigabyte, $ddr4_gskill_16, 'incompatible', 'B650 hanya support DDR5', null];

        $rules[] = [$b650_msi, $ddr5_gskill_32, 'compatible', 'DDR5 6000MHz berjalan di B650M Mortar', null];
        $rules[] = [$b650_msi, $ddr4_corsair_16, 'incompatible', 'B650 AM5 hanya support DDR5', null];

        $rules[] = [$x670e_asus, $ddr5_gskill_32, 'compatible', 'DDR5 6000MHz+, XMP/EXPO aktif sempurna', null];
        $rules[] = [$x670e_asus, $ddr5_gskill_64, 'compatible', '64GB DDR5 ideal untuk workstation AM5', null];
        $rules[] = [$x670e_asus, $ddr4_corsair_16, 'incompatible', 'X670E AM5 hanya support DDR5', null];

        $rules[] = [$b650e_asrock, $ddr5_gskill_32, 'compatible', 'B650E support DDR5 dengan baik', null];
        $rules[] = [$b650e_asrock, $ddr4_corsair_16, 'incompatible', 'B650E hanya support DDR5', null];

        // Intel LGA1700 boards - bervariasi DDR4 atau DDR5 tergantung model
        $rules[] = [$b760_msi_ddr4, $ddr4_corsair_16, 'compatible', 'DDR4 3200MHz berjalan baik di B760', null];
        $rules[] = [$b760_msi_ddr4, $ddr4_gskill_16, 'compatible', 'DDR4 3600MHz dengan XMP aktif', null];
        $rules[] = [$b760_msi_ddr4, $ddr5_gskill_32, 'incompatible', 'MSI PRO B760M-A varian DDR4 tidak support DDR5', 'Pastikan membeli MSI PRO B760M-A varian DDR5 jika ingin menggunakan RAM DDR5'];

        $rules[] = [$b760_msi_ddr5, $ddr5_gskill_32, 'compatible', 'DDR5 berjalan optimal di varian DDR5', null];
        $rules[] = [$b760_msi_ddr5, $ddr5_kingston, 'compatible', 'DDR5 5200MHz kompatibel', null];
        $rules[] = [$b760_msi_ddr5, $ddr4_corsair_16, 'incompatible', 'MSI PRO B760M-A varian DDR5 tidak support DDR4', 'Pastikan membeli MSI PRO B760M-A varian DDR4 jika ingin menggunakan RAM DDR4'];

        $rules[] = [$b760_gigabyte, $ddr4_corsair_16, 'compatible', 'DDR4 berjalan baik di B760 AORUS', null];
        $rules[] = [$b760_gigabyte, $ddr4_gskill_32, 'compatible', 'DDR4 32GB mendukung kerja berat', null];
        $rules[] = [$b760_gigabyte, $ddr5_gskill_32, 'incompatible', 'B760 AORUS Elite AX DDR4 tidak support DDR5', null];

        $rules[] = [$z790_asus, $ddr5_gskill_32, 'compatible', 'DDR5 6000MHz optimal di Z790', null];
        $rules[] = [$z790_asus, $ddr5_gskill_64, 'compatible', 'DDR5 64GB ideal untuk workstation profesional', null];
        $rules[] = [$z790_asus, $ddr4_corsair_16, 'incompatible', 'ROG Strix Z790-E hanya support DDR5', 'Gunakan RAM DDR5 untuk motherboard Z790 ASUS ROG Strix ini'];

        $rules[] = [$z790_msi, $ddr4_corsair_16, 'compatible', 'DDR4 berjalan baik di Z790 Tomahawk DDR4', null];
        $rules[] = [$z790_msi, $ddr4_gskill_32, 'compatible', 'DDR4 32GB ideal untuk produktivitas', null];
        $rules[] = [$z790_msi, $ddr5_gskill_32, 'incompatible', 'MSI MAG Z790 Tomahawk varian DDR4 tidak support DDR5', null];

        $rules[] = [$b660_asrock, $ddr4_corsair_16, 'compatible', 'DDR4 support di B660M Pro RS', null];
        $rules[] = [$b660_asrock, $ddr5_gskill_32, 'incompatible', 'B660M Pro RS DDR4 tidak support DDR5', null];

        // Intel LGA1851 boards (Z890) - hanya DDR5
        $rules[] = [$z890_asus, $ddr5_gskill_32, 'compatible', 'DDR5 6000MHz berjalan optimal di Z890', null];
        $rules[] = [$z890_asus, $ddr5_corsair_32, 'compatible', 'DDR5 6000MHz kompatibel penuh', null];
        $rules[] = [$z890_asus, $ddr4_corsair_16, 'incompatible', 'Z890 Arrow Lake hanya support DDR5', 'Platform LGA1851 Arrow Lake hanya mendukung DDR5. Gunakan RAM DDR5'];
        $rules[] = [$z890_msi, $ddr5_gskill_32, 'compatible', 'DDR5 berjalan baik di Z890 Tomahawk', null];
        $rules[] = [$z890_msi, $ddr4_corsair_16, 'incompatible', 'Z890 Arrow Lake hanya support DDR5', null];

        // SECTION 3: GPU ↔ PSU (Power Requirements)

        // GTX 1650 - tidak perlu konektor daya tambahan (75W dari slot PCIe)
        $rules[] = [$gtx1650, $psu450, 'compatible', 'GTX 1650 tidak butuh konektor daya eksternal, 450W lebih dari cukup', null];
        $rules[] = [$gtx1650, $psu550, 'compatible', 'PSU 550W lebih dari cukup untuk GTX 1650', null];
        $rules[] = [$gtx1650, $psu650_seasonic, 'compatible', 'Overkill tapi berjalan sempurna', null];

        // RTX 3060 TDP 170W, rekomendasi PSU 550W
        $rules[] = [$rtx3060, $psu450, 'warning', 'PSU 450W berisiko untuk RTX 3060', 'RTX 3060 membutuhkan minimal 550W. PSU 450W mungkin tidak stabil saat gaming berat atau overclocking'];
        $rules[] = [$rtx3060, $psu550, 'compatible', 'PSU 550W cukup untuk RTX 3060 dengan CPU hemat daya', null];
        $rules[] = [$rtx3060, $psu650_seasonic, 'compatible', 'PSU 650W ideal untuk sistem dengan RTX 3060', null];
        $rules[] = [$rtx3060, $psu750, 'compatible', 'PSU 750W memberikan headroom yang nyaman', null];

        // RTX 4060 TDP 115W, rekomendasi PSU 550W
        $rules[] = [$rtx4060, $psu450, 'warning', 'PSU 450W terlalu ketat untuk RTX 4060', 'RTX 4060 direkomendasikan minimal 550W. PSU 450W dapat menyebabkan crash saat gaming'];
        $rules[] = [$rtx4060, $psu550, 'compatible', 'RTX 4060 berjalan baik dengan PSU 550W', null];
        $rules[] = [$rtx4060, $psu650_seasonic, 'compatible', 'PSU 650W memberikan margin yang baik untuk RTX 4060', null];
        $rules[] = [$rtx4060, $psu750, 'compatible', 'PSU 750W sangat cukup untuk RTX 4060', null];
        $rules[] = [$rtx4060, $psu850, 'compatible', 'Overkill tapi berjalan sempurna', null];

        // RTX 4060 Ti TDP 165W, rekomendasi PSU 650W
        $rules[] = [$rtx4060ti, $psu450, 'incompatible', 'PSU 450W tidak cukup untuk RTX 4060 Ti', 'RTX 4060 Ti membutuhkan minimal 650W PSU. Upgrade PSU sebelum memasang GPU ini'];
        $rules[] = [$rtx4060ti, $psu550, 'warning', 'PSU 550W berisiko untuk RTX 4060 Ti + sistem penuh', 'RTX 4060 Ti direkomendasikan minimal 650W. PSU 550W mungkin tidak stabil dengan CPU high-end'];
        $rules[] = [$rtx4060ti, $psu650_seasonic, 'compatible', 'PSU 650W cukup untuk RTX 4060 Ti', null];
        $rules[] = [$rtx4060ti, $psu750, 'compatible', 'PSU 750W ideal untuk RTX 4060 Ti', null];

        // RTX 4070 TDP 200W, rekomendasi PSU 650W
        $rules[] = [$rtx4070, $psu450, 'incompatible', 'PSU 450W tidak cukup untuk RTX 4070', 'RTX 4070 membutuhkan minimal 650W. PSU 450W akan menyebabkan shutdown mendadak'];
        $rules[] = [$rtx4070, $psu550, 'warning', 'PSU 550W berisiko untuk RTX 4070', 'RTX 4070 membutuhkan minimal 650W. PSU 550W mungkin tidak stabil, terutama dengan CPU 125W seperti i5-13600K'];
        $rules[] = [$rtx4070, $psu650_seasonic, 'compatible', 'PSU 650W adalah minimum yang direkomendasikan untuk RTX 4070', null];
        $rules[] = [$rtx4070, $psu750, 'compatible', 'PSU 750W ideal untuk RTX 4070 dengan headroom yang baik', null];
        $rules[] = [$rtx4070, $psu850, 'compatible', 'PSU 850W sangat nyaman untuk RTX 4070', null];

        // RTX 4070 Super TDP 220W, rekomendasi PSU 700W
        $rules[] = [$rtx4070s, $psu550, 'incompatible', 'PSU 550W tidak cukup untuk RTX 4070 Super', 'RTX 4070 Super membutuhkan minimal 700W. Upgrade PSU'];
        $rules[] = [$rtx4070s, $psu650_seasonic, 'warning', 'PSU 650W di batas minimum untuk RTX 4070 Super', 'RTX 4070 Super TDP 220W. PSU 650W bisa bekerja tetapi tidak ideal dengan CPU high-end. Gunakan 750W'];
        $rules[] = [$rtx4070s, $psu750, 'compatible', 'PSU 750W cukup untuk RTX 4070 Super', null];
        $rules[] = [$rtx4070s, $psu850, 'compatible', 'PSU 850W ideal untuk sistem dengan RTX 4070 Super', null];

        // RTX 4070 Ti Super TDP 285W, rekomendasi PSU 800W
        $rules[] = [$rtx4070tis, $psu550, 'incompatible', 'PSU 550W jauh dari cukup untuk RTX 4070 Ti Super', 'RTX 4070 Ti Super TDP 285W membutuhkan minimal 800W PSU'];
        $rules[] = [$rtx4070tis, $psu650_seasonic, 'incompatible', 'PSU 650W tidak cukup untuk RTX 4070 Ti Super', 'Upgrade ke PSU minimal 800W untuk RTX 4070 Ti Super'];
        $rules[] = [$rtx4070tis, $psu750, 'warning', 'PSU 750W di batas minimum untuk RTX 4070 Ti Super', 'RTX 4070 Ti Super TDP 285W, PSU 750W mungkin tidak stabil dengan CPU high-end. Gunakan 850W'];
        $rules[] = [$rtx4070tis, $psu850, 'compatible', 'PSU 850W ideal untuk RTX 4070 Ti Super', null];
        $rules[] = [$rtx4070tis, $psu1000_corsair, 'compatible', 'PSU 1000W sangat nyaman untuk RTX 4070 Ti Super', null];

        // RTX 4080 Super TDP 320W, rekomendasi PSU 850W
        $rules[] = [$rtx4080s, $psu750, 'warning', 'PSU 750W terlalu ketat untuk RTX 4080 Super', 'RTX 4080 Super TDP 320W membutuhkan minimal 850W. PSU 750W berisiko crash saat full load'];
        $rules[] = [$rtx4080s, $psu850, 'compatible', 'PSU 850W adalah minimum yang direkomendasikan untuk RTX 4080 Super', null];
        $rules[] = [$rtx4080s, $psu1000_corsair, 'compatible', 'PSU 1000W ideal untuk sistem dengan RTX 4080 Super', null];
        $rules[] = [$rtx4080s, $psu1000_tt, 'compatible', 'PSU 1000W ATX 3.0 sangat direkomendasikan untuk RTX 4080 Super', null];

        // RTX 4090 TDP 450W - monster power
        $rules[] = [$rtx4090, $psu750, 'incompatible', 'PSU 750W tidak cukup untuk RTX 4090', 'RTX 4090 TDP 450W membutuhkan minimal 1000W PSU, terutama dengan CPU high-end'];
        $rules[] = [$rtx4090, $psu850, 'warning', 'PSU 850W terlalu ketat untuk RTX 4090', 'RTX 4090 membutuhkan minimal 1000W. PSU 850W berisiko crash saat gaming berat'];
        $rules[] = [$rtx4090, $psu1000_corsair, 'compatible', 'PSU 1000W cukup untuk RTX 4090 dengan CPU hemat daya', null];
        $rules[] = [$rtx4090, $psu1000_tt, 'compatible', 'PSU 1000W ATX 3.0 sangat direkomendasikan untuk RTX 4090', null];
        $rules[] = [$rtx4090, $psu1300, 'compatible', 'PSU 1300W ideal untuk sistem RTX 4090 + CPU high-end', null];

        // AMD RX 7600 TDP 165W, rekomendasi PSU 550W
        $rules[] = [$rx7600, $psu450, 'warning', 'PSU 450W berisiko untuk RX 7600 dalam sistem penuh', 'RX 7600 TDP 165W. PSU 450W hanya aman untuk sistem sangat hemat daya. Gunakan 550W+'];
        $rules[] = [$rx7600, $psu550, 'compatible', 'PSU 550W cukup untuk RX 7600', null];
        $rules[] = [$rx7600, $psu650_seasonic, 'compatible', 'PSU 650W memberikan headroom yang baik', null];

        // AMD RX 7700 XT TDP 245W, rekomendasi PSU 700W
        $rules[] = [$rx7700xt, $psu550, 'incompatible', 'PSU 550W tidak cukup untuk RX 7700 XT', 'RX 7700 XT TDP 245W membutuhkan minimal 700W PSU'];
        $rules[] = [$rx7700xt, $psu650_seasonic, 'warning', 'PSU 650W terlalu ketat untuk RX 7700 XT', 'RX 7700 XT direkomendasikan 700W. PSU 650W berisiko tidak stabil'];
        $rules[] = [$rx7700xt, $psu750, 'compatible', 'PSU 750W ideal untuk RX 7700 XT', null];

        // AMD RX 7800 XT TDP 263W, rekomendasi PSU 700W
        $rules[] = [$rx7800xt, $psu550, 'incompatible', 'PSU 550W tidak cukup untuk RX 7800 XT', 'RX 7800 XT membutuhkan minimal 700W PSU'];
        $rules[] = [$rx7800xt, $psu650_seasonic, 'warning', 'PSU 650W di batas untuk RX 7800 XT', 'RX 7800 XT TDP 263W, gunakan 750W untuk keandalan penuh'];
        $rules[] = [$rx7800xt, $psu750, 'compatible', 'PSU 750W cocok untuk RX 7800 XT', null];
        $rules[] = [$rx7800xt, $psu850, 'compatible', 'PSU 850W sangat nyaman untuk RX 7800 XT', null];

        // AMD RX 7900 GRE TDP 260W, rekomendasi PSU 750W
        $rules[] = [$rx7900gre, $psu650_seasonic, 'warning', 'PSU 650W berisiko untuk RX 7900 GRE', 'RX 7900 GRE TDP 260W, minimal 750W disarankan'];
        $rules[] = [$rx7900gre, $psu750, 'compatible', 'PSU 750W cukup untuk RX 7900 GRE', null];
        $rules[] = [$rx7900gre, $psu850, 'compatible', 'PSU 850W ideal untuk sistem RX 7900 GRE', null];

        // AMD RX 7900 XT TDP 315W, rekomendasi PSU 800W
        $rules[] = [$rx7900xt, $psu750, 'warning', 'PSU 750W terlalu ketat untuk RX 7900 XT', 'RX 7900 XT TDP 315W, gunakan PSU minimal 850W'];
        $rules[] = [$rx7900xt, $psu850, 'compatible', 'PSU 850W cukup untuk RX 7900 XT', null];
        $rules[] = [$rx7900xt, $psu1000_corsair, 'compatible', 'PSU 1000W sangat ideal untuk RX 7900 XT', null];

        // AMD RX 7900 XTX TDP 355W, rekomendasi PSU 850W
        $rules[] = [$rx7900xtx, $psu750, 'incompatible', 'PSU 750W tidak cukup untuk RX 7900 XTX', 'RX 7900 XTX TDP 355W membutuhkan minimal 850W PSU'];
        $rules[] = [$rx7900xtx, $psu850, 'compatible', 'PSU 850W adalah minimum untuk RX 7900 XTX', null];
        $rules[] = [$rx7900xtx, $psu1000_corsair, 'compatible', 'PSU 1000W ideal untuk sistem RX 7900 XTX', null];
        $rules[] = [$rx7900xtx, $psu1300, 'compatible', 'PSU 1300W sangat nyaman untuk build flagship', null];

        // SECTION 4: CPU ↔ GPU BOTTLENECK (Fakta nyata berdasarkan benchmark)

        // i3-12100F bottleneck dengan GPU high-end
        $rules[] = [$i3_12100f, $rtx4070, 'warning', 'Potensi bottleneck terdeteksi', 'i3-12100F (4-core/8-thread) akan membatasi RTX 4070 secara signifikan di resolusi 1080p. Pertimbangkan upgrade ke i5-13400F atau lebih tinggi'];
        $rules[] = [$i3_12100f, $rtx4070s, 'warning', 'Bottleneck serius di 1080p gaming', 'RTX 4070 Super membutuhkan CPU yang lebih kuat. i3-12100F akan menjadi leher botol yang jelas'];
        $rules[] = [$i3_12100f, $rtx4070tis, 'warning', 'Mismatch besar antara CPU dan GPU', 'i3-12100F akan membatasi RTX 4070 Ti Super hingga 30-40% di game CPU-bound. Upgrade CPU terlebih dahulu'];
        $rules[] = [$i3_12100f, $rtx4080s, 'warning', 'Bottleneck ekstrem tidak disarankan', 'Memasang RTX 4080 Super dengan i3-12100F sangat tidak efisien. Upgrade CPU ke setidaknya i5-13600K atau Ryzen 7'];
        $rules[] = [$i3_12100f, $rtx4090, 'warning', 'Bottleneck parah - mubazir', 'RTX 4090 dengan i3-12100F adalah pemborosan besar. CPU ini akan membatasi GPU hingga 50%+ di banyak game'];
        $rules[] = [$i3_12100f, $rtx4060, 'compatible', 'Pasangan yang seimbang untuk budget gaming', null];
        $rules[] = [$i3_12100f, $rx7600, 'compatible', 'Seimbang untuk 1080p budget gaming', null];

        // i3-12100 (dengan iGPU) - tidak butuh GPU tapi bisa
        $rules[] = [$i3_12100, $rtx4060, 'compatible', 'RTX 4060 + i3-12100 seimbang untuk 1080p', null];
        $rules[] = [$i3_12100, $rtx4070, 'warning', 'i3-12100 akan sedikit membatasi RTX 4070', 'i3-12100 mungkin bottleneck ringan dengan RTX 4070 di game CPU-intensive. Pertimbangkan upgrade CPU'];

        // i5-12400F / i5-13400F - sweet spot untuk mid-range GPU
        $rules[] = [$i5_12400f, $rtx4060, 'compatible', 'Kombinasi 1080p gaming yang sangat seimbang', null];
        $rules[] = [$i5_12400f, $rtx4070, 'compatible', 'Pasangan yang baik untuk 1440p gaming', null];
        $rules[] = [$i5_12400f, $rtx4070s, 'compatible', 'i5-12400F masih memadai untuk RTX 4070 Super di 1440p', null];
        $rules[] = [$i5_12400f, $rtx4070tis, 'warning', 'i5-12400F mulai bottleneck RTX 4070 Ti Super di 1080p', 'Di resolusi 1080p pada game CPU-heavy, i5-12400F akan membatasi RTX 4070 Ti Super. 1440p/4K lebih baik'];
        $rules[] = [$i5_12400f, $rtx4090, 'warning', 'Bottleneck signifikan di 1080p', 'RTX 4090 dengan i5-12400F akan bottleneck di 1080p gaming. Gunakan resolusi 1440p+ untuk minimasi bottleneck'];

        $rules[] = [$i5_13400f, $rtx4060, 'compatible', 'Seimbang sempurna untuk 1080p gaming', null];
        $rules[] = [$i5_13400f, $rtx4070, 'compatible', 'Pasangan solid untuk 1440p gaming', null];
        $rules[] = [$i5_13400f, $rtx4070s, 'compatible', 'Kombinasi yang sangat baik untuk 1440p', null];
        $rules[] = [$i5_13400f, $rtx4070tis, 'warning', 'Sedikit bottleneck di 1080p game CPU-heavy', 'i5-13400F bisa bottleneck ringan RTX 4070 Ti Super di 1080p game seperti CS2. Di 1440p+ lebih seimbang'];
        $rules[] = [$i5_13400f, $rtx4090, 'warning', 'Bottleneck terdeteksi di 1080p', 'i5-13400F tidak ideal dengan RTX 4090. Upgrade ke i7 atau i9 untuk memanfaatkan GPU ini secara penuh'];

        // i5-13600K - sangat baik untuk gaming
        $rules[] = [$i5_13600k, $rtx4070, 'compatible', 'Pasangan gaming 1440p yang sangat baik', null];
        $rules[] = [$i5_13600k, $rtx4070s, 'compatible', 'Kombinasi kencang untuk 1440p gaming', null];
        $rules[] = [$i5_13600k, $rtx4070tis, 'compatible', 'Seimbang baik untuk 1440p dan 4K gaming', null];
        $rules[] = [$i5_13600k, $rtx4080s, 'compatible', 'i5-13600K masih memadai untuk RTX 4080 Super di 1440p+', null];
        $rules[] = [$i5_13600k, $rtx4090, 'warning', 'i5-13600K sedikit membatasi RTX 4090 di 1080p', 'RTX 4090 dengan i5-13600K akan bottleneck di 1080p game CPU-heavy. Gunakan 1440p/4K untuk hasil terbaik'];

        // i7-13700K - hampir tidak ada bottleneck dengan GPU apapun
        $rules[] = [$i7_13700k, $rtx4070tis, 'compatible', 'Kombinasi flagship gaming yang sangat seimbang', null];
        $rules[] = [$i7_13700k, $rtx4080s, 'compatible', 'Pasangan 4K gaming yang sempurna', null];
        $rules[] = [$i7_13700k, $rtx4090, 'compatible', 'Hampir tidak ada bottleneck, pasangan 4K terbaik', null];

        // i9-13900K - flagship, tidak bottleneck GPU apapun
        $rules[] = [$i9_13900k, $rtx4090, 'compatible', 'Kombinasi performa puncak tanpa bottleneck', null];
        $rules[] = [$i9_13900k, $rtx4080s, 'compatible', 'Pasangan workstation dan gaming kelas atas', null];

        // AMD Ryzen 5600X bottleneck
        $rules[] = [$r5600x, $rtx4060, 'compatible', 'Seimbang sangat baik untuk 1080p gaming', null];
        $rules[] = [$r5600x, $rtx4070, 'compatible', 'Pasangan 1440p gaming yang baik', null];
        $rules[] = [$r5600x, $rtx4070s, 'warning', 'Ryzen 5600X mulai bottleneck RTX 4070 Super di 1080p', 'Di 1080p game CPU-heavy, 5600X akan membatasi RTX 4070 Super. Pertimbangkan upgrade CPU atau main di 1440p'];
        $rules[] = [$r5600x, $rtx4070tis, 'warning', 'Mismatch antara Ryzen 5600X dan RTX 4070 Ti Super', 'Ryzen 5600X 6-core akan signifikan bottleneck RTX 4070 Ti Super. Upgrade ke Ryzen 7 atau lebih tinggi'];
        $rules[] = [$r5600x, $rtx4090, 'warning', 'Bottleneck parah, sangat tidak efisien', 'RTX 4090 dengan Ryzen 5600X sangat tidak seimbang. Upgrade CPU ke minimal Ryzen 7 5800X3D'];

        // AMD Ryzen 5800X3D - raja gaming, tidak bottleneck
        $rules[] = [$r5800x3d, $rtx4070, 'compatible', 'Kombinasi gaming 1440p terbaik di kelas AM4', null];
        $rules[] = [$r5800x3d, $rtx4070s, 'compatible', 'Pasangan gaming premium AM4', null];
        $rules[] = [$r5800x3d, $rtx4070tis, 'compatible', 'Seimbang baik untuk 1440p gaming', null];
        $rules[] = [$r5800x3d, $rtx4080s, 'compatible', 'Hampir tidak ada bottleneck berkat 3D V-Cache', null];
        $rules[] = [$r5800x3d, $rtx4090, 'warning', 'Sedikit bottleneck di 1080p game CPU-heavy', 'Meski raja gaming AM4, Ryzen 5800X3D bisa sedikit bottleneck RTX 4090 di 1080p. 1440p/4K optimal'];

        // AMD Ryzen 7800X3D - raja gaming AM5
        $rules[] = [$r7800x3d, $rtx4070tis, 'compatible', 'Kombinasi gaming terbaik yang ada saat ini', null];
        $rules[] = [$r7800x3d, $rtx4080s, 'compatible', 'Hampir tidak ada bottleneck sama sekali', null];
        $rules[] = [$r7800x3d, $rtx4090, 'compatible', 'Pasangan 4K gaming paling seimbang', null];
        $rules[] = [$r7800x3d, $rx7900xtx, 'compatible', 'Kombinasi all-AMD yang sangat seimbang', null];

        // AMD Ryzen 7600X bottleneck dengan GPU sangat high-end
        $rules[] = [$r7600x, $rtx4070, 'compatible', 'Seimbang untuk 1440p gaming', null];
        $rules[] = [$r7600x, $rtx4070s, 'compatible', 'Kombinasi 1440p yang baik', null];
        $rules[] = [$r7600x, $rtx4070tis, 'warning', 'Ryzen 7600X mulai bottleneck RTX 4070 Ti Super di 1080p', 'Di game CPU-heavy 1080p, 7600X bisa membatasi 4070 Ti Super. 1440p lebih optimal'];
        $rules[] = [$r7600x, $rtx4090, 'warning', 'Bottleneck signifikan di 1080p', 'Ryzen 7600X tidak ideal untuk RTX 4090. Pertimbangkan Ryzen 7800X3D untuk pasangan terbaik'];

        // CPU tanpa iGPU dan tidak ada GPU diskrit - tidak bisa boot ke display
        $rules[] = [$r5600x, $b550_asus, 'compatible', null, null]; // sudah ada di atas, skip duplikat
        // Catatan khusus: CPU tanpa iGPU (F-series Intel, non-G AMD) WAJIB pakai GPU diskrit

        // SECTION 5: AMD Ryzen 5600G iGPU rules
        // Ryzen 5600G bisa jalan tanpa GPU diskrit
        $rules[] = [$r5600g, $rtx4060, 'compatible', 'GPU diskrit akan otomatis menggantikan iGPU', null];
        $rules[] = [$r5600g, $rtx4070, 'compatible', 'iGPU Vega 7 tidak aktif saat GPU diskrit terpasang', null];

        // SECTION 6: CPU ↔ COOLER Compatibility
        $nh_d15 = Component::where('model', 'NH-D15')->first();
        $ak620 = Component::where('model', 'AK620')->first();
        $h212 = Component::where('model', 'Hyper 212 Black Edition')->first();
        $lf2_240 = Component::where('model', 'Liquid Freezer II 240')->first();
        $h150i = Component::where('model', 'iCUE H150i Elite LCD XT')->first();
        $darkrock4 = Component::where('model', 'Dark Rock 4')->first();

        // i9-13900K dan i7-13700K butuh cooler yang kuat
        $rules[] = [$i9_13900k, $nh_d15, 'compatible', 'NH-D15 mampu mendinginkan i9-13900K dengan baik', null];
        $rules[] = [$i9_13900k, $h150i, 'compatible', 'AIO 360mm sangat disarankan untuk i9-13900K', null];
        $rules[] = [$i9_13900k, $lf2_240, 'warning', 'AIO 240mm di batas untuk i9-13900K', 'i9-13900K PL2 dapat mencapai 250W+. AIO 240mm cukup tapi suhu akan tinggi. Pertimbangkan 360mm AIO'];
        $rules[] = [$i9_13900k, $h212, 'warning', 'Hyper 212 tidak cukup untuk i9-13900K', 'i9-13900K membutuhkan cooler yang lebih kuat. Hyper 212 single tower tidak mampu mendinginkan dengan optimal'];
        $rules[] = [$i9_13900k, $ak620, 'compatible', 'AK620 dual tower mampu menangani i9-13900K', 'AK620 performa sangat baik tapi suhu mungkin lebih tinggi dari AIO 360mm saat all-core load'];

        $rules[] = [$i7_13700k, $nh_d15, 'compatible', 'NH-D15 sangat memadai untuk i7-13700K', null];
        $rules[] = [$i7_13700k, $h150i, 'compatible', 'AIO 360mm optimal untuk i7-13700K', null];
        $rules[] = [$i7_13700k, $lf2_240, 'compatible', 'AIO 240mm cukup baik untuk i7-13700K', null];
        $rules[] = [$i7_13700k, $h212, 'warning', 'Hyper 212 kurang ideal untuk i7-13700K 125W', 'i7-13700K TDP 125W membutuhkan cooler yang lebih baik dari Hyper 212 untuk performa optimal'];

        $rules[] = [$r7900x, $h150i, 'compatible', 'AIO 360mm sangat diperlukan untuk Ryzen 9 7900X', null];
        $rules[] = [$r7900x, $nh_d15, 'compatible', 'NH-D15 mampu mendinginkan 7900X dengan cukup baik', null];
        $rules[] = [$r7900x, $h212, 'warning', 'Hyper 212 tidak direkomendasikan untuk Ryzen 9 7900X', 'Ryzen 9 7900X TDP 170W membutuhkan cooler yang jauh lebih kuat dari Hyper 212'];
        $rules[] = [$r7900x, $lf2_240, 'warning', 'AIO 240mm di batas untuk Ryzen 9 7900X', 'Ryzen 9 7900X TDP 170W, AIO 240mm bisa kewalahan. Gunakan 360mm AIO'];

        $rules[] = [$r5600x, $h212, 'compatible', 'Hyper 212 cukup untuk Ryzen 5600X 65W', null];
        $rules[] = [$r5600x, $nh_d15, 'compatible', 'Overkill tapi suhu sangat dingin', null];
        $rules[] = [$r5600x, $lf2_240, 'compatible', 'AIO 240mm lebih dari cukup untuk 5600X', null];

        // SECTION 7: GPU + PSU Konektor 16-pin (RTX 40 Series butuh konektor baru)
        // RTX 4090 sangat disarankan PSU ATX 3.0 untuk menghindari kabel meleleh
        $rules[] = [$rtx4090, $psu1000_corsair, 'warning', 'Pastikan adaptador 16-pin aman', 'RTX 4090 menggunakan konektor 16-pin baru. Jika PSU tidak ATX 3.0, gunakan adaptor resmi NVIDIA dan pastikan kabel tidak tertekuk tajam untuk menghindari panas berlebih'];
        $rules[] = [$rtx4090, $psu1000_tt, 'compatible', 'Thermaltake GF3 adalah PSU ATX 3.0, konektor 16-pin native', null];
        $rules[] = [$rtx4090, $psu1300, 'compatible', 'PSU 1300W memberikan headroom sempurna untuk RTX 4090', null];

        // SECTION 8: NVMe Gen 5 butuh motherboard dengan M.2 PCIe 5.0 slot
        $rules[] = [$nvme_gen5_mp700, $z790_asus, 'compatible', 'Z790 memiliki slot M.2 PCIe 5.0 untuk SSD Gen 5', null];
        $rules[] = [$nvme_gen5_mp700, $x670e_asus, 'compatible', 'X670E support M.2 PCIe 5.0 native', null];
        $rules[] = [$nvme_gen5_mp700, $b650_gigabyte, 'warning', 'B650 standar mungkin tidak punya slot M.2 PCIe 5.0', 'Corsair MP700 Pro membutuhkan slot M.2 PCIe 5.0. Periksa spesifikasi motherboard. B650 standar biasanya hanya PCIe 4.0 untuk M.2. SSD akan fallback ke Gen 4 jika tidak ada slot Gen 5'];
        $rules[] = [$nvme_gen5_mp700, $b760_msi_ddr4, 'warning', 'B760 mATX kemungkinan tidak punya slot M.2 PCIe 5.0', 'SSD PCIe Gen 5 akan berjalan di mode PCIe 4.0 jika slot tidak mendukung Gen 5'];
        $rules[] = [$nvme_gen5_mp700, $z890_asus, 'compatible', 'Z890 mendukung NVMe PCIe 5.0 secara native', null];
        $rules[] = [$nvme_gen5_mp700, $z890_msi, 'compatible', 'Z890 Tomahawk punya slot M.2 PCIe 5.0', null];

        // NVMe Gen 4 di board AM4 (PCIe 3.0 M.2) - downgrade tapi tetap jalan
        $rules[] = [$nvme_gen4_samsung_990, $b450_msi, 'warning', 'Samsung 990 Pro Gen 4 di B450 akan berjalan di Gen 3', 'B450 hanya support M.2 PCIe 3.0. Samsung 990 Pro PCIe 4.0 akan fallback ke Gen 3, kehilangan sekitar separuh kecepatan baca/tulis'];

        // SECTION 9: Ryzen 5000 di B450 butuh BIOS update
        $rules[] = [$r5900x, $b450_msi, 'warning', 'Ryzen 9 5900X di B450 butuh BIOS terbaru dulu', 'B450 membutuhkan update BIOS ke AGESA 1.0.8.0+ untuk support Ryzen 5000. Jika ini build baru, Anda butuh CPU lama untuk update BIOS terlebih dulu'];
        $rules[] = [$r5800x3d, $b450_msi, 'incompatible', 'Ryzen 5800X3D tidak support di B450', 'AMD secara resmi tidak mendukung Ryzen 5800X3D (3D V-Cache) di platform B450. Gunakan B550 atau X570'];

        // SECTION 10: Intel K-series perlu Z-series chipset untuk OC
        $rules[] = [$i5_13600k, $b660_asrock, 'warning', 'OC tidak tersedia di chipset B660', 'i5-13600K adalah CPU unlocked tetapi B660 tidak mendukung overclocking CPU. Anda kehilangan fitur utama dari CPU ini. Gunakan Z790'];
        $rules[] = [$i7_13700k, $b660_asrock, 'warning', 'OC tidak tersedia, VRM B660 kurang memadai', 'i7-13700K 125W dengan B660M mATX entry-level berisiko thermal throttle dan tidak bisa OC'];
        $rules[] = [$i9_13900k, $z790_asus, 'compatible', 'Z790 ROG Strix adalah pasangan ideal untuk i9-13900K', null];

        // Filter dan buat rules
        foreach ($rules as [$a, $b, $status, $message, $suggestion]) {
            if (!$a || !$b)
                continue;
            // Hindari duplikat yang sama persis
            $exists = CompatibilityRule::where(function ($q) use ($a, $b) {
                $q->where('component_a_id', $a->id)->where('component_b_id', $b->id);
            })->orWhere(function ($q) use ($a, $b) {
                $q->where('component_a_id', $b->id)->where('component_b_id', $a->id);
            })->exists();

            if ($exists)
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