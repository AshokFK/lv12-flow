<div>
    <flux:modal name="edit-proses" variant="flyout">
        <form wire:submit.prevent="save" method="post" class="space-y-6">
            <div>
                <flux:heading size="lg">Update proses</flux:heading>
                <flux:text class="mt-2">Isikan data yang diperlukan untuk update proses.</flux:text>
            </div>

            <flux:input wire:model="mastercode" label="Mastercode" placeholder="Mastercode" minlength="14" maxlength="14" />
            <flux:input wire:model="nama" label="Nama" placeholder="Nama proses" />
            <flux:input wire:model="nama_jp" label="Nama JP" placeholder="Nama proses JP" />
            <flux:input wire:model="lokasi" label="Lokasi" placeholder="Lokasi proses" minlength="3" maxlength="3" />
            <flux:radio.group wire:model="level" label="Level proses" variant="segmented">
                <flux:radio label="Level 1" value="1" />
                <flux:radio label="Level 2" value="2" />
                <flux:radio label="Level 3" value="3" />
            </flux:radio.group>
            <flux:switch label="Aktif" align="left" wire:model="is_active" />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
