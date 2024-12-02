<?php

declare(strict_types = 1);

namespace App\Notifications;

use App\Enums\Queue\Priority;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordNotification extends ResetPassword implements ShouldQueue
{
    use Queueable;

    public function __construct(#[\SensitiveParameter] $token)
    {
        $this->onQueue(Priority::High);

        parent::__construct($token);
    }
}
