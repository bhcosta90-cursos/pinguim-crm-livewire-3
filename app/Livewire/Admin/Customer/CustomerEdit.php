<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Customer;

use App\Models\{Customer};
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{On};
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class CustomerEdit extends Component
{
    use Interactions;

    public CustomerForm $form;

    public bool $slide = false;

    public function render(): View
    {
        return view('livewire.admin.customer.customer-edit');
    }

    #[On('customer::edit')]
    public function loadCustomer(Customer $customer): void
    {
        $this->form->setCustomer($customer);
        $this->form->resetErrorBag();
        $this->slide = true;
    }

    public function submit(): void
    {
        \DB::transaction(function () {
            $this->form->update();
            $this->toast()->success(__('Cliente editado com sucesso!'))->send();
            $this->slide = false;
            $this->dispatch('customer::index');
        });
    }
}
