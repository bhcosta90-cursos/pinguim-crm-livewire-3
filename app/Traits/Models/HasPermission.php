<?php

declare(strict_types = 1);

namespace App\Traits\Models;

use App\Enums\Permission\Can;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Relations\{MorphToMany};
use Illuminate\Support\Facades\Cache;
use OwenIt\Auditing\Auditable;

trait HasPermission
{
    use Auditable;

    public function permissions(): MorphToMany
    {
        return $this->morphToMany(
            Permission::class,
            'model',
            'model_permissions',
            'model_id',
            'permission_id'
        );
    }

    /**
     * @param Can[] $permissions
     * @return Permission[]
     */
    public function givePermissionTo(array | Can $permissions): array
    {
        if ($permissions instanceof Can) {
            $permissions = [$permissions];
        }

        $modelPermissions = [];

        foreach ($permissions as $permission) {
            $modelPermissions[] = Permission::firstOrCreate([
                'name' => $permission->value,
            ]);
        }

        $this->auditAttach('permissions', $modelPermissions);

        Cache::forget($this->getPermissionCacheKey());
        Cache::rememberForever(
            $this->getPermissionCacheKey(),
            fn () => $this->permissions()->get()
        );

        return $modelPermissions;
    }

    public function hasPermissionTo(Can | string $key): bool
    {
        $pKey = $key instanceof Can
            ? $key->value
            : $key;

        $permissions = Cache::get($this->getPermissionCacheKey(), fn () => $this->permissions()->get());

        return $permissions
            ->where('name', '=', $pKey)
            ->isNotEmpty();
    }

    private function getPermissionCacheKey(): string
    {
        return $this->getTable() . "::{$this->id}::permissions";
    }
}
