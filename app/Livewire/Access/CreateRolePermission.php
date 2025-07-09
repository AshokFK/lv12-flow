<?php

namespace App\Livewire\Access;

use Flux\Flux;
use App\Models\Role;
use Livewire\Component;
use App\Models\Permission;
use Livewire\Attributes\Validate;

class CreateRolePermission extends Component
{
    #[Validate('required', message: 'Role harus diisi')]
    #[Validate('min:2', message: 'Role terlalu pendek')]
    #[Validate('max:50', message: 'Role terlalu panjang')]
    public $name;
    public $permissions;
    public $listPermission;

    public function mount()
    {
        $this->listPermission = Permission::all(['name']);
    }

    public function save()
    {
        $this->validate();
        try {
            $role = Role::create(['name' => $this->name]);
            $role->givePermissionTo($this->permissions);
            $this->reset(['name','permissions']);
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'Role berhasil ditambahkan.');
            $this->dispatch('refresh-list-role');
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'Role gagal ditambahkan.');
        }
        Flux::modal('create-role-permission')->close();
    }

    public function render()
    {
        return view('livewire.access.create-role-permission');
    }
}
