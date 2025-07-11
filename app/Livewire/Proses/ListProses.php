<?php

namespace App\Livewire\Proses;

use Flux\Flux;
use App\Models\Proses;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Traits\WithTableTools;
use Livewire\Attributes\Computed;

class ListProses extends Component
{
    use WithTableTools, WithPagination;

    public $prosesId;

    #[Computed]
    public function listProses()
    {
        $this->authorize('list proses');
        return Proses::query()
            ->when($this->searchTerm, function ($query) {
                $query->where('mastercode', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('nama', 'like', '%' . $this->searchTerm . '%');
            })
            ->when($this->sortColumn, function ($query) {
                $query->orderBy($this->sortColumn, $this->sortDirection);
            })
            ->paginate($this->perPage);
    }

    #[On('refresh-list-proses')]
    public function refreshList()
    {
        unset($this->listProses);
    }

    public function edit($prosesId)
    {
        $this->authorize('edit proses');
        $this->dispatch('edit-proses', $prosesId);
    }

    #[On('delete-proses')]
    public function confirmDelete($id)
    {
        $this->authorize('hapus proses');
        $this->prosesId = $id;
        Flux::modal('delete-proses')->show();
    }

    public function delete()
    {
        $this->authorize('hapus proses');
        $proses = Proses::findOrFail($this->prosesId);

        try {
            $proses->delete();
            $this->reset('prosesId');
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'Proses berhasil dihapus.');
            $this->dispatch('refresh-list-proses');
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'Proses gagal dihapus.');
        }
        Flux::modal('delete-proses')->close();
    }
    
    public function render()
    {
        return view('livewire.proses.list-proses');
    }
}
