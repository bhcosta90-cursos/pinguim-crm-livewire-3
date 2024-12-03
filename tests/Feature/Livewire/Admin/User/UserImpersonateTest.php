<?php

declare(strict_types = 1);

use App\Enums\Permission\Can;
use App\Livewire\Admin\User\UserImpersonate;
use App\Models\User;

use function Pest\Laravel\{actingAs, get};
use function Pest\Livewire\livewire;

beforeEach(fn () => actingAs($this->user = User::factory()->withPermission([Can::Impersonate, Can::BeAnAdmin])->create()));

it('should be able to impersonate the user', function () {

    $user = User::factory()->create();

    livewire(UserImpersonate::class)
        ->call('execute', $user)
        ->assertRedirectToRoute('dashboard');

    expect(session()->has('impersonate'))->toBeTrue()
        ->and(session()->get('impersonate'))->toBe($user->id)
        ->and(session()->get('impersonator'))->toBe($this->user->id);
});

it('should make sure that we are logged with the impersonated user', function () {

    expect(auth()->user()->id)->toBe($this->user->id);

    $user = User::factory()->create();

    livewire(UserImpersonate::class)
        ->call('execute', $user)
        ->assertOk();

    get(route('dashboard'))
        ->assertOk()
        ->assertSeeHtml(__('Você está acessando como usuário <span class="font-bold italic">:name</span>, clica aqui para cancelar.', ['name' => $user->name]));

    expect(auth()->user()->id)->toBe($user->id);
});
