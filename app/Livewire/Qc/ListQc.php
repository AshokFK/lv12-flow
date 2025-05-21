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
        return Qc::query()
            ->when($this->searchTerm, function ($query) {
                $query->where('nama', 'like', '%' . $this->searchTerm . '%');
            })
            ->when($this->sortColumn, function ($query) {
                $query->orderBy($this->sortColumn, $this->sortDirection);
            })
            ->paginate($this->perPage);
    }

    public function edit($qcId)
    {
        $this->dispatch('edit-qc', $qcId);
    }

    #[On('delete-qc')]
    public function confirmDelete($id)
    {
        $this->qcId = $id;
        Flux::modal('delete-qc')->show();
    }

    public function delete()
    {
        $qc = Qc::findOrFail($this->qcId);

        if ($qc) {
            $qc->delete();
            Flux::modal('delete-qc')->close();
            session()->flash('success', 'Qc berhasil dihapus.');
            $this->reset('qcId');
            $this->redirect(route('list.qc'), navigate: true);
        } 
    }
    
    public function render()
    {
        return view('livewire.qc.list-qc');
    }
}
