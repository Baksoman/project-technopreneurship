<?php

namespace App\Observers;

use App\Models\Component;
use Illuminate\Support\Str;

class ComponentObserver
{
    public function creating(Component $component): void
    {
        if (empty($component->slug)) {
            $component->slug = $this->generateUniqueSlug($component->name, $component->id);
        }
    }

    public function updating(Component $component): void
    {
        if ($component->isDirty('name') && empty($component->slug)) {
            $component->slug = $this->generateUniqueSlug($component->name, $component->id);
        }
    }

    protected function generateUniqueSlug(string $name, ?string $excludeId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (Component::where('slug', $slug)->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
