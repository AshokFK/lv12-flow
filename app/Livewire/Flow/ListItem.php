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

    #[On('item-updated')]
    public function itemUpdated()
    {
        session()->flash('success', 'Item berhasil diupdate.');
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
        try {
            $item = FlowItem::findOrFail($this->itemId);
            $item->delete();
            Flux::modal('delete-item')->close();
            session()->flash('success', 'item berhasil dihapus.');
            $this->reset('itemId');
            $this->redirect(route('list.item', $this->header->id), navigate: true);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function render()
    {
        return view('livewire.flow.list-item');
    }
}
