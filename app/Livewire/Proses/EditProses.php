<?php

namespace App\Livewire\Proses;

use Flux\Flux;
use App\Models\Proses;
use Livewire\Component;
use App\Traits\FetchLokasi;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;

class EditProses extends Component
{
    use FetchLokasi;

    public $prosesId;
    public $mastercode;
    public $nama;
    public $nama_jp;
    public $lokasi_id;
    public $level;
    public $is_active;

    #[On('edit-proses')]
    public function edit($id)
    {
        $this->authorize('edit proses');

        $proses = Proses::findOrFail($id);
        $this->prosesId = $proses->id;
        $this->mastercode = $proses->mastercode;
        $this->nama = $proses->nama;
        $this->nama_jp = $proses->nama_jp;
        $this->lokasi_id = $proses->lokasi_id;
        $this->level = $proses->level;
        $this->is_active = $proses->is_active;

        $lokasi_data = [
            'id' => $proses->lokasi->id ?? null,
            'nama' => $proses->lokasi->nama ?? null,
            'sub' => $proses->lokasi->sub ?? null,
            'deskripsi' => $proses->lokasi->deskripsi ?? null,
        ];
        Flux::modal('edit-proses')->show();
        $this->dispatch('init-selected', lokasi_selected: $proses->lokasi_id, lokasi_data: $lokasi_data);
    }

    public function save()
    {
        $this->authorize('edit proses');
        $this->validate([
            'mastercode' => [
                'required','string','size:14',
                Rule::unique('proses')->where(function ($query) {
                    return $query->where('mastercode', $this->mastercode)
                        ->where('lokasi_id', $this->lokasi_id)
                        ->where('id', '!=', $this->prosesId);
                })
            ],
            'nama' => 'required|string|min:5|max:100',
            'nama_jp' => 'required|string|min:3|max:100',
            'lokasi_id' => 'required',
            'level' => 'required|integer|in:1,2,3',
            'is_active' => 'boolean',
        ], [
            'mastercode.required' => 'Mastercode harus diisi',
            'mastercode.size' => 'Mastercode harus :size karakter',
            'mastercode.unique' => 'Kombinasi Mastercode dan Lokasi sudah ada',
            'nama.required' => 'Nama harus diisi',
            'nama.string' => 'Nama harus berupa string',
            'nama.min' => 'Nama terlalu pendek',
            'nama.max' => 'Nama terlalu panjang',
            'nama_jp.required' => 'Nama JP harus diisi',
            'nama_jp.string' => 'Nama JP harus berupa string',
            'nama_jp.min' => 'Nama JP terlalu pendek',
            'nama_jp.max' => 'Nama JP terlalu panjang',
            'lokasi_id.required' => 'Lokasi harus diisi',
            'level.required' => 'Level harus diisi',
            'level.integer' => 'Level harus berupa angka',
            'level.in' => 'Level harus 1, 2, atau 3',
        ]);

        $proses = Proses::findOrFail($this->prosesId);
        try {
            $proses->update([
                'mastercode' => $this->mastercode,
                'nama' => $this->nama,
                'nama_jp' => $this->nama_jp,
                'lokasi_id' => $this->lokasi_id,
                'level' => $this->level,
                'is_active' => $this->is_active,
            ]);
            $this->reset();
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'Proses berhasil diperbarui.');
            $this->dispatch('refresh-list-proses');
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'Proses gagal diperbarui.');
        }
        Flux::modal('edit-proses')->close();
    }

    public function render()
    {
        return view('livewire.proses.edit-proses');
    }
}
