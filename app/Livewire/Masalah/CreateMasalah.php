<?php

namespace App\Livewire\Masalah;

use App\Models\FlowItem;
use Flux\Flux;
use App\Models\Masalah;
use Livewire\Component;
use App\Traits\FetchLokasi;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class CreateMasalah extends Component
{
    use FetchLokasi;

    #[Validate('required', message: 'Item ID harus diisi')]
    #[Validate('exists:flow_item,id', message: 'Item ID tidak ditemukan')]
    public $flowItemId;
    #[Validate('required', message: 'Type harus dipilih')]
    #[Validate('in:orang,mesin,material', message: 'Type tidak valid')]
    public $type;
    #[Validate('required', message: 'Deskripsi harus diisi')]
    #[Validate('min:10', message: 'Deskripsi terlalu singkat')]
    public $deskripsi;

    #[On('create-masalah')]
    public function create(FlowItem $item)
    {
        $this->authorize('tambah masalah');
        $this->flowItemId = $item->id;

        $item_data = FlowItem::with(['itemable'])->find($item->id);

        $this->dispatch('init-selected', item_selected: $item->id, item_data: $item_data->itemable);
    }

    public function save()
    {
        $this->authorize('tambah masalah');
        $this->validate();

        try {
            Masalah::create([
                'flow_item_id' => $this->flowItemId,
                'type' => $this->type,
                'deskripsi' => $this->deskripsi,
            ]);
            $this->reset();
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'Masalah berhasil ditambahkan.');
            $this->dispatch('refresh-list-masalah');
            $this->js('setTimeout(() => location.reload(), 5000);');
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: $th->getMessage());
        }
        Flux::modals()->close();
    }
    public function render()
    {
        return view('livewire.masalah.create-masalah');
    }
}
