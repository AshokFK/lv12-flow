<?php

namespace App\Livewire\Flow;

use App\Models\Qc;
use App\Models\Proses;
use Livewire\Component;
use App\Models\Komponen;
use App\Models\FlowHeader;
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

    public function render()
    {
        return view('livewire.flow.list-item');
    }
}
