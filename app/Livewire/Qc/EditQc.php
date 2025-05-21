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
        $qc = Qc::findOrFail($id);
        $this->qcId = $qc->id;
        $this->nama = $qc->nama;
        $this->is_active = $qc->is_active;
        Flux::modal('edit-qc')->show();
    }

    public function save()
    {
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
        $qc->update([
            'nama' => $this->nama,
            'is_active' => $this->is_active,
        ]);

        Flux::modal('edit-qc')->close();
        session()->flash('success', 'Qc berhasil diperbarui.');
        $this->reset();
        $this->redirect(route('list.qc'), navigate: true);
    }

    public function render()
    {
        return view('livewire.qc.edit-qc');
    }
}
