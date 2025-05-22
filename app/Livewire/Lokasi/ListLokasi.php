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

    public function edit($lokasiId)
    {
        $this->dispatch('edit-lokasi', $lokasiId);
    }

    #[On('delete-lokasi')]
    public function confirmDelete($id)
    {
        $this->lokasiId = $id;
        Flux::modal('delete-lokasi')->show();
    }

    public function delete()
    {
        $lokasi = Lokasi::findOrFail($this->lokasiId);

        if ($lokasi) {
            $lokasi->delete();
            Flux::modal('delete-lokasi')->close();
            session()->flash('success', 'Lokasi berhasil dihapus.');
            $this->reset('lokasiId');
            $this->redirect(route('list.lokasi'), navigate: true);
        } 
    }
    
    public function render()
    {
        return view('livewire.lokasi.list-lokasi');
    }
}
