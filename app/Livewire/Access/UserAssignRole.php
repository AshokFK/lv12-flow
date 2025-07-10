<?php

namespace App\Livewire\Access;

use Flux\Flux;
use App\Models\Role;
use Livewire\Component;
use App\Models\LoginUser;
use Livewire\Attributes\On;

class UserAssignRole extends Component
{
    public $userId;
    public $nik;
    public $name;
    public $role;
    public $listRole = [];

    #[On('user-assign-role')]
    public function initAssign(LoginUser $user)
    {
        $this->userId = $user->id;
        $this->nik = $user->nik;
        $this->name = $user->name;
        $this->role = $user->roles->pluck('id')->first() ?? null;
        $this->listRole = Role::all(['id','name']);
        Flux::modal('user-assign-role')->show();
    }

    public function save()
    {
        $this->validate([
            'role' => ['required', 'exists:roles,id'],
        ], [
            'role.required' => 'Role harus dipilih',
            'role.exists' => 'Role tidak valid',
        ]);

        try {
            $user = LoginUser::findOrFail($this->userId);
            $role = Role::findOrFail($this->role);
            $user->syncRoles([$role]);

            $this->reset('role');
            $this->dispatch('swal-toast', icon: 'success', title: 'Berhasil', text: 'Role user berhasil diperbarui.');
            $this->dispatch('refresh-list-user');
        } catch (\Throwable $th) {
            //throw $th;
            $this->dispatch('swal-toast', icon: 'error', title: 'Gagal', text: 'Role user gagal diperbarui.');
        }

        Flux::modal('user-assign-role')->close();
    }

    public function render()
    {
        return view('livewire.access.user-assign-role');
    }
}
