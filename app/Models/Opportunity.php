<?php

declare(strict_types = 1);

namespace App\Models;

use App\Traits\Models\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

class Opportunity extends Model implements Auditable
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasSearch;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'title',
        'status',
        'price',
    ];
}
