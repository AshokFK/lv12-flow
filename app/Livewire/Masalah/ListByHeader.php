<?php

namespace App\Livewire\Masalah;

use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use App\Models\FlowHeader;
use Livewire\Attributes\On;

class ListByHeader extends Component
{
    public $listMasalah = [];

    #[On('list-by-header')]
    public function initListMasalah(FlowHeader $header)
    {
        $this->listMasalah = $header->items
            ->flatMap(function ($item) {
                return $item->masalah;
            })
            ->map(function ($masalah) {
                return [
                    'id' => $masalah->id,
                    'type' => $masalah->type,
                    'deskripsi' => $masalah->deskripsi,
                    'done_at' => $masalah->done_at,
                    'mastercode' => $masalah->flowItem->itemable->mastercode,
                    'proses' => $masalah->flowItem->itemable->nama,
                ];
            })->sortByDesc('id');

        Flux::modal('list-by-header')->show();
    }

    public function render()
    {
        return view('livewire.masalah.list-by-header');
    }
}
