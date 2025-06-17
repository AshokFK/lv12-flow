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
    public $lokasi_id;
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
        $this->lokasi_id = $header->lokasi_id;
        $this->finished_at = $header->finished_at;

        $lokasi_data = $header->lokasi->findOrFail($header->lokasi_id)
            ->get(['id', 'nama', 'sub', 'deskripsi']);
        Flux::modal('edit-header')->show();
        $this->dispatch('init-selected', lokasi_selected: $header->lokasi_id, lokasi_data: $lokasi_data);
    }

    public function save()
    {
        $this->validate([
            'kontrak' => 'required|string|min:5|max:100',
            'brand' => 'required|string|min:5|max:100',
            'pattern' => 'required|string|min:5|max:100',
            'style' => 'required|string|min:5|max:100',
            'tgl_berjalan' => 'required|date|date_format:Y-m-d',
            'lokasi_id' => 'required',
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
            'lokasi_id.required' => 'Lokasi harus diisi',
        ]);

        $header = FlowHeader::findOrFail($this->headerId);

        try {
            $header->update([
                'kontrak' => $this->kontrak,
                'brand' => $this->brand,
                'pattern' => $this->pattern,
                'style' => $this->style,
                'tgl_berjalan' => $this->tgl_berjalan,
                'lokasi_id' => $this->lokasi_id,
                'finished_at' => $this->is_finished ? now()->format('Y-m-d') : null,
            ]);
            $this->reset();
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'Header berhasil diperbarui.');
            $this->dispatch('refresh-list-header');
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'Header gagal diperbarui.');
        }
        Flux::modal('edit-header')->close();
    }

    public function render()
    {
        return view('livewire.flow.edit-header');
    }
}
