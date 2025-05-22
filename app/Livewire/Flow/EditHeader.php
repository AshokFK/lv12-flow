<?php

namespace App\Livewire\Flow;

use Flux\Flux;
use Livewire\Component;
use App\Models\FlowHeader;
use Livewire\Attributes\On;

class EditHeader extends Component
{
    public $headerId;
    public $kontrak;
    public $brand;
    public $pattern;
    public $style;
    public $tgl_berjalan;
    public $lokasi;
    public $is_finished;
    public $finished_at;

    #[On('edit-header')]
    public function edit($id)
    {
        $header = FlowHeader::findOrFail($id);
        $this->headerId = $header->id;
        $this->kontrak = $header->kontrak;
        $this->brand = $header->brand;
        $this->pattern = $header->pattern;
        $this->style = $header->style;
        $this->tgl_berjalan = $header->tgl_berjalan;
        $this->lokasi = $header->lokasi;
        $this->finished_at = $header->finished_at;
        Flux::modal('edit-header')->show();
    }

    public function save()
    {
        $this->validate([ 
            'kontrak' => 'required|string|min:5|max:100',
            'brand' => 'required|string|min:5|max:100',
            'pattern' => 'required|string|min:5|max:100',
            'style' => 'required|string|min:5|max:100',
            'tgl_berjalan' => 'required|date|date_format:Y-m-d|after_or_equal:today',
            'lokasi' => 'required|size:3|regex:/^[A-Z]{3}$/',
        ], [
            'kontrak.required' => 'Kontrak harus diisi',
            'kontrak.string' => 'Kontrak harus berupa string',
            'kontrak.min' => 'Kontrak terlalu pendek',
            'kontrak.max' => 'Kontrak terlalu panjang',
            'brand.required' => 'Brand harus diisi',
            'brand.string' => 'Brand harus berupa string',
            'brand.min' => 'Brand terlalu pendek',
            'brand.max' => 'Brand terlalu panjang',
            'pattern.required' => 'Pattern harus diisi',
            'pattern.string' => 'Pattern harus berupa string',
            'pattern.min' => 'Pattern terlalu pendek',
            'pattern.max' => 'Pattern terlalu panjang',
            'style.required' => 'Style harus diisi',
            'style.string' => 'Style harus berupa string',
            'style.min' => 'Style terlalu pendek',
            'style.max' => 'Style terlalu panjang',
            'tgl_berjalan.required' => 'Tanggal berjalan harus diisi',
            'tgl_berjalan.date' => 'Tanggal berjalan tidak valid',
            'tgl_berjalan.date_format' => 'Format tanggal berjalan tidak valid',
            'tgl_berjalan.after_or_equal' => 'Tanggal berjalan tidak boleh sebelum hari ini',
            'lokasi.required' => 'Lokasi harus diisi',
            'lokasi.size' => 'Lokasi harus 3 karakter',
            'lokasi.regex' => 'Lokasi harus terdiri dari 3 huruf kapital',
        ]);

        $header = FlowHeader::findOrFail($this->headerId);

        $header->update([
            'kontrak' => $this->kontrak,
            'brand' => $this->brand,
            'pattern' => $this->pattern,
            'style' => $this->style,
            'tgl_berjalan' => $this->tgl_berjalan,
            'lokasi' => $this->lokasi,
            'finished_at' => $this->is_finished ? now()->format('Y-m-d') : null,
        ]);

        Flux::modal('edit-header')->close();
        session()->flash('success', 'Data header berhasil diperbarui.');
        $this->reset();
        $this->redirect(route('list.header'), navigate: true);
    }
    
    public function render()
    {
        return view('livewire.flow.edit-header');
    }
}
