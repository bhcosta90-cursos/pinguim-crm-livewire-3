<?php

declare(strict_types = 1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Models\{HasSearch};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

class Customer extends Authenticatable implements Auditable
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasSearch;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
    ];
}
