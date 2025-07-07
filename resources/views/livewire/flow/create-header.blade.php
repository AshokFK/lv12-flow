<div>
    <flux:modal name="create-header" variant="flyout">
        <form wire:submit.prevent="save" method="post" class="space-y-6">
            <div>
                <flux:heading size="lg">Tambah header</flux:heading>
                <flux:text class="mt-2">Isikan data yang diperlukan untuk menambah header baru.</flux:text>
            </div>

            <flux:input wire:model="kontrak" label="Kontrak" placeholder="Nomor kontrak" maxlength="7" minlength="7" />
            <flux:input wire:model="brand" label="Brand" placeholder="Nama brand" />
            <flux:input wire:model="pattern" label="Pattern" placeholder="Kode pattern" />
            <flux:input wire:model="style" label="Style" placeholder="Nomor style" />
            <flux:input wire:model="tgl_berjalan" label="Tanggal berjalan" placeholder="Tanggal kontrak berjalan" type="date" />
            
            <flux:field>
                <flux:label>Lokasi</flux:label>
                <x-tom-select wire:model="lokasi_id" x-init="$el.lokasi_id = new TomSelect($el, { 
                    valueField: 'id',
                    labelField: 'nama',
                    searchField: ['nama', 'sub', 'deskripsi'],
                    create: false,
                    placeholder: 'Cari lokasi...',
                    shouldLoad:function(query) {
                        // minimum query length
                        return query.length > 2;
                    },
                    load: (query, callback) => {
                        if (!query.length) return callback([]);
                        $wire.fetchLokasi(query).then(items => {
                            callback(items);
                        }).catch(error => {
                            console.error('Error loading items:', error);
                            callback([]);
                        });
                    },
                    render: {
                        item: (data, escape) => {
                            return `<div>
                                <span class='font-bold text-md'>${escape(data.deskripsi)}</span>
                            </div>`
                        },
                        option: (data, escape) => {
                            return `<div>
                                <span class='font-bold text-md'>${escape(data.nama)}</span> 
                                <span class='text-xs'>${escape(data.sub ?? '')}</span>
                                <span class='block font-bold text-sm text-gray-500'>${escape(data.deskripsi)}</span>
                            </div>`
                        }
                    },
                    onChange: (value) => {
                        $wire.set('lokasi_id', value);
                    }
                })"></x-tom-select>
                <flux:error name="lokasi_id" />
            </flux:field>

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
