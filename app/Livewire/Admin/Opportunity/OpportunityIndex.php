<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Opportunity;

use App\Enums\Permission\Can;
use App\Models\Opportunity;
use App\Traits\Livewire\{HasOrder, HasTaggable};
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\{Attributes\On, Attributes\Url, Component, WithPagination};

class OpportunityIndex extends Component
{
    use WithPagination;
    use HasTaggable;
    use HasOrder;

    public array $search = [
        'title',
    ];

    #[Url]
    public ?array $permissions = [];

    #[Url]
    public ?int $status = null;

    public function render(): View
    {
        return view('livewire.admin.opportunity.opportunity-index')->layoutData(['title' => __('Opportunities')]);
    }

    public function mount(): void
    {
        $this->authorize('viewAny', Opportunity::class);
        $this->setSortColumn('title');
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    #[Computed]
    #[On('opportunity::index')]
    public function records(): Paginator
    {
        return Opportunity::query()
            ->select(['id', 'title', 'deleted_at'])
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->search($this->search, $this->dataFilter)
            ->filterDeletedAt($this->status)
            ->paginate();
    }

    #[Computed]
    public function cans(): array
    {
        return collect(Can::cases())
            ->sortBy(fn ($can) => $can->value)
            ->map(fn ($can) => $can->value)
            ->toArray();
    }
}
