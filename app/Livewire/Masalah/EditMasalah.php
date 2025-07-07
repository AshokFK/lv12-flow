<?php

namespace App\Livewire\Masalah;

use Flux\Flux;
use App\Models\Masalah;
use Livewire\Component;
use App\Models\FlowItem;
use Livewire\Attributes\On;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class EditMasalah extends Component
{
    public $masalahId;
    public $flowItemId;
    public $type;
    public $deskripsi;
    public $penanganan;
    public $doneAt;
    public $isDone = false;

    #[On('edit-masalah')]
    public function edit($id)
    {
        $masalah = Masalah::findOrFail($id);
        // dd($masalah);
        $this->masalahId = $masalah->id;
        $this->flowItemId = $masalah->flow_item_id;
        $this->type = $masalah->type;
        $this->deskripsi = $masalah->deskripsi;
        $this->penanganan = $masalah->penanganan;
        $this->doneAt = $masalah->done_at;

        $item_data = FlowItem::with(['itemable'])->find($this->flowItemId);

        $this->dispatch('init-selected', item_selected: $this->flowItemId, item_data: $item_data->itemable);

        Flux::modal('edit-masalah')->show();
    }

    public function save()
    {
        $this->validate([
            'type' => ['required','in:orang,mesin,material'],
            'deskripsi' => ['required', 'min:10'],
            'penanganan' => ['nullable', Rule::requiredIf($this->isDone), 'min:10' ],
        ], [
            'type.required' => 'Type harus dipilih',
            'type.in' => 'Type tidak valid',
            'deskripsi.required' => 'Deskripsi harus diisi',
            'deskripsi.min' => 'Deskripsi terlalu singkat',
            'penanganan.required' => 'Penanganan harus diisi',
            'penanganan.min' => 'Penanganan terlalu pendek',
        ]);
        
        $masalah = Masalah::find($this->masalahId);
        // dd($masalah);
        try {
            $masalah->update([
                'type' => $this->type,
                'deskripsi' => $this->deskripsi,
                'penanganan' => $this->penanganan,
                'done_at' => $this->isDone ? Carbon::now() : null,
                'is_active' => !$this->isDone,
            ]);
            $this->reset();
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'Masalah berhasil diperbarui.');
            $this->dispatch('refresh-list-masalah');
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'Masalah gagal diperbarui.');
        }

        Flux::modal('edit-masalah')->close();
    }
    
    public function render()
    {
        return view('livewire.masalah.edit-masalah');
    }
}
