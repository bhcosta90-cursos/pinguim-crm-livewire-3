<?php

declare(strict_types = 1);

namespace App\Traits\Livewire;

use Illuminate\Database\Eloquent\Model;
use TallStackUi\Traits\Interactions;

trait HasDelete
{
    use Interactions;

    public Model $model;

    abstract protected function model(): string;

    abstract protected function updateList(): string;

    public function render(): string
    {
        return "<div></div>";
    }

    public function confirm(int $model): void
    {
        $this->model = app($this->model())->findOrFail($model);

        $this->dialog()
            ->question(__('Atenção!'), __('Você tem certeza?'))
            ->confirm(__('Confirmar'), 'execute')
            ->cancel(__('Cancelar'))
            ->send();
    }

    public function execute(): void
    {
        $this->authorize('delete', $this->model);
        $this->model->delete();
        $this->toast()->success(__('Exclusão realizada com sucesso'))->send();
        $this->dispatch($this->updateList());
    }

    public function getListeners(): array
    {
        return [
            $this->listener() => 'confirm',
        ];
    }

    protected function listener(): string
    {
        return 'model::delete';
    }
}
