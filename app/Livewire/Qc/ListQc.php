<?php

namespace App\Livewire\Qc;

use Flux\Flux;
use App\Models\Qc;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Traits\WithTableTools;
use Livewire\Attributes\Computed;

class ListQc extends Component
{
    use WithTableTools, WithPagination;

    public $qcId;

    #[Computed]
    public function listQc()
    {
        $this->authorize('list qc');
        return Qc::query()
            ->when($this->searchTerm, function ($query) {
                $query->where('nama', 'like', '%' . $this->searchTerm . '%');
            })
            ->when($this->sortColumn, function ($query) {
                $query->orderBy($this->sortColumn, $this->sortDirection);
            })
            ->paginate($this->perPage);
    }

    #[On('refresh-list-qc')]
    public function refreshList()
    {
        unset($this->listQc);
    }

    public function edit($qcId)
    {
        $this->authorize('edit qc');
        $this->dispatch('edit-qc', $qcId);
    }

    #[On('delete-qc')]
    public function confirmDelete($id)
    {
        $this->authorize('hapus qc');
        $this->qcId = $id;
        Flux::modal('delete-qc')->show();
    }

    public function delete()
    {
        $this->authorize('hapus qc');
        $qc = Qc::findOrFail($this->qcId);
        try {
            $qc->delete();
            $this->reset('qcId');
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'QC berhasil dihapus.');
            $this->dispatch('refresh-list-qc');
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'QC gagal dihapus.');
        }
        Flux::modal('delete-qc')->close();
    }
    
    public function render()
    {
        return view('livewire.qc.list-qc');
    }
}
