<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Customer;

use App\Models\{Customer};
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\{On};
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class CustomerEdit extends Component
{
    use Interactions;

    public ?Customer $customer = null;

    public bool $slide = false;

    public function render(): View
    {
        return view('livewire.admin.customer.customer-edit');
    }

    #[On('customer::edit')]
    public function loadCustomer(Customer $customer): void
    {
        $this->customer = $customer;
        $this->slide    = true;
    }

    public function submit(): void
    {
        $this->authorize('edit', [$this->customer, $this->customer]);
        $this->validate();

        \DB::transaction(function () {
            $this->customer->save();
            $this->toast()->success(__('Cliente editado com sucesso!'))->send();
            $this->slide = false;
            $this->dispatch('customer::index');
        });
    }

    protected function rules(): array
    {
        return [
            'customer.name'  => 'required|string|min:3|max:200',
            'customer.email' => ['nullable',
                'required_without:user.phone',
                'email',
                'min:3',
                'max:200',
                Rule::unique(Customer::class, 'email')->ignore($this->customer->id),
            ],
            'customer.phone' => ['nullable',
                'required_without:email',
                'string',
                Rule::unique(Customer::class, 'phone')->ignore($this->customer->id)],
        ];
    }
}
