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
        $this->authorize('list komponen');
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

    #[On('refresh-list-komponen')]
    public function refreshList()
    {
        unset($this->listKomponen);
    }

    public function edit($komponenId)
    {
        $this->authorize('edit komponen');
        $this->dispatch('edit-komponen', $komponenId);
    }

    #[On('delete-komponen')]
    public function confirmDelete($id)
    {
        $this->authorize('hapus komponen');
        $this->komponenId = $id;
        Flux::modal('delete-komponen')->show();
    }

    public function delete()
    {
        $this->authorize('hapus komponen');
        $komponen = Komponen::findOrFail($this->komponenId);

        try {
            $komponen->delete();
            $this->reset('komponenId');
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'Komponen berhasil dihapus.');
            $this->dispatch('refresh-list-komponen');
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'Komponen gagal dihapus.');
        }
        Flux::modal('delete-komponen')->close();
    }

    public function render()
    {
        return view('livewire.komponen.list-komponen');
    }
}
