<?php

namespace App\Livewire\Access;

use Flux\Flux;
use App\Models\Role;
use Livewire\Component;
use App\Models\Permission;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;

class EditRolePermission extends Component
{
    public $roleId;
    public $name;
    public $permissions;
    public $listPermission;

    #[On('edit-role-permission')]
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $this->roleId = $role->id;
        $this->name = $role->name;
        
        $this->permissions = $role->permissions->pluck('name');

        $this->listPermission = Permission::all()
        ->groupBy('group')
        ->map(function ($permissions, $group) {
            return [
                'group' => $group,
                'permissions' => $permissions->map(function ($permission) {
                    return [
                        'id' => $permission->id,
                        'name' => $permission->name,
                    ];
                })->toArray(),
            ];
        })->values()->toArray();

        Flux::modal('edit-role-permission')->show();
    }

    public function save()
    {
        $this->validate([
            'name' => ['required', Rule::unique('roles')->ignore($this->roleId), 'min:2', 'max:50'],
        ],[
            'name.required' => 'Role harus diisi',
            'name.min' => 'Role terlalu pendek',
            'name.max' => 'Role terlalu panjang',
            'name.unique' => 'Role sudah ada'
        ]);
        try {
            $role = Role::findOrFail($this->roleId);
            $role->update(['name' => $this->name]);
            $role->syncPermissions($this->permissions);
            $this->reset(['name','permissions']);
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'Role berhasil diperbarui.');
            $this->dispatch('refresh-list-role');
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'Role gagal diperbarui.');
        }
        Flux::modal('edit-role-permission')->close();
    }
    
    public function render()
    {
        return view('livewire.access.edit-role-permission');
    }
}
