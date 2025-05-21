<?php

namespace App\Livewire\Komponen;

use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\Komponen;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class EditKomponen extends Component
{
    public $komponenId;
    public $nama;
    public $type;
    public $is_active;

    #[On('edit-komponen')]
    public function edit($id)
    {
        $komponen = Komponen::findOrFail($id);
        $this->komponenId = $komponen->id;
        $this->nama = $komponen->nama;
        $this->type = $komponen->type;
        $this->is_active = $komponen->is_active;
        Flux::modal('edit-komponen')->show();
    }

    public function save()
    {
        $this->validate([ 
            'nama' => ['required', Rule::unique('komponen')->ignore($this->komponenId), 'string', 'min:5', 'max:100'],
            'type' => ['required', 'in:tim,bahan'],
            'is_active' => ['boolean'],
        ], [
            'nama.required' => 'Nama harus diisi',
            'nama.string' => 'Nama harus berupa string',
            'nama.min' => 'Nama terlalu pendek',
            'nama.max' => 'Nama terlalu panjang',
            'nama.unique' => 'Nama sudah ada',
            'type.required' => 'Type harus diisi',
            'type.in' => 'Type tidak valid',
            'is_active.boolean' => 'Status aktif tidak valid',
        ]);

        $komponen = Komponen::findOrFail($this->komponenId);
        $komponen->update([
            'nama' => $this->nama,
            'type' => $this->type,
            'is_active' => $this->is_active,
        ]);

        Flux::modal('edit-komponen')->close();
        session()->flash('success', 'Komponen berhasil diperbarui.');
        $this->reset();
        $this->redirect(route('list.komponen'), navigate: true);
    }

    public function render()
    {
        return view('livewire.komponen.edit-komponen');
    }
}
