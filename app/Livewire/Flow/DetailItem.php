<?php

namespace App\Livewire\Flow;

use App\Models\FlowHeader;
use Flux\Flux;
use Livewire\Component;
use App\Models\FlowItem;
use Livewire\Attributes\On;

class DetailItem extends Component
{
    public FlowItem $item;

    #[On('detail-item')]
    public function initDetailItem(FlowItem $item)
    {
        $this->item = $item;

        Flux::modal('detail-item')->show();
    }

    public function render()
    {
        return view('livewire.flow.detail-item');
    }
}
