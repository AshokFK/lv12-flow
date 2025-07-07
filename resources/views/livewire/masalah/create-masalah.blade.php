<div>
    <flux:modal name="create-masalah" variant="flyout">
        <form wire:submit.prevent="save" method="post" class="space-y-6">
            <div>
                <flux:heading size="lg">Tambah masalah</flux:heading>
                <flux:text class="mt-2">Isikan data yang diperlukan untuk menambah masalah baru.</flux:text>
            </div>

            <flux:input disabled wire:model="flowItemId" label="Flow Item ID" placeholder="Flow Item ID" />

            <flux:field>
                <flux:label>Nama item</flux:label>
                <x-tom-select disabled x-init="$el.itemable_id = new TomSelect($el, { 
                    valueField: 'id',
                    labelField: 'nama',
                    placeholder: 'Cari item...',
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
                })"
                x-on:init-selected.window="
                $el.itemable_id.addOption($event.detail.item_data);
                $el.itemable_id.setValue($event.detail.item_data.id);
                "></x-tom-select>
            </flux:field>

            <flux:radio.group wire:model="type" label="Type masalah" variant="segmented">
                <flux:radio label="Orang" value="orang" />
                <flux:radio label="Mesin" value="mesin" />
                <flux:radio label="Material" value="material" />
            </flux:radio.group>
            <flux:textarea wire:model="deskripsi" rows="auto" label="Deskripsi" placeholder="Jelaskan tentang masalah yang terjadi..." />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
