<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Customer;

use App\Models\{Customer};
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CustomerCreate extends Component
{
    public bool $modal = false;

    public ?Customer $customer = null;

    public function render(): View
    {
        return view('livewire.admin.customer.customer-create');
    }

    public function updatedModal(): void
    {
        $this->customer = new Customer();
        $this->resetValidation();
    }

    public function submit(): Customer
    {
        $this->authorize('create', Customer::class);
        $this->validate();

        \DB::transaction(function () {
            $this->customer->save();
            $this->redirectRoute('admin.customer.show', ['customer' => $this->customer]);
        });

        return $this->customer;
    }

    protected function rules(): array
    {
        return [
            'customer.name'  => 'required|string|min:3|max:200',
            'customer.email' => 'nullable|required_without:user.phone|email|min:3|max:200|unique:customers,email',
            'customer.phone' => 'nullable|required_without:email|string|unique:customers,phone',
        ];
    }
}
