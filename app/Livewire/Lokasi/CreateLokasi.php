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
    public $sub;

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

        Lokasi::create([
            'nama' => $this->nama,
            'sub' => $this->sub,
            'deskripsi' => $this->deskripsi,
        ]);
        Flux::modal('create-lokasi')->close();
        session()->flash('success', 'Lokasi berhasil ditambahkan.');
        $this->reset();
        $this->redirect(route('list.lokasi'), navigate: true);
    }

    public function render()
    {
        return view('livewire.lokasi.create-lokasi');
    }
}
