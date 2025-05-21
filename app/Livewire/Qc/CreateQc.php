<?php

namespace App\Livewire\Qc;

use Flux\Flux;
use App\Models\Qc;
use Livewire\Component;
use Livewire\Attributes\Validate;

class CreateQc extends Component
{
    #[Validate('required', message: 'Nama harus diisi')]
    #[Validate('string', message: 'Nama harus berupa string')]
    #[Validate('min:5', message: 'Nama terlalu pendek')]
    #[Validate('max:100', message: 'Nama terlalu panjang')]
    #[Validate('unique:qc,nama', message: 'Nama sudah ada')]
    public $nama;

    public function save()
    {
        $this->validate();
        
        Qc::create([
            'nama' => $this->nama,
        ]);
        Flux::modal('create-qc')->close();
        session()->flash('success', 'QC berhasil ditambahkan.');
        $this->reset();
        $this->redirect(route('list.qc'), navigate: true);
    }
    
    public function render()
    {
        return view('livewire.qc.create-qc');
    }
}
