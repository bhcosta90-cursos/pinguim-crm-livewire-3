<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Customer;

use App\Models\{Customer};
use App\Traits\Livewire\{HasOrder, HasTaggable};
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{Computed, On, Url};
use Livewire\{Component, WithPagination};

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
        return view('livewire.admin.customer.customer-index');
    }

    public function mount(): void
    {
        $this->authorize('viewAny', Customer::class);
        $this->setSortColumn('name');
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
}
