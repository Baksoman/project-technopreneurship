<?php

namespace App\Observers;

use App\Models\ComponentCategory;
use Illuminate\Support\Str;

class ComponentCategoryObserver
{
    public function creating(ComponentCategory $category): void
    {
        if (empty($category->slug)) {
            $category->slug = $this->generateUniqueSlug($category->name, $category->id);
        }
    }

    public function updating(ComponentCategory $category): void
    {
        if ($category->isDirty('name') && empty($category->slug)) {
            $category->slug = $this->generateUniqueSlug($category->name, $category->id);
        }
    }

    protected function generateUniqueSlug(string $name, ?string $excludeId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (ComponentCategory::where('slug', $slug)->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
