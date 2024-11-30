<?php

declare(strict_types = 1);

namespace App\Enums;

enum QueuePriority: string
{
    case Low         = 'low';
    case High        = 'high';
    case LongTimeOut = 'long-timeout';
}
