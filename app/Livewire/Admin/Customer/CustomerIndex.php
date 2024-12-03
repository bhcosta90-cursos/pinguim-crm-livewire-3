<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Customer;

use App\Enums\Permission\Can;
use App\Models\Customer;
use App\Traits\Livewire\{HasOrder, HasTaggable};
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\{Attributes\On, Attributes\Url, Component, WithPagination};

class CustomerIndex extends Component
{
    use WithPagination;
    use HasTaggable;
    use HasOrder;

    public array $search = [
        'name',
        'email',
    ];

    #[Url]
    public ?array $permissions = [];

    #[Url]
    public ?int $status = null;

    public function render(): View
    {
        return view('livewire.admin.customer.customer-index')->layoutData(['title' => __('Customers')]);
    }

    public function mount(): void
    {
        $this->authorize('viewAny', Customer::class);
        $this->setSortColumn('name');
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    #[Computed]
    #[On('customer::index')]
    public function records(): Paginator
    {
        return Customer::query()
            ->select(['id', 'name', 'email', 'deleted_at'])
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
