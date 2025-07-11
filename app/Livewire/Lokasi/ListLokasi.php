<?php

namespace App\Livewire\Lokasi;

use Flux\Flux;
use App\Models\Lokasi;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Traits\WithTableTools;
use Livewire\Attributes\Computed;

class ListLokasi extends Component
{
    use WithTableTools, WithPagination;

    public $lokasiId;

    #[Computed]
    public function listLokasi()
    {
        $this->authorize('list lokasi');
        return Lokasi::query()
            ->when($this->searchTerm, function ($query) {
                $query->where('nama', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('sub', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('deskripsi', 'like', '%' . $this->searchTerm . '%');
            })
            ->when($this->sortColumn, function ($query) {
                $query->orderBy($this->sortColumn, $this->sortDirection);
            })
            ->paginate($this->perPage);
    }

    #[On('refresh-list-lokasi')]
    public function refreshList()
    {
        unset($this->listLokasi);
    }

    public function edit($lokasiId)
    {
        $this->authorize('edit lokasi');
        $this->dispatch('edit-lokasi', $lokasiId);
    }

    #[On('delete-lokasi')]
    public function confirmDelete($id)
    {
        $this->authorize('hapus lokasi');
        $this->lokasiId = $id;
        Flux::modal('delete-lokasi')->show();
    }

    public function delete()
    {
        $this->authorize('hapus lokasi');
        $lokasi = Lokasi::findOrFail($this->lokasiId);

        try {
            $lokasi->delete();
            $this->reset('lokasiId');
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'Lokasi berhasil dihapus.');
            $this->dispatch('refresh-list-lokasi');
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'Lokasi gagal dihapus.');
        }
        Flux::modal('delete-lokasi')->close();
    }
    
    public function render()
    {
        return view('livewire.lokasi.list-lokasi');
    }
}
