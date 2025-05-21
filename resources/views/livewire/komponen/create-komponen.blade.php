<div>
    <flux:modal name="create-komponen" variant="flyout">
        <form wire:submit.prevent="save" method="post" class="space-y-6">
            <div>
                <flux:heading size="lg">Tambah komponen</flux:heading>
                <flux:text class="mt-2">Isikan data yang diperlukan untuk menambah komponen baru.</flux:text>
            </div>

            <flux:input wire:model="nama" label="Nama" placeholder="Nama komponen" />
            <flux:radio.group wire:model="type" label="Type komponen" variant="segmented">
                <flux:radio label="Tim" value="tim" />
                <flux:radio label="Bahan" value="bahan" />
            </flux:radio.group>

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
