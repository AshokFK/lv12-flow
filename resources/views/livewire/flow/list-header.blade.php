<div>
    {{-- flash message --}}
    @session('success')
        <div>
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => { show = false }, 5000)" x-transition
                class="text-green-500 border-green-300 bg-green-50 flex items-center p-2 mb-4 border rounded-lg fixed top-5 right-5"
                role="alert">
                <flux:icon.check-circle class="w-5 h-5 text-green-500 flex-shrink-0 mr-3" />
                <div class="mx-2">{{ $value ?? 'Lorem ipsum dolor sit amet consectetur adipisicing elit.' }}</div>
            </div>
        </div>
    @endsession

    {{-- heading --}}
    <div class="relative mb-4 w-full">
        <flux:heading size="xl" level="1">Flow Header</flux:heading>
        <flux:subheading size="lg" class="mb-6">List master data Flow Header</flux:subheading>
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
                    <flux:modal.trigger name="create-header">
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
                                    <button type="button"
                                        class="flex items-center justify-between w-full cursor-pointer text-sm font-semibold text-left uppercase"
                                        wire:click="sortBy('kontrak')">
                                        Kontrak
                                        @if ($sortColumn === 'kontrak')
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
                                        wire:click="sortBy('brand')">
                                        Brand
                                        @if ($sortColumn === 'brand')
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
                                        wire:click="sortBy('pattern')">
                                        Pattern
                                        @if ($sortColumn === 'pattern')
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
                                        wire:click="sortBy('style')">
                                        Style
                                        @if ($sortColumn === 'style')
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
                                        wire:click="sortBy('tgl_berjalan')">
                                        Tgl berjalan
                                        @if ($sortColumn === 'tgl_berjalan')">
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
                                        wire:click="sortBy('lokasi')">
                                        Lokasi
                                        @if ($sortColumn === 'lokasi')">
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
                                        wire:click="sortBy('finished_at')">
                                        Selesai
                                        @if ($sortColumn === 'finished_at')">
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
                            @forelse ($this->listHeader as $header)
                                <tr class="">
                                    <td class="p-2 text-base font-medium whitespace-nowrap">{{ $header->kontrak }}</td>
                                    <td class="p-2 text-base font-normal whitespace-nowrap">{{ $header->brand }}</td>
                                    <td class="p-2 text-base font-normal whitespace-nowrap">{{ $header->pattern }}</td>
                                    <td class="p-2 text-base font-normal whitespace-nowrap">{{ $header->style }}</td>
                                    <td class="p-2 text-base font-normal whitespace-nowrap">{{ $header->tgl_berjalan }}
                                    </td>
                                    <td class="p-2 text-base font-normal whitespace-nowrap">{{ $header->lokasi->deskripsi }}</td>
                                    <td class="p-2 text-base font-normal whitespace-nowrap">{{ $header->finished_at }}
                                    </td>
                                    <td class="p-2 space-x-2 whitespace-nowrap text-right">
                                        <flux:button size="sm" icon="share"
                                            href="{{ route('chart.item', $header) }}">
                                            Flow</flux:button>
                                        <flux:button size="sm" icon="queue-list"
                                            class="bg-green-400! hover:bg-green-500! text-green-900!"
                                            href="{{ route('list.item', $header) }}">
                                            Item</flux:button>
                                        <flux:button size="sm" icon="pencil-square"
                                            class="cursor-pointer bg-blue-400! hover:bg-blue-500! text-white!"
                                            x-on:click="$dispatch('edit-header', { 'id': {{ $header->id }} })">
                                            Edit</flux:button>
                                        <flux:button class="cursor-pointer"
                                            x-on:click="$dispatch('delete-header', { 'id': {{ $header->id }} })"
                                            size="sm" variant="danger" icon="x-mark">
                                            Hapus</flux:button>
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
            {{ $this->listHeader->links() }}
        </div>
    </div>

    {{-- modal create header --}}
    <livewire:flow.create-header />

    {{-- modal edit header --}}
    <livewire:flow.edit-header />

    {{-- modal delete header --}}
    <flux:modal name="delete-header" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete header?</flux:heading>
                <flux:text class="mt-2">
                    <p>Anda yakin akan menghapus data ini ?</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button wire:click="delete" variant="danger">Delete header</flux:button>
            </div>
        </div>
    </flux:modal>

</div>
