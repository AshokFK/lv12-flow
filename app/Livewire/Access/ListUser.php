<?php

namespace App\Livewire\Access;

use Livewire\Component;
use App\Models\LoginUser;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Traits\WithTableTools;
use Livewire\Attributes\Computed;

class ListUser extends Component
{
    use WithTableTools, WithPagination;

    public $userId;

    #[Computed]
    public function listUser()
    {
        return LoginUser::query()
            ->when($this->searchTerm, function ($query) {
                $query->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('nik', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('username', 'like', '%' . $this->searchTerm . '%');
            })
            ->when($this->sortColumn, function ($query) {
                $query->orderBy($this->sortColumn, $this->sortDirection);
            })
            ->paginate($this->perPage);
    }

    #[On('refresh-list-user')]
    public function refreshList()
    {
        unset($this->listUser);
    }

    public function render()
    {
        return view('livewire.access.list-user');
    }
}
