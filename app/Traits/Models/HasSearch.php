<?php

declare(strict_types = 1);

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Builder;

trait HasSearch
{
    public function scopeSearch(Builder $builder, array $search, array $filters): void
    {
        $filters = collect($filters)->filter(fn ($filter) => trim($filter))->toArray();

        if (count($filters) && count($search)) {
            $builder->where(function (Builder $builder) use ($search, $filters) {
                foreach ($filters as $filter) {
                    $builder->orWhereAny($search, 'like', "%{$filter}%");
                }
            });
        }
    }

    public function scopeFilterDeletedAt(Builder $builder, ?int $status): void
    {
        $builder->when($status === 2, fn () => $builder->onlyTrashed())
            ->when($status === 3, fn () => $builder->withTrashed());
    }
}
