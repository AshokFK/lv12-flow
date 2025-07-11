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
        $this->authorize('tambah qc');
        $this->validate();
        try {
            Qc::create([
                'nama' => $this->nama,
            ]);
            $this->reset();
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'QC berhasil ditambahkan.');
            $this->dispatch('refresh-list-qc');            
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'QC gagal ditambahkan.');
        }
        Flux::modal('create-qc')->close();
    }
    
    public function render()
    {
        return view('livewire.qc.create-qc');
    }
}
