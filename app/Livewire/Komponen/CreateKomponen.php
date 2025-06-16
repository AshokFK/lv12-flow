<?php

namespace App\Livewire\Komponen;

use Flux\Flux;
use Livewire\Component;
use App\Models\Komponen;
use Livewire\Attributes\Validate;

class CreateKomponen extends Component
{
    #[Validate('required', message: 'Nama harus diisi')]
    #[Validate('string', message: 'Nama harus berupa string')]
    #[Validate('min:5', message: 'Nama terlalu pendek')]
    #[Validate('max:100', message: 'Nama terlalu panjang')]
    #[Validate('unique:komponen,nama', message: 'Nama sudah ada')]
    public $nama;

    #[Validate('required', message: 'Type harus diisi')]
    #[Validate('in:tim,bahan', message: 'Type tidak valid')]
    public $type;

    public function save()
    {
        $this->validate();

        try {
            Komponen::create([
                'nama' => $this->nama,
                'type' => $this->type,
            ]);
            $this->reset();
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'Komponen berhasil ditambahkan.');
            $this->dispatch('refresh-list-komponen');
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'Komponen gagal ditambahkan.');
        }
        Flux::modal('create-komponen')->close();
    }

    public function render()
    {
        return view('livewire.komponen.create-komponen');
    }
}
