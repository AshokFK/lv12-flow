<div>
    <flux:modal name="user-assign-role" variant="flyout" class="max-w-[25rem]">
        <form wire:submit.prevent="save" method="post" class="space-y-6">
            <div>
                <flux:heading size="lg">Assign role</flux:heading>
                <flux:text class="mt-2">Pilih role yang sesuai untuk user.</flux:text>
            </div>

            <flux:input disabled wire:model="nik" label="NIK" placeholder="NIK" />
            <flux:input disabled wire:model="name" label="Nama" placeholder="Nama" />

            <flux:radio.group wire:model="role" label="Pilih role untuk user">
            @foreach($listRole as $rl)
                <flux:radio value="{{ $rl->id }}" label="{{ $rl->name }}" />
            @endforeach
            </flux:radio.group>

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
