<div>
    <flux:modal name="create-item" variant="flyout" class="max-w-[22rem]">
        <form wire:submit.prevent="save" method="post" class="space-y-6">
            <div>
                <flux:heading size="lg">Tambah flow item</flux:heading>
                <flux:text class="mt-2">Isikan data yang diperlukan untuk menambah item baru.</flux:text>
            </div>

            <flux:radio.group wire:model.live="itemable_type" label="Item type" variant="segmented">
                <flux:radio label="Komponen" value="komponen" />
                <flux:radio label="Proses" value="proses" />
                <flux:radio label="QC" value="qc" />
            </flux:radio.group>

            <flux:field>
                <flux:label>Pilih item {{ $itemable_type }}..</flux:label>
                <x-tom-select wire:model="itemable_id" x-init="$el.itemable_id = new TomSelect($el, { 
                    valueField: 'id',
                    labelField: 'nama',
                    searchField: 'nama',
                    create: false,
                    placeholder: 'Cari item...',
                    shouldLoad:function(query) {
                        // minimum query length
                        return query.length > 2;
                    },
                    load: (query, callback) => {
                        if (!query.length) return callback([]);
                        $wire.fetchItems(query).then(items => {
                            callback(items);
                        }).catch(error => {
                            console.error('Error loading items:', error);
                            callback([]);
                        });
                    },
                    render: {
                        item: (data, escape) => {
                            if (data.type === undefined && data.mastercode === undefined) {
                                return `<div>
                                    <span class='block font-bold text-md'>${escape(data.nama)}</span>
                                </div>`;
                            }
                            let subtitle = data.type===undefined ? escape(data.mastercode) : data.mastercode===undefined ? escape(data.type) : '';
                            return `<div>
                                <span class='text-xs text-gray-500'>${subtitle ?? ''}</span>
                                <span class='font-bold text-md'>${escape(data.nama)}</span>
                            </div>`
                        },
                        option: (data, escape) => {
                            if (data.type === undefined && data.mastercode === undefined) {
                                return `<div>
                                    <span class='block font-bold text-md'>${escape(data.nama)}</span>
                                </div>`;
                            }
                            let subtitle = data.type===undefined ? escape(data.mastercode) : data.mastercode===undefined ? escape(data.type) : '';
                            return `<div>
                                <span class='block font-bold text-md'>${escape(data.nama)}</span> 
                                <span class='text-xs text-gray-500'>${subtitle ?? ''}</span>
                            </div>`
                        }
                    },
                })" x-on:item-type-selected.window="
                    $el.itemable_id.setValue('');
                    $el.itemable_id.clearOptions();
                    $el.itemable_id.clear();
                "></x-tom-select>
                <flux:error name="itemable_id" />
            </flux:field>

            {{-- operator, muncul jika item type: proses, qc --}}
            @if($itemable_type == 'proses' OR $itemable_type == 'qc')
            <flux:field>
                <flux:label>Operator</flux:label>
                <x-tom-select wire:model="operator" class="w-full" x-init="$el.operator = new TomSelect($el, { 
                    valueField: 'jsonValue',
                    labelField: 'nama',
                    searchField: ['nik','nama'],
                    create: false,
                    placeholder: 'Cari nik atau nama...',
                    plugins: ['remove_button'],
                    shouldLoad:function(query) {
                        // minimum query length
                        return query.length > 2;
                    },
                    load: (query, callback) => {
                        if (!query.length) return callback([]);
                        $wire.fetchOperator(query).then(items => {
                            // callback(items);
                            const transformed = items.map(item => ({
                                ...item,
                                jsonValue: JSON.stringify({ nik: item.nik, nama: item.nama }) // tambahkan properti jsonValue
                            }));
                            console.log('Loaded items:', transformed);
                            callback(transformed);
                        }).catch(error => {
                            console.error('Error loading items:', error);
                            callback([]);
                        });
                    },
                    render: {
                        item: (data, escape) => {
                            return `<div>
                                <span class='text-xs text-gray-500'>${escape(data.nik)}</span>
                                <span class='font-bold text-md'>${escape(data.nama)}</span>
                            </div>`
                        },
                        option: (data, escape) => {
                            return `<div>
                                <span class='block font-bold text-md'>${escape(data.nama)}</span> 
                                <span class='text-xs text-gray-500'>${escape(data.nik)}</span>
                            </div>`
                        }
                    },
                })" x-on:item-type-selected.window="
                    $el.operator.setValue('');
                    $el.operator.clearOptions();
                    $el.operator.clear();
                " multiple></x-tom-select>
                <flux:error name="operator" />
            </flux:field>
            @endif

            {{-- muncul hanya untuk item type: proses --}}
            @if($itemable_type == 'proses')
            <flux:radio.group wire:model="proses_type" label="Type proses" variant="segmented">
                <flux:radio label="Standar" value="standar" />
                <flux:radio label="Custom" value="custom" />
            </flux:radio.group>

            <flux:field>
                <flux:label>Mesin</flux:label>
                <x-tom-select wire:model="mesin" class="w-full" x-init="$el.mesin = new TomSelect($el, { 
                    valueField: 'id',
                    labelField: 'nama',
                    searchField: ['kode','nama','deskripsi'],
                    create: false,
                    placeholder: 'Cari mesin...',
                    plugins: ['remove_button'],
                    shouldLoad:function(query) {
                        // minimum query length
                        return query.length > 2;
                    },
                    load: (query, callback) => {
                        if (!query.length) return callback([]);
                        $wire.fetchMesin(query).then(items => {
                            callback(items);
                        }).catch(error => {
                            console.error('Error loading items:', error);
                            callback([]);
                        });
                    },
                    render: {
                        item: (data, escape) => {
                            return `<div>
                                <span class='font-bold text-md pe-1'> ${escape(data.kode)} </span> 
                                <span class='text-xs text-gray-500'> ${escape(data.nama)} </span>
                            </div>`
                        },
                        option: (data, escape) => {
                            return `<div>
                                <span class='font-bold text-md'>${escape(data.kode)}</span> 
                                <span class='text-xs'>${escape(data.nama)}</span>
                                <span class='block font-bold text-sm text-gray-500'>${escape(data.deskripsi)}</span>
                            </div>`
                        }
                    },
                })" x-on:item-type-selected.window="
                    $el.mesin.setValue('');
                    $el.mesin.clearOptions();
                    $el.mesin.clear();
                " multiple></x-tom-select>
                <flux:error name="operator" />
            </flux:field>
            @endif

            <flux:field>
                <flux:label>Next item</flux:label>
                <x-tom-select wire:model="next_to" class="w-full" x-init="$el.next_to = new TomSelect($el, { 
                    valueField: 'id',
                    labelField: 'nama',
                    searchField: ['nama'],
                    create: false,
                    placeholder: 'Cari flow item selanjutnya...',
                    plugins: ['remove_button'],
                    optgroupField: 'itemable_type',
                    optgroupLabelField: 'label',
                    optgroupValueField: 'value',
                    optgroups: [
                        { value: 'komponen', label: 'Komponen'},
                        { value: 'proses', label: 'Proses'},
                        { value: 'qc', label: 'QC'}
                    ],

                    shouldLoad:function(query) {
                        // minimum query length
                        return query.length > 2;
                    },
                    load: (query, callback) => {
                        if (!query.length) return callback([]);
                        $wire.fetchNextItems(query).then(items => {
                            // group items by itemable_type
                            items = items.reduce((acc, item) => {
                                acc.push({ 
                                    id: item.id, 
                                    itemable_type: item.itemable_type, 
                                    nama: item.itemable.nama, 
                                    komponen_type: item.itemable.type, 
                                    mastercode: item.itemable.mastercode
                                });
                                return acc;
                            }, []);
                            callback(items);
                        }).catch(error => {
                            console.error('Error loading items:', error);
                            callback([]);
                        });
                    },
                    render: {
                        optgroup_header: function(data, escape) {
                            return `<div class='px-2 py-1 font-bold bg-gray-200 text-gray-800'>${escape(data.label)}</div>`;
                        },
                        item: (data, escape) => {
                            return `<div>
                                <span class='text-xs text-gray-500 uppercase pe-1'>${escape(data.itemable_type)}</span> 
                                <span class='text-md font-bold'>${escape(data.nama)}</span>
                            </div>`
                        },
                        option: (data, escape) => {
                            let subtitle = data.mastercode ? escape(data.mastercode) : data.komponen_type ? escape(data.komponen_type) : '';
                            return `<div>
                                <span class='text-xs'>${subtitle}</span>
                                <span class='block font-bold text-sm '>${escape(data.nama)}</span>
                            </div>`
                        }
                    },
                })" x-on:item-type-selected.window="
                    $el.next_to.setValue('');
                    $el.next_to.clearOptions();
                    $el.next_to.clear();
                " multiple></x-tom-select>
                <flux:error name="operator" />
            </flux:field>

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
