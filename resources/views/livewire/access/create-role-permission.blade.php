<div>
    <flux:modal name="create-role-permission" variant="flyout" class="max-w-[25rem]">
        <form wire:submit.prevent="save" method="post" class="space-y-6">
            <div>
                <flux:heading size="lg">Tambah Role</flux:heading>
                <flux:text class="mt-2">Isikan nama role dan pilih permission yang sesuai.</flux:text>
            </div>

            <flux:input wire:model="name" label="Role" placeholder="Nama role" />

            <flux:field>
                <flux:label>Permission</flux:label>
                <x-tom-select wire:model="permissions" x-init="$el.permissions = new TomSelect($el, { 
                    valueField: 'name',
                    labelField: 'name',
                    searchField: ['name'],
                    create: false,
                    placeholder: 'pilih permission...',
                    plugins: ['remove_button'],
                    options: {{ $listPermission }},
                })" multiple></x-tom-select>
                <flux:error name="permissions" />
            </flux:field>

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
