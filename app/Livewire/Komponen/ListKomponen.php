<?php

namespace App\Livewire\Komponen;

use Flux\Flux;
use Livewire\Component;
use App\Models\Komponen;
use Livewire\Attributes\On;
use App\Traits\WithTableTools;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

class ListKomponen extends Component
{
    use WithTableTools, WithPagination;

    public $komponenId;

    #[Computed]
    public function listKomponen()
    {
        return Komponen::query()
            ->when($this->searchTerm, function ($query) {
                $query->where('nama', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('type', 'like', '%' . $this->searchTerm . '%');
            })
            ->when($this->sortColumn, function ($query) {
                $query->orderBy($this->sortColumn, $this->sortDirection);
            })
            ->paginate($this->perPage);
    }

    public function edit($komponenId)
    {
        $this->dispatch('edit-komponen', $komponenId);
    }

    #[On('delete-komponen')]
    public function confirmDelete($id)
    {
        $this->komponenId = $id;
        Flux::modal('delete-komponen')->show();
    }

    public function delete()
    {
        $komponen = Komponen::findOrFail($this->komponenId);

        if ($komponen) {
            $komponen->delete();
            Flux::modal('delete-komponen')->close();
            session()->flash('success', 'Komponen berhasil dihapus.');
            $this->reset('komponenId');
            $this->redirect(route('list.komponen'), navigate: true);
        } 
    }

    public function render()
    {
        return view('livewire.komponen.list-komponen');
    }
}
