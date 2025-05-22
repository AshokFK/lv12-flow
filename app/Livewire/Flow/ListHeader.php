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
        return FlowHeader::query()
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

        if ($header) {
            $header->delete();
            Flux::modal('delete-header')->close();
            session()->flash('success', 'Data Flow Header berhasil dihapus.');
            $this->reset('headerId');
            $this->redirect(route('list.header'), navigate: true);
        } 
    }
    
    public function render()
    {
        return view('livewire.flow.list-header');
    }
}
