<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\User;

use App\Enums\Permission\Can;
use App\Models\User;
use App\Traits\Livewire\{HasOrder, HasTaggable};
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\{Attributes\On, Attributes\Url, Component, WithPagination};

class UserIndex extends Component
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
        return view('livewire.admin.user.user-index')->layoutData(['title' => "Users"]);
    }

    public function mount(): void
    {
        $this->authorize('viewAny', User::class);
        $this->setSortColumn('name');
    }

    #[Computed]
    #[On('user::index')]
    public function records(): Paginator
    {
        return User::query()
            ->select(['id', 'name', 'email', 'deleted_at'])
            ->with('permissions:id,name')
            ->when(
                count($this->permissions ?: []),
                fn (Builder $query) => $query->whereHas(
                    'permissions',
                    fn ($query) => $query
                        ->select('permissions.id')
                        ->whereIn('name', $this->permissions)
                )
            )
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
