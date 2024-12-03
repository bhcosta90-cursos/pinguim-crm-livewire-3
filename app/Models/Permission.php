<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Relations\MorphTo, SoftDeletes};
use OwenIt\Auditing\Contracts\Auditable;

class Permission extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
