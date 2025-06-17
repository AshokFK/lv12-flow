<?php

namespace App\Livewire\Lokasi;

use Flux\Flux;
use App\Models\Lokasi;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Validator;

class CreateLokasi extends Component
{
    #[Validate('required', message: 'Nama harus diisi')]
    #[Validate('string', message: 'Nama harus berupa string')]
    #[Validate('size:3', message: 'Nama harus :size karakter')]
    public $nama;

    #[Validate('nullable|size:3', message: 'Sub lokasi harus :size karakter')]
    public $sub = "";

    #[Validate('required', message: 'Deskripsi harus diisi')]
    #[Validate('string', message: 'Deskripsi harus berupa string')]
    #[Validate('min:5', message: 'Deskripsi terlalu pendek')]
    #[Validate('max:100', message: 'Deskripsi terlalu panjang')]
    public $deskripsi;

    #[Computed()]
    public function listSubLokasi()
    {
        return Lokasi::query()
            ->where('sub', '=', '')
            ->get();
    }

    public function save()
    {
        // cek validasi unique kolom nama dan sub
        $exists = Lokasi::where('nama', $this->nama)
            ->where('sub', $this->sub)
            ->exists();
        if ($exists) {
            $this->addError('nama', 'Kombinasi Nama dan Sub Lokasi sudah ada');
            $this->addError('sub', 'Kombinasi Nama dan Sub Lokasi sudah ada');
            return;
        }
        // Validasi data
        $this->validate();

        try {
            Lokasi::create([
                'nama' => $this->nama,
                'sub' => $this->sub,
                'deskripsi' => $this->deskripsi,
            ]);
            $this->reset();
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'Lokasi berhasil ditambahkan.');
            $this->dispatch('refresh-list-lokasi');
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'Lokasi gagal ditambahkan.');
        }
        Flux::modal('create-lokasi')->close();
    }

    public function render()
    {
        return view('livewire.lokasi.create-lokasi');
    }
}
