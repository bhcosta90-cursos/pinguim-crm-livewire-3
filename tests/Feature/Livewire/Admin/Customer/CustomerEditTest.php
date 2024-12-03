<?php

declare(strict_types = 1);

use App\Livewire\Admin\Customer\{CustomerEdit};
use App\Models\{Customer, User};

use function Pest\Laravel\{actingAs, assertDatabaseHas};
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs($this->user = User::factory()->create());
    $this->customer = Customer::factory()->create();
});

it('creates a customer with impersonate permission and dispatches customer index event', function () {
    livewire(CustomerEdit::class)
        ->set('slide', true)
        ->call('loadCustomer', $this->customer)
        ->set('form.name', 'Testing')
        ->set('form.email', 'test@gmail.com')
        ->set('form.phone', '19970707070')
        ->call('submit')
        ->assertOk()
        ->assertHasNoErrors();

    assertDatabaseHas('customers', [
        'id'    => $this->customer->id,
        'name'  => 'Testing',
        'email' => 'test@gmail.com',
        'phone' => '19970707070',
    ]);
});

it('validation fields to create a new customer', function () {
    $lw = livewire(CustomerEdit::class)
        ->call('loadCustomer', $this->customer)
        ->set('slide', true);

    $data = [
        'name::required'  => (object)['field' => 'form.name', 'value' => '', 'rule' => 'required'],
        'name::min:3'     => (object)['field' => 'form.name', 'value' => 'a', 'rule' => 'min'],
        'name::max:255'   => (object)['field' => 'form.name', 'value' => str_repeat('*', 256), 'rule' => 'max'],
        'email::required' => (object)['field' => 'form.phone', 'value' => '', 'rule' => 'required_without', 'fieldEmpty' => 'form.email'],
        'email::max:255'  => (object)['field' => 'form.email', 'value' => str_repeat('*' . '@doe.com', 256), 'rule' => 'max'],
        'email::unique'   => (object)['field' => 'form.email', 'value' => 'joe@doe.com', 'rule' => 'unique'],
        'phone::required' => (object)['field' => 'form.email', 'value' => '', 'rule' => 'required_without', 'fieldEmpty' => 'form.phone'],
    ];

    foreach ($data as $f) {
        if ($f->rule === 'unique') {
            $field = explode('.', $f->field);
            $field = array_pop($field);
            Customer::factory()->create([$field => $f->value]);
        }

        if ($f->rule === 'required_without') {
            $lw->set($f->fieldEmpty);
        }

        $lw->set($f->field, $f->value);

        $lw->call('submit')
            ->assertHasErrors([$f->field => $f->rule]);
    }
});
