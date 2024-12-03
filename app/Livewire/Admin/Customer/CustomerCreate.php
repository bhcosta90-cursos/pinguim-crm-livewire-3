<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Customer;

use App\Models\{Customer};
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CustomerCreate extends Component
{
    public bool $slide = false;

    public CustomerForm $form;

    public function render(): View
    {
        return view('livewire.admin.customer.customer-create');
    }

    public function updatedSlide(): void
    {
        $this->form->reset('name', 'email', 'phone');
        $this->form->resetErrorBag();
    }

    public function submit(): Customer
    {
        return \DB::transaction(function () {
            $customer = $this->form->create();
            $this->redirectRoute('admin.customer.show', ['customer' => $customer]);

            return $customer;
        });
    }
}
