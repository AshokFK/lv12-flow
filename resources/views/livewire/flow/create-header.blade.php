<div>
    <flux:modal name="create-header" variant="flyout">
        <form wire:submit.prevent="save" method="post" class="space-y-6">
            <div>
                <flux:heading size="lg">Tambah header</flux:heading>
                <flux:text class="mt-2">Isikan data yang diperlukan untuk menambah header baru.</flux:text>
            </div>

            <flux:input wire:model="kontrak" label="Kontrak" placeholder="Nomor kontrak" />
            <flux:input wire:model="brand" label="Brand" placeholder="Nama brand" />
            <flux:input wire:model="pattern" label="Pattern" placeholder="Kode pattern" />
            <flux:input wire:model="style" label="Style" placeholder="Nomor style" />
            <flux:input wire:model="tgl_berjalan" label="Tanggal berjalan" placeholder="Tanggal kontrak berjalan" type="date" />
            <flux:input wire:model="lokasi" label="Lokasi" placeholder="Lokasi line" />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
