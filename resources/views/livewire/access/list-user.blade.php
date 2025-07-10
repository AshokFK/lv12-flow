<div>
    {{-- heading --}}
    <div class="relative mb-4 w-full">
        <flux:heading size="xl" level="1">User</flux:heading>
        <flux:subheading size="lg" class="mb-6">List master data user</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    {{-- data tools --}}
    <div class="pb-4 bg-accent-foreground block sm:flex items-center justify-between border-b lg:mt-1.5">
        <div class="w-full mb-1">
            <div class="sm:flex">
                <div class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                    <div class="relative mt-1 lg:w-64 xl:w-96 flex items-center">
                        <flux:input size="sm" iconLeading="magnifying-glass" clearable wire:model.live.debounce.250ms="searchTerm" placeholder="Search" class="w-sm me-2" />
                    </div>
                </div>
                <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
                    <flux:modal.trigger name="create-user">
                        <flux:button size="sm" variant="outline" icon="plus" class="bg-">Tambah</flux:button>
                    </flux:modal.trigger>
                </div>
            </div>
        </div>
    </div>

    {{-- list data --}}
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed">
                        <thead>
                            <tr class="border-b border-t border-gray-200">
                                <th scope="col" class="p-2 text-accent">
                                    <button type="button" class="flex items-center justify-between w-full cursor-pointer text-sm font-semibold text-left uppercase" wire:click="sortBy('nik')">
                                        NIK
                                        @if ($sortColumn === 'nik')
                                        <span class="ml-1">
                                            @if($sortDirection === 'asc' )
                                            <flux:icon.chevron-up variant="micro" />
                                            @else
                                            <flux:icon.chevron-down variant="micro" />
                                            @endif
                                        </span>
                                        @else
                                        <flux:icon.chevron-up-down variant="micro" />
                                        @endif
                                    </button>
                                </th>
                                <th scope="col" class="p-2 text-accent">
                                    <button type="button" class="flex items-center justify-between w-full cursor-pointer text-sm font-semibold text-left uppercase" wire:click="sortBy('name')">
                                        Nama
                                        @if ($sortColumn === 'name')
                                        <span class="ml-1">
                                            @if($sortDirection === 'asc' )
                                            <flux:icon.chevron-up variant="micro" />
                                            @else
                                            <flux:icon.chevron-down variant="micro" />
                                            @endif
                                        </span>
                                        @else
                                        <flux:icon.chevron-up-down variant="micro" />
                                        @endif
                                    </button>
                                </th>
                                <th scope="col" class="p-2 text-accent">
                                    <button type="button" class="flex items-center justify-between w-full cursor-pointer text-sm font-semibold text-left uppercase" wire:click="sortBy('username')">
                                        Username
                                        @if ($sortColumn === 'username')
                                        <span class="ml-1">
                                            @if($sortDirection === 'asc' )
                                            <flux:icon.chevron-up variant="micro" />
                                            @else
                                            <flux:icon.chevron-down variant="micro" />
                                            @endif
                                        </span>
                                        @else
                                        <flux:icon.chevron-up-down variant="micro" />
                                        @endif
                                    </button>
                                </th>
                                <th scope="col" class="p-2 text-accent">
                                    <button type="button" class="flex items-center justify-between w-full cursor-pointer text-sm font-semibold text-left uppercase" wire:click="sortBy('email')">
                                        email
                                        @if ($sortColumn === 'email')
                                        <span class="ml-1">
                                            @if($sortDirection === 'asc' )
                                            <flux:icon.chevron-up variant="micro" />
                                            @else
                                            <flux:icon.chevron-down variant="micro" />
                                            @endif
                                        </span>
                                        @else
                                        <flux:icon.chevron-up-down variant="micro" />
                                        @endif
                                    </button>
                                </th>
                                <th scope="col" class="p-2 text-accent text-left">Role</th>
                                <th scope="col" class="p-2 text-sm"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($this->listUser as $user)
                            <tr class="hover:bg-gray-200 dark:hover:bg-gray-700">
                                <td class="p-2 text-base font-medium whitespace-nowrap">{{ $user->nik }}</td>
                                <td class="p-2 text-base font-normal whitespace-nowrap">{{ $user->name }}</td>
                                <td class="p-2 text-base font-normal whitespace-nowrap">{{ $user->username }}</td>
                                <td class="p-2 text-base font-normal whitespace-nowrap">{{ $user->email }}</td>
                                <td class="p-2 text-base font-normal whitespace-nowrap">
                                    @if($user->roles)
                                    <span title="login roles">
                                        @foreach($user->roles as $role)
                                        <flux:badge class="mx-0.5 text-xs" size="sm" color="blue">
                                            {{ $role->name }}
                                        </flux:badge>
                                        @endforeach
                                    </span>
                                    @endif
                                </td>
                                <td class="p-2 space-x-2 whitespace-nowrap text-right">
                                    <flux:dropdown hover gap="0">
                                        <flux:button size="sm" icon="ellipsis-vertical" class="cursor-pointer" />
                                        <flux:navmenu>
                                            <flux:navmenu.item href="#" x-on:click="$dispatch('user-assign-role', { 'user': {{ $user->id }} })" icon="shield-check">Assign role</flux:navmenu.item>
                                        </flux:navmenu>
                                    </flux:dropdown>
                                </td>
                            </tr>
                            @empty
                            <tr class="border-b">
                                <td class="p-2 text-base font-medium text-center text-accent" colspan="4">Tidak ada data
                                    untuk ditampilkan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <!-- pagination -->
        <div class="sticky bottom-0 right-0 items-center w-full py-4 bg-white border-t border-gray-200 dark:bg-accent-foreground">
            {{ $this->listUser->links() }}
        </div>
    </div>

    {{-- modal create user --}}
    {{-- <livewire:user.create-user /> --}}

    {{-- modal assign role --}}
    <livewire:access.user-assign-role />


</div>
