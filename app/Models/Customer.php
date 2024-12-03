<?php

declare(strict_types = 1);

namespace App\Models;

use App\Traits\Models\HasSearch;
use Illuminate\Database\Eloquent\{Factories\HasFactory, Model, SoftDeletes};
use OwenIt\Auditing\Contracts\Auditable;

class Customer extends Model implements Auditable
{
    use SoftDeletes;
    use HasFactory;
    use SoftDeletes;
    use HasSearch;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
    ];
}
