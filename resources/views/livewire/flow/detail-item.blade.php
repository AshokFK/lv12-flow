<div>
    <flux:modal name="detail-item" variant="flyout" class="max-w-[22rem] flex flex-col">

        <!-- Header / Form Section -->
        <div class="space-y-6 flex-1">
            <div>
                <flux:heading size="lg">Detail flow item</flux:heading>
            </div>
            <form wire:submit.prevent="save" method="post">

                <flux:field>
                    <flux:label>Item type</flux:label>
                    <flux:input readonly size="sm" value="{{ $item?->proses_type }} {{ $item?->itemable_type }}" />

                    <flux:label>Nama item</flux:label>
                    <flux:input readonly size="sm" value="{{ $item?->itemable->nama }}" />
                    @if($item?->itemable_type === 'komponen')
                    <flux:label>Type komponen</flux:label>
                    <flux:input readonly size="sm" value="{{ $item?->itemable->type }}" />
                    @endif
                    @if($item?->itemable_type === 'proses')
                    <flux:label>Mastercode</flux:label>
                    <flux:input readonly size="sm" value="{{ $item?->itemable->mastercode }}" />
                    @endif
                </flux:field>
            </form>
        </div>

        <!-- Footer / Action Buttons -->
        <div class="p-2">
            <flux:separator class="mb-2" />
            @if($item && $item->itemable_type === 'proses')
            <flux:button size="sm" variant="outline" icon="plus" tooltip="Tambahkan masalah untuk proses ini" class="cursor-pointer" x-on:click="
                    $flux.modal('create-masalah').show();
                    $dispatch('create-masalah', { item: {{ $item->id }} })
            ">
                Masalah
            </flux:button>
            @endif
        </div>
    </flux:modal>
</div>
