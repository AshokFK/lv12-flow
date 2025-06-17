<?php

namespace App\Livewire\Lokasi;

use Flux\Flux;
use App\Models\Lokasi;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;

class EditLokasi extends Component
{
    public $lokasiId;
    public $nama;
    public $sub = "";
    public $deskripsi;
    public $is_active;

    #[On('edit-lokasi')]
    public function edit($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        $this->lokasiId = $lokasi->id;
        $this->nama = $lokasi->nama;
        $this->sub = $lokasi->sub;
        $this->deskripsi = $lokasi->deskripsi;
        $this->is_active = $lokasi->is_active;
        Flux::modal('edit-lokasi')->show();
    }
    
    #[Computed()]
    public function listSubLokasi()
    {
        return Lokasi::query()
            ->whereNull('sub')
            ->orWhere('sub', '=', '')
            ->get();
    }
    
    public function save()
    {
        $this->validate([ 
            'nama' => ['required', 'string', 'size:3',
                Rule::unique('lokasi')->where(function ($query) {
                    return $query->where('nama', $this->nama)
                        ->where('sub', $this->sub)
                        ->where('id', '!=', $this->lokasiId);
                })
            ],
            'sub' => 'nullable|string|size:3',
            'deskripsi' => 'required|string|min:5|max:100',
            'is_active' => 'boolean',
        ], [
            'nama.required' => 'Nama harus diisi',
            'nama.string' => 'Nama harus berupa string',
            'nama.size' => 'Nama harus :size karakter',
            'nama.unique' => 'Kombinasi Nama dan Sub Lokasi sudah ada',
            'sub.string' => 'Sub lokasi harus berupa string',
            'sub.size' => 'Sub lokasi harus :size karakter',
            'deskripsi.required' => 'Deskripsi harus diisi',
            'deskripsi.string' => 'Deskripsi harus berupa string',
            'deskripsi.min' => 'Deskripsi terlalu pendek',
            'deskripsi.max' => 'Deskripsi terlalu panjang',
            'is_active.boolean' => 'Status aktif tidak valid',
        ]);

        $lokasi = Lokasi::findOrFail($this->lokasiId);

        try {
            $lokasi->update([
                'nama' => $this->nama,
                'sub' => $this->sub,
                'deskripsi' => $this->deskripsi,
                'is_active' => $this->is_active,
            ]);
            $this->reset();
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'Lokasi berhasil diperbarui.');
            $this->dispatch('refresh-list-lokasi');
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'Lokasi gagal diperbarui.');
        }
        Flux::modal('edit-lokasi')->close();
    }

    public function render()
    {
        return view('livewire.lokasi.edit-lokasi');
    }
}
