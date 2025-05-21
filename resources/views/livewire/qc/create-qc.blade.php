<div>
    <flux:modal name="create-qc" variant="flyout">
        <form wire:submit.prevent="save" method="post" class="space-y-6">
            <div>
                <flux:heading size="lg">Tambah QC</flux:heading>
                <flux:text class="mt-2">Isikan data yang diperlukan untuk menambah proses QC baru.</flux:text>
            </div>

            <flux:input wire:model="nama" label="Nama" placeholder="Nama proses QC" />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
