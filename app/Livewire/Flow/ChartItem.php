<?php

namespace App\Livewire\Flow;

use Livewire\Component;
use App\Models\FlowHeader;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

class ChartItem extends Component
{
    public FlowHeader $header;
    public $positions;

    #[Computed]
    public function items()
    {
        return $this->header->items()->with('itemable')->get();
    }

    public function savePosition($data)
    {
        $parsedData = json_decode($data);
        // simpan header wrapper width dan height
        $this->header->update([
            'wrapper_width' => $parsedData->header->wrapper_width,
            'wrapper_height' => $parsedData->header->wrapper_height,
        ]);
        // simpan posisi setiap item
        foreach ($parsedData->positions as $item) {
            $flowItem = $this->header->items()->find($item->id);
            if ($flowItem) {
                $flowItem->update([
                    'left' => $item->left,
                    'top' => $item->top,
                ]);
            }
        }
        // dispatch event to notify that the chart has been saved
        $this->dispatch('saved-position');
    }

    public function loadPosition()
    {
        // load posisi setiap item
        $positions = $this->header->items()->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'left' => $item->left,
                'top' => $item->top,
            ];
        });

        // return positions and header wrapper dimensions
        return response()->json([
            'header' => [
                'id' => $this->header->id,
                'wrapper_width' => $this->header->wrapper_width,
                'wrapper_height' => $this->header->wrapper_height,
            ],
            'positions' => $positions,
        ]);
    }

    public function mount(FlowHeader $header)
    {
        $this->header = $header;
        // Load initial positions and dimensions
        $this->positions = $this->loadPosition()->getContent();
        $this->js("
            localStorage.setItem('appState', JSON.stringify($this->positions));
        ");
    }

    #[Layout('components.layouts.flow')]
    #[Title('Flowchart detail')]
    public function render()
    {
        return view('livewire.flow.chart-item');
    }
}
