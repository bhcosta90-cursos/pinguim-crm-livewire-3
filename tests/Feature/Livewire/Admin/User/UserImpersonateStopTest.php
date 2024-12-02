<?php

declare(strict_types = 1);

use App\Enums\Permission\Can;
use App\Livewire\Admin\User\{UserImpersonate, UserImpersonateStop};
use App\Models\User;

use function Pest\Laravel\{actingAs, get};
use function Pest\Livewire\livewire;

beforeEach(fn () => actingAs($this->user = User::factory()->withPermission([Can::Impersonate, Can::BeAnAdmin])->create()));

it('should be able to stop impersonation', function () {
    expect(auth()->user()->id)->toBe($this->user->id);

    $user = User::factory()->create();

    livewire(UserImpersonate::class)
        ->call('execute', $user)
        ->assertOk();

    $html = __(
        'Você está acessando como usuário <span class="font-bold italic">:name</span>, clica aqui para cancelar.',
        ['name' => $user->name]
    );

    get(route('dashboard'))
        ->assertOk()
        ->assertSeeHtml($html);

    expect(auth()->user()->id)->toBe($user->id);

    livewire(UserImpersonateStop::class)
        ->call('execute')
        ->assertOk();

    expect(session()->has('impersonate'))->toBeFalse()
        ->and(session()->has('impersonator'))->toBeFalse();

    get(route('dashboard'))
        ->assertOk()
        ->assertDontSeeHtml($html);
});
