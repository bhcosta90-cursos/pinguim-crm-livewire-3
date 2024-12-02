<?php

declare(strict_types = 1);

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Notifications\Notification;
use OwenIt\Auditing\Contracts\Auditable;

arch()
    ->expect('App')
    ->toUseStrictTypes()
    ->not->toUse(['die', 'dd', 'dump', 'ds']);

arch()
    ->expect('App\Models')
    ->toBeClasses()
    ->toImplement([Auditable::class])
    ->toUseTraits([SoftDeletes::class, OwenIt\Auditing\Auditable::class])
    ->toExtend(Model::class);

arch()
    ->expect('App\Notifications')
    ->toBeClasses()
    ->toImplement([ShouldQueue::class])
    ->toUseTraits([Queueable::class])
    ->toExtend(Notification::class);

arch()
    ->expect('App\Actions')
    ->toHaveMethod('handle')
    ->toHaveLineCountLessThan(100);

arch()
    ->expect('App\Livewire')
    ->toHaveLineCountLessThan(100);

arch()->preset()->php();
arch()->preset()->security()->ignoring('md5');
