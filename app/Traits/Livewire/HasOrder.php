<?php

declare(strict_types = 1);

namespace App\Traits\Livewire;

use Livewire\Attributes\Url;

trait HasOrder
{
    #[Url]
    public ?string $sortDirection = 'asc';

    #[Url]
    public ?string $sortColumn = 'id';

    public function sortBy(string $column, string $direction): void
    {
        $this->sortColumn    = $column;
        $this->sortDirection = $direction;
    }

    protected function setSortColumn(string $field): void
    {
        $this->sortColumn = request('sortColumn', $field);
    }
}
