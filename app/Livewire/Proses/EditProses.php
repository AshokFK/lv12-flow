<?php

namespace App\Livewire\Proses;

use Flux\Flux;
use App\Models\Proses;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;

class EditProses extends Component
{
    public $prosesId;
    public $mastercode;
    public $nama;
    public $nama_jp;
    public $lokasi;
    public $level;
    public $is_active;

    #[On('edit-proses')]
    public function edit($id)
    {
        $proses = Proses::findOrFail($id);
        $this->prosesId = $proses->id;
        $this->mastercode = $proses->mastercode;
        $this->nama = $proses->nama;
        $this->nama_jp = $proses->nama_jp;
        $this->lokasi = $proses->lokasi;
        $this->level = $proses->level;
        $this->is_active = $proses->is_active;
        Flux::modal('edit-proses')->show();
    }

    public function save()
    {
        $this->validate([
            'mastercode' => [
                'required','string','size:14',
                Rule::unique('proses')->where(function ($query)  {
                    return $query->where('mastercode', $this->mastercode)
                        ->where('lokasi', $this->lokasi)
                        ->where('id', '!=', $this->prosesId);
                })
            ],
            'nama' => 'required|string|min:5|max:100',
            'nama_jp' => 'required|string|min:5|max:100',
            'lokasi' => 'required|string|size:3',
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
            'lokasi.required' => 'Lokasi harus diisi',
            'lokasi.size' => 'Lokasi harus :size karakter',
            'lokasi.unique' => 'Lokasi sudah ada',
            'level.required' => 'Level harus diisi',
            'level.integer' => 'Level harus berupa angka',
            'level.in' => 'Level harus 1, 2, atau 3',
        ]);

        $proses = Proses::findOrFail($this->prosesId);
        $proses->update([
            'mastercode' => $this->mastercode,
            'nama' => $this->nama,
            'nama_jp' => $this->nama_jp,
            'lokasi' => $this->lokasi,
            'level' => $this->level,
            'is_active' => $this->is_active,
        ]);

        Flux::modal('edit-proses')->close();
        session()->flash('success', 'Proses berhasil diperbarui.');
        $this->reset();
        $this->redirect(route('list.proses'), navigate: true);
    }

    public function render()
    {
        return view('livewire.proses.edit-proses');
    }
}
