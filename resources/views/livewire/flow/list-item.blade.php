<div>
    {{-- flash message --}}
    @session('success')
    <div>
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => { show = false }, 5000)" x-transition class="text-green-500 border-green-300 bg-green-50 flex items-center p-2 mb-4 border rounded-lg fixed top-5 right-5" role="alert">
            <flux:icon.check-circle class="w-5 h-5 text-green-500 flex-shrink-0 mr-3" />
            <div class="mx-2">{{ $value ?? 'Lorem ipsum dolor sit amet consectetur adipisicing elit.' }}</div>
        </div>
    </div>
    @endsession

    {{-- heading --}}
    <div class="relative mb-4 w-full">
        <flux:heading size="xl" level="1">Flow Item</flux:heading>
        <flux:separator variant="subtle" />
    </div>

    {{-- flow header detail --}}
    <div class="flex items-center justify-between mb-4">
        <div class="flex flex-wrap items-center gap-2">
            <dl class="flex flex-col items-center gap-4 min-w-3xs bg-gray-100 dark:bg-gray-600 p-1 rounded-lg">
                <dt class="font-normal mb-1 sm:mb-0 text-gray-500 dark:text-gray-400">Kontrak</dt>
                <dd class="font-medium text-accent dark:text-accent-foreground">{{ $header->kontrak }}</dd>
            </dl>
            <dl class="flex flex-col items-center gap-4 min-w-3xs bg-gray-100 dark:bg-gray-600 p-1 rounded-lg">
                <dt class="font-normal mb-1 sm:mb-0 text-gray-500 dark:text-gray-400">Brand</dt>
                <dd class="font-medium text-accent dark:text-accent-foreground">{{ $header->brand }}</dd>
            </dl>
            <dl class="flex flex-col items-center gap-4 min-w-3xs bg-gray-100 dark:bg-gray-600 p-1 rounded-lg">
                <dt class="font-normal mb-1 sm:mb-0 text-gray-500 dark:text-gray-400">Pattern</dt>
                <dd class="font-medium text-accent dark:text-accent-foreground">{{ $header->pattern }}</dd>
            </dl>
            <dl class="flex flex-col items-center gap-4 min-w-3xs bg-gray-100 dark:bg-gray-600 p-1 rounded-lg">
                <dt class="font-normal mb-1 sm:mb-0 text-gray-500 dark:text-gray-400">Style</dt>
                <dd class="font-medium text-accent dark:text-accent-foreground">{{ $header->style }}</dd>
            </dl>
            <dl class="flex flex-col items-center gap-4 min-w-3xs bg-gray-100 dark:bg-gray-600 p-1 rounded-lg">
                <dt class="font-normal mb-1 sm:mb-0 text-gray-500 dark:text-gray-400">Tgl. Berjalan</dt>
                <dd class="font-medium text-accent dark:text-accent-foreground">{{ $header->tgl_berjalan }}</dd>
            </dl>
            <dl class="flex flex-col items-center gap-4 min-w-3xs bg-gray-100 dark:bg-gray-600 p-1 rounded-lg">
                <dt class="font-normal mb-1 sm:mb-0 text-gray-500 dark:text-gray-400">Lokasi</dt>
                <dd class="font-medium text-accent dark:text-accent-foreground">{{ $header->lokasi->deskripsi }}</dd>
            </dl>
            <dl class="flex flex-col items-center gap-4 min-w-3xs bg-gray-100 dark:bg-gray-600 p-1 rounded-lg">
                <dt class="font-normal mb-1 sm:mb-0 text-gray-500 dark:text-gray-400">Proses standard</dt>
                <dd class="font-medium text-accent dark:text-accent-foreground">
                    {{ $header->items->filter(fn($item) => $item->proses_type === 'standar' && $item->itemable_type === 'proses')->count() }}
                </dd>
            </dl>
            <dl class="flex flex-col items-center gap-4 min-w-3xs bg-gray-100 dark:bg-gray-600 p-1 rounded-lg">
                <dt class="font-normal mb-1 sm:mb-0 text-gray-500 dark:text-gray-400">Proses custom</dt>
                <dd class="font-medium text-accent dark:text-accent-foreground">
                    {{ $header->items->filter(fn($item) => $item->proses_type === 'custom' && $item->itemable_type === 'proses')->count() }}
                </dd>
            </dl>
        </div>
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
                    <flux:button size="sm" icon="share" href="{{ route('chart.item', $header) }}">
                        Flow</flux:button>
                    <flux:modal.trigger name="create-item">
                        <flux:button size="sm" variant="outline" icon="plus" class="cursor-pointer">Tambah</flux:button>
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
                                    <button type="button" class="flex items-center justify-between w-full cursor-pointer text-sm font-semibold text-left uppercase" wire:click="sortBy('itemable_type')">
                                        {{-- Type --}}
                                        Type
                                        @if ($sortColumn === 'itemable_type')
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
                                    <button type="button" class="flex items-center justify-between w-full cursor-pointer text-sm font-semibold text-left uppercase" wire:click="sortBy('nama')">
                                        Nama item
                                        @if ($sortColumn === 'nama')
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
                                <th scope="col" class="p-2 text-sm">Operator</th>
                                <th scope="col" class="p-2 text-sm">Mesin</th>
                                <th scope="col" class="p-2 text-sm">Next</th>
                                <th scope="col" class="p-2 text-sm"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($this->listItem as $item)
                            <tr class="">
                                <td class="p-2 text-sm whitespace-nowrap">
                                    <span class="font-medium capitalize">{{ $item->itemable_type }}</span>
                                    @if ($item->itemable_type === 'proses' || $item->itemable_type === 'komponen')
                                    {{-- jika itemable adalah proses, tampilkan badge proses type --}}
                                    <flux:badge @class([ '!bg-lime-300'=> $item->proses_type === 'standar',
                                        '!bg-amber-300' => $item->proses_type === 'custom',
                                        ]) size="sm">
                                        {{ $item->proses_type }}
                                    </flux:badge>
                                    @endif
                                </td>
                                <td class="p-2 text-base font-medium whitespace-nowrap">
                                    <div class="flex flex-row items-center gap-2">
                                        {{-- jika itemable adalah proses, tampilkan mastercode --}}
                                        @if($item->itemable->mastercode)
                                        <flux:badge size="sm" color="blue">
                                            {{ $item->itemable->mastercode }}
                                        </flux:badge>
                                        @endif
                                        {{-- jika itemable adalah komponen, tampilkan type --}}
                                        @if($item->itemable_type === 'komponen')
                                        <flux:badge size="sm" @class([ '!bg-blue-400'=> $item->itemable->type === 'bahan',
                                            '!bg-yellow-500' => $item->itemable->type === 'tim',
                                            ])>
                                            {{ $item->itemable->type }}
                                        </flux:badge>
                                        @endif
                                        <span class="text-sm font-semibold">
                                            {{-- nama item --}}
                                            {{ $item->itemable->nama }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-2 text-base font-medium whitespace-nowrap">
                                    @if ($item->operator)
                                    @foreach (App\Models\Operator::whereIn('nik', $item->operator)->get() as $operator)
                                    <div class="flex-col items-center gap-1 mb-1">
                                        <flux:badge size="sm" color="blue">
                                            {{ $operator->nik }}
                                        </flux:badge>
                                        <span class="text-sm font-semibold">
                                            {{ $operator->nama }}
                                        </span>
                                    </div>
                                    @endforeach
                                    @else
                                    <span class="text-gray-500">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="p-2 text-base font-medium whitespace-nowrap">
                                    @if ($item->mesin)
                                    @foreach (App\Models\Mesin::whereIn('id', $item->mesin)->get() as $mesin)
                                    <flux:badge size="sm">
                                        {{ $mesin->kode }}
                                    </flux:badge>
                                    @endforeach
                                    @else
                                    <span class="text-gray-500">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="p-2 text-base font-medium whitespace-nowrap">
                                    @if ($item->next_to)
                                    @foreach (App\Models\FlowItem::whereIn('id', $item->next_to)->get() as $next)
                                    <div class="flex-col items-center gap-1 mb-1">
                                        <flux:badge size="sm" class="!text-xs !px-1" @class([ '!bg-blue-400'=> $next->itemable_type === 'komponen',
                                            '!bg-indigo-400' => $next->itemable_type === 'proses',
                                            '!bg-rose-400' => $next->itemable_type === 'qc',
                                            ])>
                                            {{ $next->itemable_type }}
                                        </flux:badge>
                                        <span class="text-sm font-semibold">
                                            {{ $next->itemable->nama }}
                                        </span>
                                    </div>
                                    @endforeach
                                    @else
                                    <span class="text-gray-500">Tidak ada</span>
                                    @endif
                                <td class="p-2 space-x-2 whitespace-nowrap text-right">
                                    <flux:button size="sm" icon="pencil-square" iconVariant="mini" class="bg-blue-400! hover:bg-blue-500! text-white!" x-on:click="$dispatch('edit-item', { 'id': {{ $item->id }} })">
                                        Edit
                                    </flux:button>
                                    <flux:button x-on:click="$dispatch('delete-item', { 'id': {{ $item->id }} })" size="sm" variant="danger" icon="x-mark" iconVariant="mini">
                                        Hapus
                                    </flux:button>
                                </td>
                            </tr>
                            @empty
                            <tr class="border-b">
                                <td class="p-2 text-base font-medium text-center text-accent" colspan="4">Tidak
                                    ada data untuk ditampilkan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <!-- pagination -->
        <div class="sticky bottom-0 right-0 items-center w-full py-4 bg-white border-t border-gray-200 dark:bg-accent-foreground">
            {{ $this->listItem->links() }}
        </div>
    </div>

    {{-- modal create item --}}
    <livewire:flow.create-item :$header />

    {{-- modal edit item --}}
    <livewire:flow.edit-item :$header />

    {{-- modal delete item --}}
    <flux:modal name="delete-item" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete item?</flux:heading>
                <flux:text class="mt-2">
                    <p>Anda yakin akan menghapus item ini ?</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button wire:click="delete" variant="danger">Delete item</flux:button>
            </div>
        </div>
    </flux:modal>

</div>
