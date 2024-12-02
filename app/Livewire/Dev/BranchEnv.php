<?php

declare(strict_types = 1);

namespace App\Livewire\Dev;

use Illuminate\Support\Facades\Process;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class BranchEnv extends Component
{
    public function render(): View
    {
        return view('livewire.dev.branch-env');
    }

    #[Computed]
    public function env(): string
    {
        return config('app.env');
    }

    #[Computed]
    public function branch(): string
    {
        $process = Process::run('git branch --show-current');

        return trim($process->output());
    }
}
