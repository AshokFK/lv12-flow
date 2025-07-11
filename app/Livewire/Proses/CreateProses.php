<?php

namespace App\Livewire\Proses;

use Flux\Flux;
use App\Models\Proses;
use Livewire\Component;
use App\Traits\FetchLokasi;
use Livewire\Attributes\Validate;

class CreateProses extends Component
{
    use FetchLokasi;
    
    public $mastercode;
    public $nama;
    public $nama_jp;
    public $lokasi_id;
    public $level;

    public function rules()
    {
        return [
            'mastercode' => 'required|string|size:14|unique:proses,mastercode,NULL,id,lokasi_id,' . $this->lokasi_id,
            'nama' => 'required|string|min:5|max:100',
            'nama_jp' => 'required|string|min:5|max:100',
            'lokasi_id' => 'required|exists:lokasi,id',
            'level' => 'required|integer|in:1,2,3',
        ];
    }
    public function messages()
    {
        return [
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
            'lokasi_id.exists' => 'Lokasi tidak ditemukan',
            'level.required' => 'Level harus diisi',
            'level.integer' => 'Level harus berupa angka',
            'level.in' => 'Level harus 1, 2, atau 3',
        ];
    }

    public function save()
    {
        $this->authorize('tambah proses');
        $this->validate();

        try {
            Proses::create([
                'mastercode' => $this->mastercode,
                'nama' => $this->nama,
                'nama_jp' => $this->nama_jp,
                'lokasi_id' => $this->lokasi_id,
                'level' => $this->level,
            ]);
            $this->reset();
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'Proses berhasil ditambahkan.');
            $this->dispatch('refresh-list-proses');
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'Proses gagal ditambahkan.');
        }
        Flux::modal('create-proses')->close();
    }

    public function render()
    {
        return view('livewire.proses.create-proses');
    }
}
