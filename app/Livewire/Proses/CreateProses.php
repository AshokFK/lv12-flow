<?php

namespace App\Livewire\Proses;

use Flux\Flux;
use App\Models\Proses;
use Livewire\Component;
use Livewire\Attributes\Validate;

class CreateProses extends Component
{
    #[Validate('required', message: 'Mastercode harus diisi')]
    #[Validate('size:14', message: 'Mastercode harus :size karakter')]
    #[Validate('unique:proses,mastercode,lokasi', message: 'Kombinasi Mastercode dan Lokasi sudah ada')]
    public $mastercode;

    #[Validate('required', message: 'Nama harus diisi')]
    #[Validate('string', message: 'Nama harus berupa string')]
    #[Validate('min:5', message: 'Nama terlalu pendek')]
    #[Validate('max:100', message: 'Nama terlalu panjang')]
    public $nama;

    #[Validate('required', message: 'Nama JP harus diisi')]
    #[Validate('string', message: 'Nama JP harus berupa string')]
    #[Validate('min:5', message: 'Nama JP terlalu pendek')]
    #[Validate('max:100', message: 'Nama JP terlalu panjang')]
    public $nama_jp;

    #[Validate('required', message: 'Lokasi harus diisi')]
    #[Validate('string', message: 'Lokasi harus berupa string')]
    #[Validate('size:3', message: 'Lokasi harus :size karakter')]
    #[Validate('unique:proses,mastercode,lokasi', message: 'Kombinasi Mastercode dan Lokasi sudah ada')]
    public $lokasi;

    #[Validate('required', message: 'Level harus diisi')]
    #[Validate('integer', message: 'Level harus berupa angka')]
    #[Validate('in:1,2,3', message: 'Level harus 1, 2, atau 3')]
    public $level;

    public function save()
    {
        $this->validate();

        Proses::create([
            'mastercode' => $this->mastercode,
            'nama' => $this->nama,
            'nama_jp' => $this->nama_jp,
            'lokasi' => $this->lokasi,
            'level' => $this->level,
        ]);
        
        Flux::modal('create-proses')->close();
        session()->flash('success', 'Proses berhasil ditambahkan.');
        $this->reset();
        $this->redirect(route('list.proses'), navigate: true);

    }
    public function render()
    {
        return view('livewire.proses.create-proses');
    }
}
