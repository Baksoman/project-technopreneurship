<?php

namespace App\Services\Scoring;

use App\Models\Component;

class BottleneckAnalyzer
{
    const BOTTLENECK_THRESHOLD = 20;
    const SEVERE_BOTTLENECK_THRESHOLD = 35;
    const PSU_SAFETY_MARGIN = 0.80;

    public function analyze(array $components): array
    {
        return array_merge(
            $this->analyzeCpuGpuBalance($components),
            $this->analyzePsuCapacity($components),
            $this->analyzeRamBottleneck($components),
        );
    }

    protected function analyzeCpuGpuBalance(array $components): array
    {
        $cpu = $components['cpu'] ?? null;
        $gpu = $components['gpu'] ?? null;
        if (!$cpu || !$gpu) return [];

        $cpuScore = $cpu->performance_score ?? 0;
        $gpuScore = $gpu->performance_score ?? 0;
        $gap = abs($cpuScore - $gpuScore);

        if ($gap >= self::SEVERE_BOTTLENECK_THRESHOLD) {
            $weak = $cpuScore < $gpuScore ? $cpu : $gpu;
            $strong = $cpuScore < $gpuScore ? $gpu : $cpu;
            $weakType = $cpuScore < $gpuScore ? 'CPU' : 'GPU';
            return [[
                'severity' => 'high',
                'type' => 'bottleneck_severe',
                'message' => "{$weakType} terlalu lemah untuk komponen lainnya",
                'detail' => "{$weak->name} akan sangat membatasi performa {$strong->name}. Gap: {$gap} poin.",
                'suggestion' => $cpuScore < $gpuScore ? 'Upgrade CPU atau turunkan GPU' : 'Upgrade GPU atau turunkan CPU',
                'penalty' => 25,
            ]];
        }

        if ($gap >= self::BOTTLENECK_THRESHOLD) {
            $weak = $cpuScore < $gpuScore ? $cpu : $gpu;
            $weakType = $cpuScore < $gpuScore ? 'CPU' : 'GPU';
            return [[
                'severity' => 'medium',
                'type' => 'bottleneck_mild',
                'message' => 'Potensi bottleneck ringan terdeteksi',
                'detail' => "{$weak->name} sedikit membatasi performa build. Gap: {$gap} poin.",
                'suggestion' => 'Build masih oke, tapi bisa lebih optimal dengan menyeimbangkan CPU dan GPU.',
                'penalty' => 10,
            ]];
        }

        return [];
    }

    protected function analyzePsuCapacity(array $components): array
    {
        $psu = $components['psu'] ?? null;
        if (!$psu) return [];

        $psuWatt = $psu->specs['wattage'] ?? 0;
        $totalTdp = collect($components)->filter(fn($c) => $c->tdp !== null)->sum('tdp');
        $requiredWatt = $totalTdp * 1.20;

        if ($requiredWatt > $psuWatt * self::PSU_SAFETY_MARGIN) {
            $recommended = (int) ceil($requiredWatt / 50) * 50;
            return [[
                'severity' => 'high',
                'type' => 'psu_insufficient',
                'message' => 'PSU kurang bertenaga untuk build ini',
                'detail' => "Total TDP ~{$totalTdp}W (dengan overhead: ~{$requiredWatt}W) melebihi batas aman PSU {$psuWatt}W.",
                'suggestion' => "Upgrade ke PSU minimal {$recommended}W.",
                'penalty' => 15,
            ]];
        }

        return [];
    }

    protected function analyzeRamBottleneck(array $components): array
    {
        $ram = $components['ram'] ?? null;
        if (!$ram) return [];

        $capacity = (int) filter_var($ram->specs['capacity'] ?? '0', FILTER_SANITIZE_NUMBER_INT);
        if ($capacity < 16) {
            return [[
                'severity' => 'medium',
                'type' => 'ram_insufficient',
                'message' => 'RAM mungkin kurang untuk penggunaan modern',
                'detail' => "RAM {$capacity}GB bisa terasa kurang untuk multitasking dan gaming modern.",
                'suggestion' => 'Disarankan minimal 16GB RAM.',
                'penalty' => 8,
            ]];
        }

        return [];
    }

    public function calculatePenalty(array $warnings): int
    {
        return collect($warnings)->sum('penalty');
    }
}
