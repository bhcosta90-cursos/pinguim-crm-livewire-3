<?php

declare(strict_types = 1);

namespace App\Actions\Admin\Layout;

use Illuminate\Contracts\Auth\Access\Authorizable;

class VerifyMenuAction
{
    public function __construct(protected ?Authorizable $user, public ?string $route = null)
    {
    }

    public function handle(array $menu): array
    {
        if ($this->user === null) {
            return [];
        }

        return $this->verifyMenu($menu);
    }

    protected function verifyMenu($menu): array
    {
        $newMenu = [];

        foreach ($menu as $item) {
            if ($item['submenu'] ?? null) {
                $subMenu = collect($this->verifyMenu($item['submenu']));

                if ($subMenu->count() === 0) {
                    unset($item);

                    continue;
                }

                if ($subMenu->filter(fn ($item) => $item['open'] ?? false)->count() > 0) {
                    $item['open'] = true;
                }

                $newMenu[] = [
                    'submenu' => $subMenu->toArray(),
                ] + $item;

            } else {
                $permission = !isset($item['permission']) || $this->user->can(...$item['permission']);

                if ($permission === false) {
                    unset($item);

                    continue;
                }

                if (($item['route'] ?? null) && $this->route === $item['route']) {
                    $item['open'] = true;
                }
                $newMenu[] = $item;
            }
        }

        return $newMenu;
    }
}
