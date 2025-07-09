<?php

namespace App\Livewire\Access;

use Flux\Flux;
use App\Models\Role;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Traits\WithTableTools;
use Livewire\Attributes\Computed;

class ListRolePermission extends Component
{
    use WithTableTools, WithPagination;

    public $roleId;

    #[Computed]
    public function listRole()
    {
        return Role::query()
            ->when($this->searchTerm, function ($query) {
                $query->where('name', 'like', '%' . $this->searchTerm . '%');
            })
            ->when($this->sortColumn, function ($query) {
                $query->orderBy($this->sortColumn, $this->sortDirection);
            })
            ->paginate($this->perPage);
    }

    #[On('refresh-list-role')]
    public function refreshList()
    {
        unset($this->listRole);
    }

    public function render()
    {
        return view('livewire.access.list-role-permission');
    }
}
