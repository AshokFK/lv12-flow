<?php

namespace App\Livewire\Qc;

use Flux\Flux;
use App\Models\Qc;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;

class EditQc extends Component
{
    public $qcId;
    public $nama;
    public $is_active;

    #[On('edit-qc')]
    public function edit($id)
    {
        $this->authorize('edit qc');
        $qc = Qc::findOrFail($id);
        $this->qcId = $qc->id;
        $this->nama = $qc->nama;
        $this->is_active = $qc->is_active;
        Flux::modal('edit-qc')->show();
    }

    public function save()
    {
        $this->authorize('edit qc');
        $this->validate([ 
            'nama' => ['required', Rule::unique('qc')->ignore($this->qcId), 'string', 'min:5', 'max:100'],
            'is_active' => ['boolean'],
        ], [
            'nama.required' => 'Nama harus diisi',
            'nama.string' => 'Nama harus berupa string',
            'nama.min' => 'Nama terlalu pendek',
            'nama.max' => 'Nama terlalu panjang',
            'nama.unique' => 'Nama sudah ada',
            'is_active.boolean' => 'Status aktif tidak valid',
        ]);

        $qc = Qc::findOrFail($this->qcId);
        try {
            $qc->update([
                'nama' => $this->nama,
                'is_active' => $this->is_active,
            ]);
            $this->reset();
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'QC berhasil diperbarui.');
            $this->dispatch('refresh-list-qc');
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'QC gagal diperbarui.');
        }
        Flux::modal('edit-qc')->close();
    }

    public function render()
    {
        return view('livewire.qc.edit-qc');
    }
}
