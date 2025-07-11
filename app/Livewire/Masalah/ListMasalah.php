<?php

namespace App\Livewire\Masalah;

use App\Models\Masalah;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Traits\WithTableTools;
use Livewire\Attributes\Computed;

class ListMasalah extends Component
{
    use WithPagination, WithTableTools;

    public $masalahId;

    #[Computed]
    public function listMasalah()
    {
        $this->authorize('list masalah');
        return Masalah::search(['deskripsi', 'penanganan'], $this->searchTerm)
            ->with(['flowItem'])
            ->when($this->sortColumn, function ($query) {
                $query->orderBy($this->sortColumn, $this->sortDirection);
            })
            ->paginate($this->perPage);
    }

    #[On('refresh-list-masalah')]
    public function refreshList()
    {
        unset($this->listMasalah);
    }

    // action save masalah by spv
    public function saveSpv(Masalah $masalah)
    {
        $this->authorize('save masalah');
        try {
            $masalah->update([
                'saved_at' => Carbon::now()
            ]);
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'Masalah berhasil disave.');
        } catch (\Throwable $th) {
            // throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan saat save masalah.');
        }
        $this->dispatch('refresh-list-masalah')->self();
    }

    // action post masalah by chief
    public function postChief(Masalah $masalah)
    {
        $this->authorize('post masalah');
         try {
            $masalah->update([
                'posted_at' => Carbon::now()
            ]);
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'Masalah berhasil dipost.');
        } catch (\Throwable $th) {
            // throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan saat post masalah.');
        }
        $this->dispatch('refresh-list-masalah')->self();
    }

    public function render()
    {
        return view('livewire.masalah.list-masalah');
    }
}
