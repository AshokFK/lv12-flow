<div>
    <flux:modal name="create-role-permission" variant="flyout" class="max-w-[25rem]">
        <form wire:submit.prevent="save" method="post" class="space-y-6">
            <div>
                <flux:heading size="lg">Tambah Role</flux:heading>
                <flux:text class="mt-2">Isikan nama role dan pilih permission yang sesuai.</flux:text>
            </div>

            <flux:input wire:model="name" label="Role" placeholder="Nama role" />

            @if($listPermission)
            <flux:fieldset>
                <flux:legend>Permission</flux:legend>
                <flux:description class="mb-0!">Pilih permission yang sudah dikelompokkan sesuai modul action.</flux:description>

                    @foreach($listPermission as $key => $group)
                    <flux:checkbox.group class="my-1! py-1!" wire:model="permissions">
                        <flux:label class="font-bold! capitalize">{{ $group['group'] }}</flux:label>
                        @foreach($group['permissions'] as $permission)
                        <flux:checkbox value="{{ $permission['name'] }}" label="{{ $permission['name'] }}" class="" />
                        @endforeach 
                    </flux:checkbox.group>
                    @endforeach
            </flux:fieldset>
            @endif

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
