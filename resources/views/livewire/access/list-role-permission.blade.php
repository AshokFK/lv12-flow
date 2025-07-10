<div>
    {{-- heading --}}
    <div class="relative mb-4 w-full">
        <flux:heading size="xl" level="1">Role dan Permission</flux:heading>
        <flux:subheading size="lg" class="mb-6">List data role beserta permission untuk user</flux:subheading>
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
                    <flux:modal.trigger name="create-role-permission">
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
                                    <button type="button" class="flex items-center justify-between w-full cursor-pointer text-sm font-semibold text-left uppercase" wire:click="sortBy('name')">
                                        Role
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
                                    Permission
                                </th>
                                <th scope="col" class="p-2 text-sm"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($this->listRole as $role)
                            <tr class="">
                                <td class="p-2 text-base font-medium whitespace-nowrap">{{ $role->name }}</td>
                                <td class="p-2 whitespace-nowrap">
                                    @if($role->permissions)
                                        @php
                                            $rolePermissions = $role->permissions->pluck('name');
                                            $limitPermission = 5;
                                        @endphp
                                        @foreach($rolePermissions->take($limitPermission) as $permission)
                                        <flux:badge class="mx-0.5 text-xs" size="sm" color="blue">
                                            {{ $permission }}
                                        </flux:badge>
                                        @endforeach
                                        @if($rolePermissions->count() > $limitPermission)
                                            <flux:badge class="mx-0.5 text-xs" size="sm" color="blue">
                                                + {{ $rolePermissions->count() - $limitPermission }} lainnya...
                                            </flux:badge>
                                        @endif
                                    @endif

                                </td>
                                <td class="p-2 space-x-2 whitespace-nowrap text-right">
                                    <flux:button size="sm" icon="pencil-square" iconVariant="mini" class="bg-blue-400! hover:bg-blue-500! text-white!" x-on:click="$dispatch('edit-role-permission', { 'id': {{ $role->id }} })">
                                        Edit</flux:button>
                                </td>
                            </tr>
                            @empty
                            <tr class="border-b">
                                <td class="p-2 text-base font-medium text-center text-accent" colspan="3">Tidak ada data
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
            {{ $this->listRole->links() }}
        </div>
    </div>

    {{-- modal create role --}}
    <livewire:access.create-role-permission />

    {{-- modal edit role --}}
    <livewire:access.edit-role-permission />

</div>
