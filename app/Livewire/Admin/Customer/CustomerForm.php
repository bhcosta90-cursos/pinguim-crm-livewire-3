<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Customer;

use App\Models\Customer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Form;

class CustomerForm extends Form
{
    use AuthorizesRequests;

    public ?Customer $customer = null;

    public string $name = '';

    public ?string $email = null;

    public ?string $phone = null;

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;

        $this->name  = $customer->name;
        $this->email = $customer->email;
        $this->phone = $customer->phone;
    }

    public function create(): Customer
    {
        $this->authorize('create', Customer::class);
        $this->validate();

        $customer = Customer::create([
            'name'  => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        $this->reset();

        return $customer;
    }

    public function update(): void
    {
        $this->validate();
        $this->authorize('create', $this->customer);

        $this->customer->name  = $this->name;
        $this->customer->email = $this->email;
        $this->customer->phone = $this->phone;

        $this->customer->update();
    }

    public function rules(): array
    {
        return [
            'name'  => 'required|string|min:3|max:200',
            'email' => ['nullable',
                'required_without:phone',
                'email',
                'min:3',
                'max:200',
                Rule::unique(Customer::class, 'email')->ignore($this->customer?->id),
            ],
            'phone' => ['nullable',
                'required_without:email',
                'string',
                Rule::unique(Customer::class, 'phone')->ignore($this->customer?->id)],
        ];
    }
}
