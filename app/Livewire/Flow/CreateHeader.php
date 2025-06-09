<?php

namespace App\Livewire\Flow;

use Flux\Flux;
use App\Models\Lokasi;
use Livewire\Component;
use App\Models\FlowHeader;
use Livewire\Attributes\Validate;

class CreateHeader extends Component
{
    #[Validate('required', message: 'Kontrak harus diisi')]
    #[Validate('string', message: 'Kontrak harus berupa string')]
    #[Validate('min:5', message: 'Kontrak terlalu pendek')]
    #[Validate('max:100', message: 'Kontrak terlalu panjang')]
    public $kontrak;

    #[Validate('required', message: 'Brand harus diisi')]
    #[Validate('string', message: 'Brand harus berupa string')]
    #[Validate('min:5', message: 'Brand terlalu pendek')]
    #[Validate('max:100', message: 'Brand terlalu panjang')]
    public $brand;

    #[Validate('required', message: 'Pattern harus diisi')]
    #[Validate('string', message: 'Pattern harus berupa string')]
    #[Validate('min:5', message: 'Pattern terlalu pendek')]
    #[Validate('max:100', message: 'Pattern terlalu panjang')]
    public $pattern;

    #[Validate('required', message: 'Style harus diisi')]
    #[Validate('string', message: 'Style harus berupa string')]
    #[Validate('min:5', message: 'Style terlalu pendek')]
    #[Validate('max:100', message: 'Style terlalu panjang')]
    public $style;

    #[Validate('required', message: 'Tanggal berjalan harus diisi')]
    #[Validate('date', message: 'Tanggal berjalan tidak valid')]
    #[Validate('date_format:Y-m-d', message: 'Format tanggal berjalan tidak valid')]
    #[Validate('after_or_equal:today', message: 'Tanggal berjalan tidak boleh sebelum hari ini')]
    public $tgl_berjalan;

    #[Validate('required', message: 'Lokasi harus diisi')]
    public $lokasi_id;

    public function fetchLokasi($query = '')
    {
        return Lokasi::search(['nama', 'sub', 'deskripsi'], $query)->get(['id', 'nama', 'sub', 'deskripsi']);
    }

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
            'lokasi_id' => $this->lokasi_id,
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
