<?php

namespace App\Livewire\Flow;

use Flux\Flux;
use Livewire\Component;
use App\Models\FlowHeader;
use Livewire\Attributes\Validate;

class CreateHeader extends Component
{
    #[Validate('required', message: 'Nama harus diisi')]
    #[Validate('string', message: 'Nama harus berupa string')]
    #[Validate('min:5', message: 'Nama terlalu pendek')]
    #[Validate('max:100', message: 'Nama terlalu panjang')]
    public $kontrak;

    #[Validate('required', message: 'Nama harus diisi')]
    #[Validate('string', message: 'Nama harus berupa string')]
    #[Validate('min:5', message: 'Nama terlalu pendek')]
    #[Validate('max:100', message: 'Nama terlalu panjang')]
    public $brand;

    #[Validate('required', message: 'Nama harus diisi')]
    #[Validate('string', message: 'Nama harus berupa string')]
    #[Validate('min:5', message: 'Nama terlalu pendek')]
    #[Validate('max:100', message: 'Nama terlalu panjang')]
    public $pattern;

    #[Validate('required', message: 'Nama harus diisi')]
    #[Validate('string', message: 'Nama harus berupa string')]
    #[Validate('min:5', message: 'Nama terlalu pendek')]
    #[Validate('max:100', message: 'Nama terlalu panjang')]
    public $style;

    #[Validate('required', message: 'Tanggal berjalan harus diisi')]
    #[Validate('date', message: 'Tanggal berjalan tidak valid')]
    #[Validate('date_format:Y-m-d', message: 'Format tanggal berjalan tidak valid')]
    #[Validate('after_or_equal:today', message: 'Tanggal berjalan tidak boleh sebelum hari ini')]
    public $tgl_berjalan;

    #[Validate('required', message: 'Lokasi harus diisi')]
    #[Validate('size:3', message: 'Lokasi harus 3 karakter')]
    #[Validate('regex:/^[A-Z]{3}$/', message: 'Lokasi harus terdiri dari 3 huruf kapital')]
    public $lokasi;

    public function save()
    {
        $this->validate();

        // Save the header data to the database
        FlowHeader::create([
            'kontrak' => $this->kontrak,
            'brand' => $this->brand,
            'pattern' => $this->pattern,
            'style' => $this->style,
            'tgl_berjalan' => $this->tgl_berjalan,
            'lokasi' => $this->lokasi,
        ]);

        Flux::modal('create-header')->close();
        session()->flash('success', 'Data header berhasil ditambahkan.');
        $this->reset();
        $this->redirect(route('list.header'), navigate: true);
    }
    
    public function render()
    {
        return view('livewire.flow.create-header');
    }
}
