<?php

declare(strict_types = 1);

namespace App\Traits\Models;

use App\Enums\Permission\Can;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Relations\{MorphToMany};

trait HasPermission
{
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
     * @return void
     */
    public function givePermissionTo(array | Can $permissions): void
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

        $this->permissions()->attach($modelPermissions);
    }
}
