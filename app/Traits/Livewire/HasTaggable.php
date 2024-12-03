<?php

declare(strict_types = 1);

namespace App\Traits\Livewire;

use Livewire\Attributes\Url;

trait HasTaggable
{
    public ?string $stringFilter = null;

    #[Url]
    public ?array $dataFilter = [];

    public function addFilter(?string $filter = null): void
    {
        if (blank($valueFilter = $this->stringFilter ?: $filter)) {
            $this->dispatch('focusFilterInput');

            return;
        }

        $this->dataFilter   = array_unique(array_merge($this->dataFilter, [$valueFilter]));
        $this->stringFilter = null;
        $this->dispatch('focusFilterInput');

        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
    }

    public function clearFilter(): void
    {
        $this->reset('dataFilter');

        if (method_exists($this, 'resetPage')) {
            $this->resetPage(1);
        }
    }

    public function removeFilter(int $key): void
    {
        unset($this->dataFilter[$key]);
    }
}
