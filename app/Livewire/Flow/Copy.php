<?php

namespace App\Livewire\Flow;

use Flux\Flux;
use Livewire\Component;
use App\Models\FlowHeader;
use App\Traits\FetchLokasi;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Illuminate\Database\QueryException;

class Copy extends Component
{
    use FetchLokasi;
    
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
    public $headerId;

    #[On('copy-flow')]
    public function initCopy(FlowHeader $header)
    {
        $this->headerId = $header->id;
        $this->kontrak = $header->kontrak;
        $this->brand = $header->brand;
        $this->pattern = $header->pattern;
        $this->style = $header->style;
        $this->tgl_berjalan = $header->tgl_berjalan;
        $this->lokasi_id = $header->lokasi_id;
        $lokasi_data = $header->lokasi->findOrFail($header->lokasi_id)
            ->get(['id', 'nama', 'sub', 'deskripsi']);
        Flux::modal('copy-flow')->show();
        $this->dispatch('init-selected', lokasi_selected: $header->lokasi_id, lokasi_data: $lokasi_data);

    }

    public function save()
    {
        $this->validate();

        try {
            // Create a new header with the copied data
            $new_header = FlowHeader::create([
                'kontrak' => $this->kontrak,
                'brand' => $this->brand,
                'pattern' => $this->pattern,
                'style' => $this->style,
                'tgl_berjalan' => $this->tgl_berjalan,
                'lokasi_id' => $this->lokasi_id,
            ]);
            // select semua item dari header yg terpilih
            $items = FlowHeader::find($this->headerId)->items()->get();
            // simpan setiap item ke header yang baru
            foreach ($items as $item) {
                $new_header->items()->create($item->toArray());
            }

            $this->reset();
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'Header dan Item flow berhasil di duplikasi.');
            $this->dispatch('refresh-list-header');
        } catch (QueryException $e) {
            //throw $th;
            if ($e->getCode() === '23000') $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'Data sudah ada, duplikasi gagal.');
        } catch (\Throwable $th) {
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'Duplikasi flow gagal.');
        }
        Flux::modal('copy-flow')->close();
    }
    
    public function render()
    {
        return view('livewire.flow.copy');
    }
}
