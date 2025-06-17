<?php

namespace App\Livewire\Flow;

use App\Models\FlowItem;
use Flux\Flux;
use Livewire\Component;
use App\Models\FlowHeader;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Traits\WithTableTools;
use Livewire\Attributes\Computed;

class ListItem extends Component
{
    use WithTableTools, WithPagination;
    public FlowHeader $header;
    public $itemId;

    public function mount(FlowHeader $header)
    {
        $this->header = $header;
    }

    #[Computed]
    public function listItem()
    {
        return $this->header->items()->with('itemable')
            ->when($this->searchTerm, function ($query) {
                $query->whereHasMorph('itemable', '*', function ($q) {
                    $q->where('nama', 'like', '%' . $this->searchTerm . '%');
                });
            })
            ->when($this->sortColumn, function ($query) {
                $query->orderBy($this->sortColumn, $this->sortDirection);
            })
            ->paginate($this->perPage);
    }

    #[On('refresh-list-item')]
    public function refreshList()
    {
        unset($this->listItem);
    }

    #[On('delete-item')]
    public function confirmDelete($id)
    {
        $this->itemId = $id;
        Flux::modal('delete-item')->show();
    }

    public function delete()
    {
        $item = FlowItem::findOrFail($this->itemId);
        try {
            $item->delete();
            $this->reset('itemId');
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'Item berhasil dihapus.');
            $this->dispatch('refresh-list-item');            
        } catch (\Throwable $th) {
            // throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'Item gagal dihapus.');
        }
        Flux::modal('delete-item')->close();
    }

    public function render()
    {
        return view('livewire.flow.list-item');
    }
}
