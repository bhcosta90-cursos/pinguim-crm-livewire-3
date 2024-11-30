<?php

declare(strict_types = 1);

namespace App\Notifications;

use App\Enums\QueuePriority;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordNotification extends ResetPassword implements ShouldQueue
{
    use Queueable;

    public function __construct(#[\SensitiveParameter] $token)
    {
        $this->onQueue(QueuePriority::High);

        parent::__construct($token);
    }
}
