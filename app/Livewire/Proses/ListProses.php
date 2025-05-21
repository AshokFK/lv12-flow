<?php

namespace App\Livewire\Proses;

use Flux\Flux;
use App\Models\Proses;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Traits\WithTableTools;
use Livewire\Attributes\Computed;

class ListProses extends Component
{
    use WithTableTools, WithPagination;

    public $prosesId;

    #[Computed]
    public function listProses()
    {
        return Proses::query()
            ->when($this->searchTerm, function ($query) {
                $query->where('mastercode', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('nama', 'like', '%' . $this->searchTerm . '%');
            })
            ->when($this->sortColumn, function ($query) {
                $query->orderBy($this->sortColumn, $this->sortDirection);
            })
            ->paginate($this->perPage);
    }

    public function edit($prosesId)
    {
        $this->dispatch('edit-proses', $prosesId);
    }

    #[On('delete-proses')]
    public function confirmDelete($id)
    {
        $this->prosesId = $id;
        Flux::modal('delete-proses')->show();
    }

    public function delete()
    {
        $proses = Proses::findOrFail($this->prosesId);

        if ($proses) {
            $proses->delete();
            Flux::modal('delete-proses')->close();
            session()->flash('success', 'Proses berhasil dihapus.');
            $this->reset('prosesId');
            $this->redirect(route('list.proses'), navigate: true);
        } 
    }
    
    public function render()
    {
        return view('livewire.proses.list-proses');
    }
}
