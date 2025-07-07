<div>
    {{-- heading --}}
    <div class="relative mb-4 w-full">
        <flux:heading size="xl" level="1">Masalah</flux:heading>
        <flux:subheading size="lg" class="mb-6">List data masalah pada proses</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    {{-- data tools --}}
    <div class="pb-4 bg-accent-foreground block sm:flex items-center justify-between border-b lg:mt-1.5">
        <div class="w-full mb-1">
            <div class="sm:flex">
                <div
                    class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                    <div class="relative mt-1 lg:w-64 xl:w-96 flex items-center">
                        <flux:input size="sm" iconLeading="magnifying-glass" clearable
                            wire:model.live.debounce.250ms="searchTerm" placeholder="Search" class="w-sm me-2" />
                    </div>
                </div>
                <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
                    
                </div>
            </div>
        </div>
    </div>

    {{-- list data --}}
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-auto">
                        <thead>
                            <tr class="border-b border-t border-gray-200">
                                <th scope="col" class="p-2 text-accent">
                                    <button type="button"
                                        class="flex items-center justify-between w-full text-sm font-semibold text-left uppercase">
                                        Kontrak
                                    </button>
                                </th>
                                <th scope="col" class="p-2 text-accent">
                                    <button type="button"
                                        class="flex items-center justify-between w-full text-sm font-semibold text-left uppercase">
                                        Brand
                                    </button>
                                </th>
                                <th scope="col" class="p-2 text-accent">
                                    <button type="button"
                                        class="flex items-center justify-between w-full text-sm font-semibold text-left uppercase">
                                        Proses
                                    </button>
                                </th>
                                <th scope="col" class="p-2 text-accent">
                                    <button type="button"
                                        class="flex items-center justify-between w-full cursor-pointer text-sm font-semibold text-left uppercase"
                                        wire:click="sortBy('type')">
                                        Type
                                        @if ($sortColumn === 'type')
                                            <span class="ml-1">
                                                @if ($sortDirection === 'asc')
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
                                    <button type="button"
                                        class="flex items-center justify-between w-full cursor-pointer text-sm font-semibold text-left uppercase"
                                        wire:click="sortBy('deskripsi')">
                                        Deskripsi
                                        @if ($sortColumn === 'deskripsi')
                                            <span class="ml-1">
                                                @if ($sortDirection === 'asc')
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
                                    <button type="button"
                                        class="flex items-center justify-between w-full cursor-pointer text-sm font-semibold text-left uppercase"
                                        wire:click="sortBy('penanganan')">
                                        Penanganan
                                        @if ($sortColumn === 'penanganan')
                                            <span class="ml-1">
                                                @if ($sortDirection === 'asc')
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
                                    <button type="button"
                                        class="flex items-center justify-between w-full cursor-pointer text-sm font-semibold text-left uppercase"
                                        wire:click="sortBy('done_at')">
                                        Selesai
                                        @if ($sortColumn === 'done_at')
                                            <span class="ml-1">
                                                @if ($sortDirection === 'asc')
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
                                    <button type="button"
                                        class="flex items-center justify-between w-full cursor-pointer text-sm font-semibold text-left uppercase"
                                        wire:click="sortBy('saved_at')">
                                        Save
                                        @if ($sortColumn === 'saved_at')
                                            <span class="ml-1">
                                                @if ($sortDirection === 'asc')
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
                                    <button type="button"
                                        class="flex items-center justify-between w-full cursor-pointer text-sm font-semibold text-left uppercase"
                                        wire:click="sortBy('posted_at')">
                                        Post
                                        @if ($sortColumn === 'posted_at')
                                            <span class="ml-1">
                                                @if ($sortDirection === 'asc')
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
                                <th scope="col" class="p-2 text-sm"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($this->listMasalah as $masalah)
                                <tr class="hover:bg-gray-200 dark:hover:bg-gray-700">
                                    <td class="p-2 text-base font-normal whitespace-nowrap">{{ $masalah->flowItem->header->kontrak }}</td>
                                    <td class="p-2 text-base font-normal whitespace-nowrap">{{ $masalah->flowItem->header->brand }}</td>
                                    <td class="p-2 text-base font-normal whitespace-nowrap">{{ $masalah->flowItem->itemable->nama }}</td>
                                    <td class="p-2 text-base font-normal whitespace-nowrap">{{ $masalah->type }}</td>
                                    <td class="p-2 text-base font-normal whitespace-nowrap">{{ Illuminate\Support\Str::limit($masalah->deskripsi, 50) }}</td>
                                    <td class="p-2 text-base font-normal whitespace-nowrap">{{ Illuminate\Support\Str::limit($masalah->penanganan, 50) }}</td>
                                    <td class="p-2 text-base font-normal whitespace-nowrap">{{ $masalah->done_at }}</td>
                                    <td class="p-2 text-base font-normal">
                                    @if($masalah->saved_at)
                                        {{ $masalah->saved_at }}
                                    @elseif($masalah->done_at) 
                                        {{-- button save untuk spv --}}
                                        <flux:button wire:click="saveSpv({{ $masalah->id }})" icon="shield-check" tooltip="Pilih masalah" size="sm">Save</flux:button>
                                    @endif
                                    </td>
                                    <td class="p-2 text-base font-normal">
                                    @if($masalah->posted_at)
                                        {{ $masalah->posted_at }}
                                    @elseif($masalah->done_at) 
                                        {{-- button post untuk chief --}}
                                        <flux:button wire:click="postChief({{ $masalah->id }})" icon="paper-airplane" tooltip="Post masalah" size="sm">Post</flux:button>
                                    @endif
                                    </td>
                                    <td class="p-2 space-x-2 text-right">
                                    <flux:dropdown hover gap="0">
                                        <flux:button size="sm" icon="ellipsis-vertical" class="cursor-pointer" />
                                        <flux:navmenu>
                                            <flux:navmenu.item href="#" x-on:click="$dispatch('edit-masalah', { 'id': {{ $masalah->id }} })"
                                                icon="pencil-square">Edit</flux:navmenu.item>
                                        </flux:navmenu>
                                    </flux:dropdown>

                                    </td>
                                </tr>
                            @empty
                                <tr class="border-b">
                                    <td class="p-2 text-base font-medium text-center text-accent" colspan="8">Tidak
                                        ada data
                                        untuk ditampilkan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <!-- pagination -->
        <div
            class="sticky bottom-0 right-0 items-center w-full py-4 bg-white border-t border-gray-200 dark:bg-accent-foreground">
            {{ $this->listMasalah->links() }}
        </div>
    </div>

    {{-- modal edit masalah --}}
    <livewire:masalah.edit-masalah />

</div>
