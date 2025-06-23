<?php

namespace App\Livewire\Flow;

use Flux\Flux;
use Livewire\Component;
use App\Models\FlowHeader;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Traits\WithTableTools;
use Livewire\Attributes\Computed;

class ListHeader extends Component
{
    use WithTableTools, WithPagination;

    public $headerId;

    #[Computed]
    public function listHeader()
    {
        return FlowHeader::query()->with(['items','lokasi'])
            ->when($this->searchTerm, function ($query) {
                $query->where('kontrak', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('brand', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('pattern', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('style', 'like', '%' . $this->searchTerm . '%');
            })
            ->when($this->sortColumn, function ($query) {
                $query->orderBy($this->sortColumn, $this->sortDirection);
            })
            ->paginate($this->perPage);
    }

    #[On('refresh-list-header')]
    public function refreshList()
    {
        unset($this->listHeader);
    }

    public function edit($headerId)
    {
        $this->dispatch('edit-header', $headerId);
    }

    #[On('delete-header')]
    public function confirmDelete($id)
    {
        $this->headerId = $id;
        Flux::modal('delete-header')->show();
    }

    public function delete()
    {
        $header = FlowHeader::findOrFail($this->headerId);

        try {
            $header->delete();
            $this->reset('headerId');
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'Header berhasil dihapus.');
            $this->dispatch('refresh-list-header');            
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'Header gagal dihapus.');
        }
        Flux::modal('delete-header')->close();
    }
    
    public function render()
    {
        return view('livewire.flow.list-header');
    }
}
